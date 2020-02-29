<?php

declare(strict_types = 1);

namespace Controller\Main;

use Framework\BaseController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends BaseController
{
    /**
     * Главная страница
     * @return Response
     */
    public function action(): Response
    {
        return $this->render('main/index.html.php');
    }
}
