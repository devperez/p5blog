<?php

namespace David\Blogpro\Models\Repository;

use David\Blogpro\Models\Post;

class PostRepository extends AbstractRepository
{
    public function index()
    {
        $post = new Post($this->db);
        $posts = $post->all();
        
        return $posts;
    }
}
