<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\User;

class AdminController extends Controller
{
    public function signup()
    {
        if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {
            $username = htmlspecialchars($_POST['username']);
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);
            $passwordConfirm = sha1($_POST['passwordConfirm']);

            $usernameLength = strlen($username);
            if ($usernameLength <= 255) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if ($password === $passwordConfirm) {
                        $user = new User($this->getDB());
                        $user = $user->create($username, $email, $password);
                        $this->twig->display('/admin/dashboard.html.twig');
                    } else {
                        $error = "La confirmation du mot de passe a échoué.";
                    }
                } else {
                    $error = "Votre adresse email n'est pas valide.";
                }
            } else {
                $error = "Votre nom d'utilisateur ne doit pas dépasser 255 caractères.";
            }
        } else {
            $error = "Tous les champs doivent être complétés.";
            $this->twig->display('/admin/connection.html.twig', compact('error'));
        }
    }

    public function signin()
    {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = htmlspecialchars($_POST['email']);
            $password = sha1($_POST['password']);


            $user = new User($this->getDB());
            $user = $user->connect($email, $password);
            if ($user) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                $this->twig->display('/admin/dashboard.html.twig');
            } else {
                $error = "Ce compte n'existe pas.";
            }
        } else {
            $error = "Tous les champs doivent être complétés.";
        }
    }
}
