<?php

namespace Source\App\Users;

use League\Plates\Engine;
use Source\Utils\BD;
use Source\Utils\ORM;

class HomeController
{

    /**
     * Property responsible for rendering the page to the user
     * @property Object
     */
    private object $view;

    public function __construct()
    {

        !session_start() && session_start();
        // Directory of this controller's view
        $directory = __DIR__ . "/" . "../../.././view/user";
        $this->view = new Engine($directory);
    }


    /**
     * Role responsible for rendering the page to the user
     */
    public function render()
    {
        echo $this->view->render('home', [
            "title" => 'Homepage - Thanos Mirco Framework',
            "products" => (new BD)->getAllProducts()
        ]);
    }
}
