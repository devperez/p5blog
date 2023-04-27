<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Post;

class PostRepository extends AbstractRepository
{
    public function index(): array
    {
        $post = new Post($this->db);
        $posts = $post->all();
        
        return $posts;
    }

    public function show($id): Post
    {
        $post = new Post($this->db);
        $post = $post->findById($id);

        return $post;
    }

    public function create($title, $subtitle, $article, $userId)
    {
        $post = new Post($this->db);
        $post = $post->create($title, $subtitle, $article, $userId);
    }
}
