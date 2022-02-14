<?php 

    require_once __DIR__ . "/../vendor/autoload.php";

    use  CoffeeCode\Router\Router;

    $router = new Router(PATH_OF_YOUR_APP);

    // NAMESPACE DO CONTROLLER
    $router->namespace("Source\App\Users");
    $router->group(null);

    /* ----- TODAS AS ROTAS DO SISTEMA ESTARÃO LISTADAS ABAIXO ----- */

    $router->get("/", "HomeController:render");
    $router->get("/login", "LoginController:render");
    $router->get("/area-administrativa", "AdminController:render");
    $router->get("/area-administrativa/cadastro", "AdminController:cadastro");
    $router->get("/area-administrativa/editar-ou-remover", "AdminController:editOrRemove");

    /* ----- TODAS AS ROTAS DE API ESTARÃO LISTADAS ABAIXO ----- */
    $router->group('api');

    $router->post("/loginAdmin", "ApiController:loginAdmin");
    $router->post("/cadProduct", "ApiController:cadProduct");
    $router->post("/upProduct", "ApiController:upProduct");
    $router->delete("/delProduct/{id}", "ApiController:delProduct");

    $router->get("/setCep/{cep}", "ApiController:setCEP");
    $router->get("/removeCep", "ApiController:removeCEP");

    $router->post("/calcFrete/{cep}", "ApiController:calcFrete");

    // routes payment
    $router->get("/getSessionPayment", "PaymentController:getSession");







    $router->dispatch();