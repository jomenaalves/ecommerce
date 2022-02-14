<?php

namespace Source\App\Users;

use League\Plates\Engine;
use Source\Utils\ORM;

class LoginController
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
    echo $this->view->render('login', [
      "title" => 'Aréa Administrativa  - Ecommerce N soluções',
    ]);
  }

}
