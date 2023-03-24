<?php

namespace David\Blogpro\Models;

use DateTime;

class Post extends Model
{
    public function getCreatedAt(): string
    {
        $date = new DateTime($this->created_at);
        return $date->format('d-m-Y à H:i');
    }
}
