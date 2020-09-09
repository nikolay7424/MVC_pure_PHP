<?php

namespace App\Controllers;

use Core\View;
use App\Models\Post;

class Posts extends \Core\Controller
{
    public function indexAction()
    {
        $posts = Post::getAll();
        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);
    }

    public function addNewAction()
    {
        echo 'addNew action in posts controller';
    }

    public function editAction()
    {
        echo 'edit action in posts controller';
        echo '<p>'
            . 'route params are: <pre>'
            . htmlspecialchars(print_r($this->routeParams, true)
                . '</pre></p>'
            );
    }
}