<?php

namespace Source\App\Users;

use League\Plates\Engine;
use Source\Utils\BD;

class AdminController
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
    $directory = __DIR__ . "/" . "../../.././view/admin";
    $this->view = new Engine($directory);
  }


  /**
   * Role responsible for rendering the page to the user
   */
  public function render()
  {
    
    if(!isset($_SESSION['idAdminLogged'])){
      header("Location: login");
      exit;
    }

    echo $this->view->render('admin', [
      "title" => 'Aréa Administrativa  - Ecommerce N soluções',
      "products" => (new BD)->getAllProducts()
    ]);
  }

  public function cadastro()
  {
    
    if(!isset($_SESSION['idAdminLogged'])){
      header("Location: login");
      exit;
    }

    echo $this->view->render('cadastro', [
      "title" => 'Aréa Administrativa  - Ecommerce N soluções'
    ]);
  }

  public function editOrRemove() {
    if(!isset($_SESSION['idAdminLogged'])){
      header("Location: login");
      exit;
    }

    echo $this->view->render('editOrRemove', [
      "title" => 'Aréa Administrativa  - Ecommerce N soluções',
      "products" => (new BD)->getAllProducts()
    ]);
  }
}
