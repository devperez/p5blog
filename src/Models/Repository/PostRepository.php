<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Post;

class PostRepository extends AbstractRepository
{
    /***
     * This function is called when the user wants to display all the posts
     *
     * @return array
     */
    public function index(): array
    {
        $post = new Post($this->db);
        $posts = $post->all();
        return $posts;
    }

    /***
     * This function is called when the user selects a post
     *
     * @param integer $postId the post id
     * @return Post
     */
    public function getOneById(int $postId): Post
    {
        $post = new Post($this->db);
        $post = $post->findById($postId);
        return $post;
    }

    /***
     * This function is called when the admin stores a new post in the database
     *
     * @param string $title the title of the post
     * @param string $subtitle the subtitle of the post
     * @param string $article the post
     * @param integer $userId the id of the user
     * @return void
     */
    public function create(string $title, string $subtitle, string $article, int $userId): void
    {
        $post = new Post($this->db);
        $post = $post->storePost($title, $subtitle, $article, $userId);
    }

    /***
     * This function is called when the user wants to update a post
     *
     * @param integer $postId the id of the post
     * @param string $title the title of the post
     * @param string $subtitle the subtitle of the post
     * @param string $content the content of the post
     * @return void
     */
    public function update(int $postId, string $title, string $subtitle, string $content): void
    {
        $post = new Post($this->db);
        $post = $post->updatePost($postId, $title, $subtitle, $content);
    }

    /***
     * This function is called when the admin deletes a post
     *
     * @param integer $postId the id of the post
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $post = new Post($this->db);
        $post = $post->deletePost($postId);
    }
}
