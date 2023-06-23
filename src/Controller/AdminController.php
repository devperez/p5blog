<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Repository\CommentRepository;
use David\Blogpro\Models\Repository\PostRepository;
use David\Blogpro\Models\Repository\UserRepository;
use David\Blogpro\Session\Session;

/**
 * The admin class controller
 */
class AdminController extends Controller
{
    /**
     * Creates an account
     *
     * @return void
     */
    public function signup(): void
    {
        /**
         * Refresh the messages displayed to the user
         *
         * @return void
         */
        function destroyMessages(): void
        {
            $session = new Session();
            $session->destroy('message');
            $session->destroy('errors');
        }

        /**
         * Sets the error message to be displayed
         *
         * @param string $message The message to be displayed
         * @return void
         */
        function setError($message): void
        {
            $session = new Session();
            $session = $session->set('errors', ['errors' => $message]);
        }

        /**
         * Sets the success message to be displayed
         *
         * @param string $message The message to be displayed
         * @return void
         */
        function setSuccess($message): void
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

    /**
     * Logs in the user
     *
     * @return void
     */
    public function signin(): void
    {
        if ($_POST['email'] !== false && $_POST['password'] !== false) {
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);
            $user = new UserRepository();
            $user = $user->signin($email, $password);
            if ($user === false) {
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

    /**
     * Fetches the page where the admin can write a post
     *
     * @return void
     */
    public function write(): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $this->twig->display('/admin/write.html.twig');
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Displays all the posts with the author's name
     *
     * @return void
     */
    public function index(): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $posts = new PostRepository();
            $posts = $posts->index();
            foreach ($posts as $post) {
                $userId = $post->user_id;
                $user = $post->getAuthorName($userId);
            }
            $this->twig->display('/admin/index.html.twig', ['posts' => $posts, 'user' => $user]);
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Checks the form is complete and then publishes the post
     *
     * @return void
     */
    public function publish(): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
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
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Displays a post
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function edit(int $postId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $post = new PostRepository();
            $post = $post->getOneById($postId);
            $this->twig->display('/admin/edit.html.twig', ['post' => $post]);
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Edits a post
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function editPost(int $postId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
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
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Deletes a post
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];
        
        if ($role === 'admin') {
            $post = new PostRepository();
            $post = $post->deletePost($postId);

            header('Location: /?url=indexAdmin');
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Displays a post in the back office
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function readPost(int $postId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $post = new PostRepository();
            $post = $post->getOneById($postId);
            $userId = $post->user_id;
            $user = $post->getAuthorName($userId);

            $this->twig->display('/admin/read.html.twig', ['post' => $post, 'user' => $user]);
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Logging out
     *
     * @return void
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /?url=home');
    }

    /**
     * Comment creation
     *
     * @return void
     */
    public function comment()
    {
        if (isset($_POST['comment']) && isset($_POST['userId']) && isset($_POST['postId'])) {
            $commentContent = htmlspecialchars($_POST['comment']);
            $userId = htmlspecialchars($_POST['userId']);
            $postId = htmlspecialchars($_POST['postId']);
            if (!empty($commentContent) && strlen($commentContent) < 500) {
                $comment = new CommentRepository();
                $comment = $comment->create($commentContent, $userId, $postId);
            } else {
                return $this->twig->display('/posts/index.html.twig', ['comment' => 'Il y a eu une erreur. Merci de bien vouloir recommencer.']);
            }
        }
        $this->twig->display('/posts/index.html.twig', ['comment' => 'Votre commentaire a bien été enregistré. Il sera publié après modération.']);
    }

    /**
     * Display all the comments in the back office
     *
     * @return void
     */
    public function commentIndex(): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
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
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Displays one comment
     *
     * @param integer $commentId The id of the comment
     * @return void
     */
    public function readComment(int $commentId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $comment = new CommentRepository();
            $comment = $comment->getOneById($commentId);
            $user = new UserRepository();
            $user = $user->getOne($comment['user_id']);
            $post = new PostRepository();
            $post = $post->getOneById($comment['post_id']);

            $this->twig->display('/admin/commentShow.html.twig', ['comment' => $comment, 'user' => $user, 'post' => $post]);
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Comment validation
     *
     * @param integer $commentId The id of the comment
     * @return void
     */
    public function publishComment(int $commentId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $comment = new CommentRepository();
            $comment = $comment->getOneById($commentId);
            $commentId = $comment['id'];
            $comment = new CommentRepository();
            $comment = $comment->publish($commentId);

            header('Location: /?url=commentIndex');
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }

    /**
     * Deletes a comment
     *
     * @param integer $commentId The id of the comment
     * @return void
     */
    public function deleteComment(int $commentId): void
    {
        $session = new Session();
        $user = $session->get('user');
        $role = $user['role'];

        if ($role === 'admin') {
            $comment = new CommentRepository();
            $comment = $comment->getOneById($commentId);
            $commentId = $comment['id'];
            $comment = new CommentRepository();
            $comment = $comment->delete($commentId);

        header('Location: /?url=commentIndex');
        } else {
            $this->twig->display('/homepage.html.twig');
        }
    }
}
