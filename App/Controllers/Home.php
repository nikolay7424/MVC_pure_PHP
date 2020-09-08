<?php


namespace App\Controllers;


class Home extends \Core\Controller
{
    public function indexAction()
    {
        echo 'index method of home controller';
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