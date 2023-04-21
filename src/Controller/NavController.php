<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Repository\PostRepository;

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
            $user = $user['username'];
        }
        $this->twig->display('/posts/index.html.twig', ['posts' => $posts, 'user' => $user]);
    }

    public function show($id)
    {
        $post = new PostRepository();
        $post = $post->show($id);
        $userId = $post->user_id;
        $user = $post->getAuthorName($userId);
        $user = $user['username'];

        $this->twig->display('/posts/show.html.twig', ['post' => $post, 'user' => $user]);
    }

    public function admin()
    {
        $this->twig->display('/admin/connection.html.twig');
    }
}
