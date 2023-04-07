<?php

namespace David\Blogpro\Controller;

use David\Blogpro\Models\Post;
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
        $this->twig->display('/posts/index.html.twig', compact('posts'));
    }

    public function show($id)
    {
        $post = new Post($this->getDB());
        $post = $post->findById($id);
        $this->twig->display('/posts/show.html.twig', compact('post'));
    }

    public function admin()
    {
        $this->twig->display('/admin/connection.html.twig');
    }
}
