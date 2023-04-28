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
        $post = $post->store($title, $subtitle, $article, $userId);
    }

    public function update($id, $title, $subtitle, $content)
    {
        $post = new Post($this->db);
        $post = $post->updatePost($id, $title, $subtitle, $content);
    }

    public function deletePost($id)
    {
        $post = new Post($this->db);
        $post = $post->deletePost($id);
    }
}
