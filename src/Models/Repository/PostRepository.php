<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Post;

/**
 * This is the repository class for the posts
 */
class PostRepository extends AbstractRepository
{
    /**
     * Fetches all the posts
     *
     * @return array An array of all the posts
     */
    public function index(): array
    {
        $post = new Post($this->db);
        $posts = $post->all();
        return $posts;
    }

    /**
     * Fetches a post using its id
     *
     * @param integer $postId The post id
     * @return Post The post object
     */
    public function getOneById(int $postId): Post
    {
        $post = new Post($this->db);
        $post = $post->findById($postId);
        return $post;
    }

    /**
     * Stores a new post in the database
     *
     * @param string $title The title of the post
     * @param string $subtitle The subtitle of the post
     * @param string $article The post
     * @param integer $userId The id of the user
     * @return void
     */
    public function create(string $title, string $subtitle, string $article, int $userId): void
    {
        $post = new Post($this->db);
        $post = $post->storePost($title, $subtitle, $article, $userId);
    }

    /**
     * Updates a post
     *
     * @param integer $postId The id of the post
     * @param string $title The title of the post
     * @param string $subtitle The subtitle of the post
     * @param string $content The content of the post
     * @return void
     */
    public function update(int $postId, string $title, string $subtitle, string $content): void
    {
        $post = new Post($this->db);
        $post = $post->updatePost($postId, $title, $subtitle, $content);
    }

    /**
     * Deletes a post
     *
     * @param integer $postId The id of the post
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $post = new Post($this->db);
        $post = $post->deletePost($postId);
    }
}
