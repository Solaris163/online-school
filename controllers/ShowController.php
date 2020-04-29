<?php


namespace app\controllers;


use app\engine\Render;
use app\models\Users;
use app\engine\VarDump;

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
        parent::__construct();
        $this->render = new Render($this->auth, $this->login, $this->is_admin); //создадим экземпляр класса Render для рендеринга страниц
    }

    /**
     * Метод показывает главную страницу
     */
    public function actionIndex(){
        $content = 'Экшен индекс';
        //отобразим страницу
        echo $this->render->renderPage('index.php', ['content' => $content]);
    }

}