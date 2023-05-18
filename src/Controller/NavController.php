<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class NavController extends Controller
{
    public function homepage()
    {
        $this->twig->display('/homepage.html.twig');
    }

    public function index()
    {
        $posts = new PostRepository();
        $posts = $posts->index();
        
        foreach ($posts as $post) {
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);
        }
        $this->twig->display('/posts/index.html.twig', ['posts' => $posts, 'user' => $user]);
    }

    public function show($id)
    {
        $post = new PostRepository();
        $post = $post->show($id);
        $userId = $post->user_id;
        $user = $post->getAuthorName($userId);
        $comments = new CommentRepository();
        $comments = $comments->getCommentFromPost($post->id);
        //var_dump($comments);
        $commentsWithAuthors = [];
        foreach ($comments as $comment) {
            if ($comment['published'] == 1) {
                $userId = $comment['user_id'];
                $author = new UserRepository();
                $authors = $author->getOne($userId);
                array_push($commentsWithAuthors, [$comment, 'author' => $authors['username']]);
            }
        }
        $this->twig->display('/posts/show.html.twig', ['post' => $post, 'user' => $user, 'commentsWithAuthors' => $commentsWithAuthors]);
    }

    public function admin()
    {
        $this->twig->display('/admin/connection.html.twig');
    }

    public function mail()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        if ($name == '' || $email == '' || $message == '') {
            //var_dump($name, $email, $message);
            $error = 'Merci de bien vouloir remplir tous les champs du formulaire.';
            $this->twig->display('homepage.html.twig', ['error' => $error]);
        } else {
            $mail = new PHPMailer(true);
            $success = 'Mail envoyé avec succès !';
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'localhost';
                $mail->Port = 1025;

                $mail->setFrom($email, $name);
                $mail->addAddress('contact@blogpro.fr');

                $mail->isHTML(true);
                $mail->Subject = "Demande de renseignements";
                $mail->Body = $message;

                $mail->send();
                $this->twig->display('homepage.html.twig', ['error' => $success]);
            } catch (Exception $e) {
                echo "Message non envoyé : {$mail->ErrorInfo}";
            }
        }
    }
}
