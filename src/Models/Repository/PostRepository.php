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

    public function show(int $id): Post
    {
        $post = new Post($this->db);
        $post = $post->findById($id);

        return $post;
    }

    public function create(string $title, string $subtitle, string $article, int $userId): void
    {
        $post = new Post($this->db);
        $post = $post->storePost($title, $subtitle, $article, $userId);
    }

    public function update(int $id, string $title, string $subtitle, string $content): void
    {
        $post = new Post($this->db);
        $post = $post->updatePost($id, $title, $subtitle, $content);
    }

    public function deletePost(int $id): void
    {
        $post = new Post($this->db);
        $post = $post->deletePost($id);
    }
}
