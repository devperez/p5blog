<?php

namespace David\Blogpro\Models;

use DateTime;

/**
 * The post model
 */
class Post extends Model
{
    /**
     * Displays a european formated date for the posts
     *
     * @return string date The date when the post was published
     */
    public function getCreatedAt(): string
    {
        $date = new DateTime($this->created_at);
        return $date->format('d-m-Y à H:i');
    }
}
