<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Repository\UserRepository;

class AdminController extends Controller
{
    public function signup()
    {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = sha1($_POST['password']); //utiliser un autre algo bcrypt?
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
        
        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Votre adresse email n'est pas valide.");
        }
        if ($usernameLength > 255) {
            array_push($errors, "Votre adresse email n'est pas valide.");
        }
        if ($password != $passwordConfirm) {
            array_push($errors, "La confirmation du mot de passe a échoué.");
        }
        //var_dump(isset($errors));
        if (isset($errors)) {
            return $this->twig->display('/admin/connection.html.twig', ['errors' => $errors]);
        }
        $this->twig->display('/admin/connection.html.twig');
    }

    public function signin()
    {
        $user = new UserRepository();
        $user = $user->signin();
        //var_dump($user);
        if ($user && $user['role'] === 'admin') {
            //préparer la session
            $this->twig->display('/admin/dashboard.html.twig');
        } elseif ($user && $user['role'] === 'registered') {
            //préparer la session
            $this->twig->display('/homepage.html.twig');
        } else {
            $this->twig->display('/admin/connection.html.twig');
        }
    }
}
