<?php

namespace David\Blogpro\Controller;

class PostsController
{
    public function index()
    {
        echo "tous les articles du blog";
    }

    public function show($id)
    {
        echo "Je suis l'article $id";
    }
}
