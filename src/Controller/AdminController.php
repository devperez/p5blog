<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use David\Blogpro\Session\Session;

class AdminController extends Controller
{
    public function signup()
    {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']);
        $passwordConfirm = sha1($_POST['passwordConfirm']);
        $usernameLength = strlen($username);

        if (isset($username) && isset($email) && isset($password) && isset($passwordConfirm)) {
            if ($usernameLength <= 255) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($password === $passwordConfirm) {
                        $user = new UserRepository();
                        $user = $user->create($username, $email, $password);
                        $session = new Session();
                        $session->destroy('errors');
                        $session = $session->start('message', ['message' => 'Votre compte a bien été créé, vous pouvez vous connecter.']);
                        header('Location: /?url=admin');
                    } else {
                        $session = new Session();
                        $session->destroy('errors');
                        $session = $session->start('errors', ['errors' => 'La confirmation du mot de passe a échoué.']);
                        // $this->twig->display('/admin/connection.html.twig');
                    }
                } else {
                    $session = new Session();
                    $session->destroy('errors');
                    $session = $session->start('errors', ['errors' => 'Votre adresse email n\'est pas valide.']);
                    // $this->twig->display('/admin/connection.html.twig');
                }
            } else {
                $session = new Session();
                $session->destroy('errors');
                $session = $session->start('errors', ['errors' => 'Votre nom d\'utilisateur n\'est pas valide.']);
                // $this->twig->display('/admin/connection.html.twig');
            }
        } else {
            $session = new Session();
            $session->destroy('errors');
            $session = $session->start('errors', ['errors' => 'Merci de bien vouloir compléter le formulaire en entier.']);
            // $this->twig->display('/admin/connection.html.twig');
            //exit();
        }

        if (!isset($user) || is_null($user) || $user = false) {
            $session = new Session();
            $session->destroy('errors');
            $session = $session->start('errors', ['errors' => 'Cette adresse email est déjà utilisée.']);
            // $this->twig->display('/admin/connection.html.twig');
        }
        $this->twig->display('/admin/connection.html.twig');
    }

    public function signin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);
            $user = new UserRepository();
            $user = $user->signin($email, $password);
            if ($user == false) {
                $this->twig->display('/admin/connection.html.twig');
            } else {
                switch ($user['role']) {
                    case 'admin':
                        $session = new Session();
                        $session = $session->start('user', ['username' => $user['username'], 'id' => $user['id'], 'role' => $user['role']]);
                        $posts = new PostRepository();
                        $posts = $posts->index();
                        foreach ($posts as $post) {
                            $userId = $post->user_id;
                            $user = $post->getAuthorName($userId);
                        }
                        $this->twig->display('/admin/index.html.twig', ['posts' => $posts, 'user' => $user, 'session' => $session]);
                        break;
                    case 'registered':
                        $session = new Session();
                        $session = $session->start('user', ['username' => $user['username'], 'id' => $user['id'], 'role' => $user['role']]);
                        $this->twig->display('/homepage.html.twig', ['session' => $session]);
                        break;
                    default:
                        $this->twig->display('/admin/connection.html.twig');
                }
            }
        } else {
            $session = new Session();
            $session->destroy('errors');
            $session = $session->start('errors', ['errors' => 'Merci de bien vouloir remplir tous les champs du formulaire.']);
            $this->twig->display('/admin/connection.html.twig');
        }
    }

    public function write(): void
    {
        $this->twig->display('/admin/write.html.twig');
    }

    public function index(): void
    {
        $posts = new PostRepository();
        $posts = $posts->index();
        foreach ($posts as $post) {
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);
        }
        $this->twig->display('/admin/index.html.twig', ['posts' => $posts, 'user' => $user]);
    }

    public function publish(): void
    {
        if ($_POST['title'] && $_POST['subtitle'] && $_POST['content'] && $_POST['userId']) {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $article = $_POST['content'];
            $userId = $_POST['userId'];
            if (strlen($title) < 255) {
                $post = new PostRepository();
                $post = $post->create($title, $subtitle, $article, $userId);
            }
            header('Location: /?url=indexAdmin');
        }
    }

    public function edit(int $id): void
    {
        $post = new PostRepository();
        $post = $post->show($id);
        $this->twig->display('/admin/edit.html.twig', ['post' => $post]);
    }

    public function editPost(int $id): void
    {
        if ($_POST['title'] && $_POST['subtitle'] && $_POST['content']) {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $article = $_POST['content'];
            if (strlen($title) < 255) {
                $post = new PostRepository();
                $post = $post->update($id, $title, $subtitle, $article);
            }
        }
        header('Location: /?url=indexAdmin');
    }

    public function deletePost(int $id): void
    {
        $post = new PostRepository();
        $post = $post->deletePost($id);
    
        header('Location: /?url=indexAdmin');
    }

    public function readPost(int $id): void
    {
        $post = new PostRepository();
        $post = $post->show($id);
        $userId = $post->user_id;
        $user = $post->getAuthorName($userId);
        
        $this->twig->display('/admin/read.html.twig', ['post' => $post, 'user' => $user]);
    }

    public function logout(): void
    {
        $session = new Session();
        $session = session_destroy();
        header('Location: /?url=');
    }

    public function comment(): void
    {
        $commentContent = htmlspecialchars($_POST['comment']);
        $userId = htmlspecialchars($_POST['userId']);
        $postId = htmlspecialchars($_POST['postId']);
        if (!empty($commentContent) && strlen($commentContent) < 500) {
            $comment = new CommentRepository();
            $comment = $comment->create($commentContent, $userId, $postId);
        }
        $this->twig->display('/posts/index.html.twig', ['comment' => 'Votre commentaire a bien été enregistré. Il sera publié après modération.']);
    }

    public function commentIndex(): void
    {
        $comments = new CommentRepository();
        $comments = $comments->index();
        $users = new UserRepository();
        $posts = new PostRepository();
        $commentsArray = [];
        foreach ($comments as $comment) {
            $userId = $comment['user_id'];
            $postId = $comment['post_id'];
            $post = $posts->show($postId);
            $user = $users->getOne($userId);
            array_push($commentsArray, ['post' => $post->title, 'user' => $user['username'], 'comment' => $comment]);
        }
        $this->twig->display('/admin/comments.html.twig', ['commentsArray' => $commentsArray, 'comments' => $comments, 'post' => $post, 'user' => $user]);
    }

    public function readComment(int $id): void
    {
        $comment = new CommentRepository();
        $comment = $comment->show($id);
        $user = new UserRepository();
        $user = $user->getOne($comment['user_id']);
        $post = new PostRepository();
        $post = $post->show($comment['post_id']);
        
        $this->twig->display('/admin/commentShow.html.twig', ['comment' => $comment, 'user' => $user, 'post' => $post]);
    }

    public function publishComment(int $id): void
    {
        $comment = new CommentRepository();
        $comment = $comment->show($id);
        $commentId = $comment['id'];
        $comment = new CommentRepository();
        $comment = $comment->publish($commentId);

        header('Location: /?url=commentIndex');
    }

    public function deleteComment(int $id): void
    {
        $comment = new CommentRepository();
        $comment = $comment->show($id);
        $commentId = $comment['id'];
        $comment = new CommentRepository();
        $comment = $comment->delete($commentId);

        header('Location: /?url=commentIndex');
    }
}
