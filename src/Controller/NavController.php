<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Mail\Mail;
use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use David\Blogpro\Session\Session;

/**
 * The NavController handles the public part of the site
 */
class NavController extends Controller
{
    /**
     * Displays the homepage
     *
     * @return homepage
     */
    public function homepage()
    {
        $this->twig->display('/homepage.html.twig');
    }

    /**
     * Displays all the posts
     *
     * @return void
     */
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

    /**
     * Displays a post
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function show(int $postId): void
    {
        $post = new PostRepository();
        $post = $post->getOneById($postId);
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

    /**
     * Displays the connection page
     *
     * @return void
     */
    public function admin(): void
    {
        $session = new Session();
        $session->destroy('errors');
        $session->destroy('message');
        $this->twig->display('/admin/connection.html.twig');
    }

    /**
     * Sends an email
     *
     * @return void
     */
    public function mail(): void
    {
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
            $name = htmlspecialchars($_POST['name']);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $message = htmlspecialchars($_POST['message']);
        }
        if ($email === false || trim($name) === '' || trim($email) === '' || trim($message) === '') {
            $error = 'Merci de bien vouloir remplir tous les champs du formulaire ou de fournir une adresse email valide.';
            $this->twig->display('homepage.html.twig', ['error' => $error]);
        }
        $mail = new Mail();
        $mail = $mail->send($name, $email, $message);
        if ($mail === true) {
            $success = 'Mail envoyé avec succès !';
            $this->twig->display('homepage.html.twig', ['success' => $success]);
        }
    }
}
