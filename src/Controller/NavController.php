<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Mail\Mail;
use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use David\Blogpro\Session\Session;

class NavController extends Controller
{
    /***
     * This function is called to display the homepage
     *
     * @return homepage
     */
    public function homepage()
    {
        $this->twig->display('/homepage.html.twig');
    }

    /***
     * This function is called to display the page listing all the posts
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

    /***
     * This function is called when the user wants to read a post
     *
     * @param integer $postId the id of the post
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

    /***
     * This function is called when the user clicks on the connection link in the footer
     */
    public function admin(): void
    {
        $session = new Session();
        $session->destroy('errors');
        $session->destroy('message');
        $this->twig->display('/admin/connection.html.twig');
    }

    /***
     * This fonction is called when the user fills in the form to send an email
     */
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
        if ($mail === true) {
            $success = 'Mail envoyé avec succès !';
            $this->twig->display('homepage.html.twig', ['success' => $success]);
        }
    }
}
