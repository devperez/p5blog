<?php

namespace David\Blogpro\Controller;

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
        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
            if ($usernameLength <= 255) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($password === $passwordConfirm) {
                        $user = new UserRepository();
                        $user = $user->create($username, $email, $password);
                    }
                }
            }
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $session = new Session();
            $session = $session->start('errors', ['errors' => 'Votre adresse email n\'est pas valide']);
        }
        if ($usernameLength > 255) {
            $session = new Session();
            $session = $session->start('errors', ['errors' => 'Votre nom d\'utilisateur n\'est pas valide']);
        }
        if ($password != $passwordConfirm) {
            $session = new Session();
            $session = $session->start('errors', ['errors' => 'La confirmation du mot de passe a échoué']);
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

            switch ($user['role']) {
                case 'admin':
                    $session = new Session();
                    $session = $session->start('user', ['username' => $user['username'], 'id' => $user['id']]);
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
                    $session = $session->start('user', ['username' => $user['username'], 'id' => $user['id']]);
                    $this->twig->display('/homepage.html.twig', ['session' => $session]);
                    break;
                default:
                    $this->twig->display('/admin/connection.html.twig');
            }
        }
    }

    public function write()
    {
        $this->twig->display('/admin/write.html.twig');
    }

    public function index()
    {
        //TO DO vérifier que l'utilisateur est admin avec la session
        $posts = new PostRepository();
        $posts = $posts->index();
        foreach ($posts as $post) {
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);
        }
        $this->twig->display('/admin/index.html.twig', ['posts' => $posts, 'user' => $user]);
    }

    public function publish()
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
            $this->index();
        }
    }

    public function edit($id)
    {
        $post = new PostRepository();
        $post = $post->show($id);
        $this->twig->display('/admin/edit.html.twig', ['post' => $post]);
    }

    public function editPost($id)
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
        $this->index();
    }

    public function deletePost($id)
    {
        if ($id) {
            $post = new PostRepository();
            $post = $post->deletePost($id);
        }
        $this->index();
    }

    public function readPost($id)
    {
        if ($id) {
            $post = new PostRepository();
            $post = $post->show($id);
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);
        }
        return $this->twig->display('/admin/read.html.twig', ['post' => $post, 'user' => $user]);
    }
}
