<?php

use Controller\Main\MainController;

use Controller\Order\OrderCheckoutController;
use Controller\Order\OrderInfoController;
use Controller\Product\ProductInfoController;
use Controller\Product\ProductListController;
use Controller\User\UserAuthController;
use Controller\User\UserLogoutController;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

const ACTION = 'action';

$routes = new RouteCollection();

$routes->add('index', new Route('/', ['_controller' => [ MainController::class, ACTION ]]) );
$routes->add('order_info', new Route('/order/info', ['_controller' => [ OrderInfoController::class, ACTION ]]));
$routes->add('order_checkout', new Route('/order/checkout', ['_controller' => [ OrderCheckoutController::class, ACTION ]]) );
$routes->add('product_list', new Route('/product/list', ['_controller' => [ProductListController::class, ACTION ]]) );
$routes->add('product_info', new Route('/product/info/{id}', ['_controller' => [ProductInfoController::class, ACTION ]]) );
$routes->add('user_authentication', new Route('/user/authentication', ['_controller' => [ UserAuthController::class, ACTION ]]) );
$routes->add('logout', new Route('/user/logout', ['_controller' => [ UserLogoutController::class, ACTION ]]) );

return $routes;
