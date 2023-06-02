<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Mail\Mail;
use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use David\Blogpro\Session\Session;

class NavController extends Controller
{
    public function homepage()
    {
        $this->twig->display('/homepage.html.twig');
    }

    public function index(): void
    {
        $posts = new PostRepository();
        $posts = $posts->index();
        foreach ($posts as $post) {
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);
        }
        $this->twig->display('/posts/index.html.twig', ['posts' => $posts, 'user' => $user]);
    }

    public function show(int $post_id): void
    {
        $post = new PostRepository();
        $post = $post->getOneById($post_id);
        $userId = $post->user_id;
        $user = $post->getAuthorName($userId);
        $comments = new CommentRepository();
        $comments = $comments->getCommentFromPost($post->id);
        $commentsWithAuthors = [];
        foreach ($comments as $comment) {
            if ($comment['published'] === 1) {
                $userId = $comment['user_id'];
                $author = new UserRepository();
                $authors = $author->getOne($userId);
                array_push($commentsWithAuthors, [$comment, 'author' => $authors['username']]);
            }
        }
        $this->twig->display('/posts/show.html.twig', ['post' => $post, 'user' => $user, 'commentsWithAuthors' => $commentsWithAuthors]);
    }

    public function admin(): void
    {
        $session = new Session();
        $session->destroy('errors');
        $session->destroy('message');
        $this->twig->display('/admin/connection.html.twig');
    }

    public function mail(): void
    {
        if ($_POST['name'] !== null && $_POST['email'] !== null && $_POST['message'] !== null) {
            $name = $_POST['name'];
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $message = $_POST['message'];
        }
        
        if (trim($name) === '' || trim($email) === '' || trim($message) === '') {
            $error = 'Merci de bien vouloir remplir tous les champs du formulaire.';
            $this->twig->display('homepage.html.twig', ['error' => $error]);
        }
        $mail = new Mail();
        $mail = $mail->send($name, $email, $message);
        if ($mail) {
            $success = 'Mail envoyé avec succès !';
            $this->twig->display('homepage.html.twig', ['success' => $success]);
        }
    }
}
