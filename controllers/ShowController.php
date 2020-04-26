<?php


namespace app\controllers;


use app\engine\Render;

/**
 * Класс отвечает за отображение страниц сайта
 * Class ShowController
 * @package app\controllers
 */
class ShowController extends Controller
{
    /**
     * @var Render
     */
    public $render;

    /**
     * ShowController constructor.
     */
    public function __construct()
    {
        $this->render = new Render(); //создадим экземпляр класса Render для рендеринга страниц
    }

    /**
     * Метод показывает главную страницу
     */
    public function actionIndex(){
        $content = 'Экшен индекс';
        echo $this->render->renderPage('index.php', ['content' => $content]); //отобразим страницу
    }

}