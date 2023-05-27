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

    /***
     * @param integer $id
     * @return Post
     */
    public function getOneById(int $id): Post
    {
        $post = new Post($this->db);
        $post = $post->findById($id);
        return $post;
    }

    /***
     * @param string $title
     * @param string $subtitle
     * @param string $article
     * @param integer $userId
     * @return void
     */
    public function create(string $title, string $subtitle, string $article, int $userId): void
    {
        $post = new Post($this->db);
        $post = $post->storePost($title, $subtitle, $article, $userId);
    }

    /***
     * @param integer $id
     * @param string $title
     * @param string $subtitle
     * @param string $content
     * @return void
     */
    public function update(int $id, string $title, string $subtitle, string $content): void
    {
        $post = new Post($this->db);
        $post = $post->updatePost($id, $title, $subtitle, $content);
    }

    /***
     * @param integer $id
     * @return void
     */
    public function deletePost(int $id): void
    {
        $post = new Post($this->db);
        $post = $post->deletePost($id);
    }
}
