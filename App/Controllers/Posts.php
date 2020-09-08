<?php

namespace App\Controllers;

class Posts extends \Core\Controller
{
    public function indexAction()
    {
        echo 'index action in posts controller';
        echo '<p>'
            . 'query string params are: <pre>'
            . htmlspecialchars(print_r($_GET, true)
            . '</pre></p>'
            );
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