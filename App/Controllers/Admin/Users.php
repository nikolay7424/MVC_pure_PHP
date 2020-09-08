<?php

namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
    public function indexAction()
    {
        echo 'index method of Users controller';
    }

    protected function before()
    {
        echo '(before) ';
    }

    protected function after()
    {
        echo ' (after)';
    }
}