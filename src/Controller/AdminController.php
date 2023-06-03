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
        /**
         * This function is called to refresh the messages displayed to the user
         */
        function destroyMessages()
        {
            $session = new Session();
            $session->destroy('message');
            $session->destroy('errors');
        }

        /**
         * This function sets the error message to be displayed
         */
        function setError($message)
        {
            $session = new Session();
            $session = $session->set('errors', ['errors' => $message]);
        }

        /**
         * This function sets the success message to be displayed
         */
        function setSuccess($message)
        {
            $session = new Session();
            $session = $session->set('message', ['message' => $message]);
        }

        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);
            $passwordConfirm = sha1($_POST['passwordConfirm']);
            $usernameLength = strlen($username);

            $isValid = true;

            if ($usernameLength > 255) {
                $isValid = false;
                setError("Votre nom d'utilisateur n'est pas valide.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isValid = false;
                setError("Votre adresse email n'est pas valide.");
            }

            if ($password !== $passwordConfirm) {
                $isValid = false;
                setError("La confirmation du mot de passe a échoué.");
            }

            if ($isValid === false) {
                $this->twig->display('/admin/connection.html.twig');
                exit();
            }

            if ($isValid) {
                $userRepository = new UserRepository();
                $user = $userRepository->create($username, $email, $password);
            }
            if ($user) {
                destroyMessages();
                setSuccess("Votre compte a bien été créé, vous pouvez vous connecter.");
                $this->twig->display('/admin/connection.html.twig');
            }
        }
        
        if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['passwordConfirm'])) {
            destroyMessages();
            setError('Merci de bien vouloir compléter le formulaire en entier.');
            $this->twig->display('/admin/connection.html.twig');
        }

        if ($user === false) {
            destroyMessages();
            setError("Cette adresse email est déjà utilisée. Merci de bien vouloir recommencer.");
            $this->twig->display('/admin/connection.html.twig');
        }
    }


    public function signin()
    {
        if ($_POST['email'] != false && $_POST['password'] != false) {
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
                        $session = $session->set('user', ['username' => $user['username'], 'id' => $user['id'], 'role' => $user['role']]);
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
                        $session = $session->set('user', ['username' => $user['username'], 'id' => $user['id'], 'role' => $user['role']]);
                        $this->twig->display('/homepage.html.twig', ['session' => $session]);
                        break;
                    default:
                        $this->twig->display('/admin/connection.html.twig');
                }
            }
        } else {
            $session = new Session();
            $session->destroy('message');
            $session->destroy('errors');
            $session = $session->set('errors', ['errors' => 'Merci de bien vouloir remplir tous les champs du formulaire.']);
            $this->twig->display('/admin/connection.html.twig');
        }
    }

    public function write(): void
    {
        $this->twig->display('/admin/write.html.twig');
    }

    /***
     * This function displays all the posts with the author's name
     */
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

    /***
     * This function checks that the form is complete and then publishes the post
     */
    public function publish(): void
    {
        if (!empty($_POST['title']) && !empty($_POST['subtitle']) && !empty($_POST['content']) && !empty($_POST['userId'])) {
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

    /***
     * This function selects a post and displays it
     *
     * @param integer $postId the id of the post
     * @return void
     */
    public function edit(int $postId): void
    {
        $post = new PostRepository();
        $post = $post->getOneById($postId);
        $this->twig->display('/admin/edit.html.twig', ['post' => $post]);
    }

    /***
     * This function is called when the admin finishes editing a post
     *
     * @param integer $postId the id of the post
     * @return void
     */
    public function editPost(int $postId): void
    {
        if ($_POST['title'] && $_POST['subtitle'] && $_POST['content']) {
            $title = $_POST['title'];
            $subtitle = $_POST['subtitle'];
            $article = $_POST['content'];
            if (strlen($title) < 255) {
                $post = new PostRepository();
                $post = $post->update($postId, $title, $subtitle, $article);
            }
        }
        header('Location: /?url=indexAdmin');
    }

    /***
     * This function is used to delete a post
     *
     * @param integer $postId the id of the post
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $post = new PostRepository();
        $post = $post->deletePost($postId);
    
        header('Location: /?url=indexAdmin');
    }

    /***
     * This function is called when the admin wants to display a post in the back office
     *
     * @param integer $postId the id of the post
     * @return void
     */
    public function readPost(int $postId): void
    {
        $post = new PostRepository();
        $post = $post->getOneById($postId);
        $userId = $post->user_id;
        $user = $post->getAuthorName($userId);
        
        $this->twig->display('/admin/read.html.twig', ['post' => $post, 'user' => $user]);
    }

    /***
     * This function is called when the admin logs out
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /?url=home');
    }

    /***
     * This function is called when a comment is created
     */
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

    /***
     * This function is called when the admin wants to display all the comments in the back office
     */
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
            $post = $posts->getOneById($postId);
            $user = $users->getOne($userId);
            array_push($commentsArray, ['post' => $post->title, 'user' => $user['username'], 'comment' => $comment]);
        }
        $this->twig->display('/admin/comments.html.twig', ['commentsArray' => $commentsArray, 'comments' => $comments, 'post' => $post, 'user' => $user]);
    }

    /***
     * This function is called when the admin selects a comment
     *
     * @param integer $commentId the id of the comment
     * @return void
     */
    public function readComment(int $commentId): void
    {
        $comment = new CommentRepository();
        $comment = $comment->getOneById($commentId);
        $user = new UserRepository();
        $user = $user->getOne($comment['user_id']);
        $post = new PostRepository();
        $post = $post->getOneById($comment['post_id']);
        
        $this->twig->display('/admin/commentShow.html.twig', ['comment' => $comment, 'user' => $user, 'post' => $post]);
    }

    /***
     * This function is called when the admin validates a comment
     *
     * @param integer $commentId the id of the comment
     * @return void
     */
    public function publishComment(int $commentId): void
    {
        $comment = new CommentRepository();
        $comment = $comment->getOneById($commentId);
        $commentId = $comment['id'];
        $comment = new CommentRepository();
        $comment = $comment->publish($commentId);

        header('Location: /?url=commentIndex');
    }

    /***
     * This function is called when the admin deletes a comment
     *
     * @param integer $commentId the id of the comment
     * @return void
     */
    public function deleteComment(int $commentId): void
    {
        $comment = new CommentRepository();
        $comment = $comment->getOneById($commentId);
        $commentId = $comment['id'];
        $comment = new CommentRepository();
        $comment = $comment->delete($commentId);

        header('Location: /?url=commentIndex');
    }
}
