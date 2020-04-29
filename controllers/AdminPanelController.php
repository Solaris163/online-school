<?php


namespace app\controllers;


use app\engine\Render;
use app\models\Users;
use app\models\Structure;
use app\engine\VarDump;

/**
 * Класс отвечает за отображение админ-панели
 * Class AdminPanelController
 * @package app\controllers
 */
class AdminPanelController extends Controller
{
    /**
     * @var Render
     */
    public $render;
    public $is_admin; //является ли пользователь администратором

    /**
     * AdminPanelController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->is_admin = Structure::isAdmin($this->login);
        $this->render = new Render($this->auth, $this->login, $this->is_admin); //создадим экземпляр класса Render для рендеринга страниц
    }

    /**
     * Метод показывает главную страницу админ-панели
     */
    public function actionIndex(){
        $content = 'Экшен индекс админ-панели';
        //отобразим страницу
        echo $this->render->renderPage('admin-panel.php', ['content' => $content]);
    }

    public function actionTest(){
        $content = 'экшен тест';
        //отобразим страницу
        echo $this->render->renderPage('admin-panel.php', ['content' => $content]);
    }


}