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

    /**
     * AdminPanelController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->render = new Render($this->auth, $this->login, $this->is_admin); //создадим экземпляр класса Render для рендеринга страниц
    }

    /**
     * Метод показывает главную страницу админ-панели
     */
    public function actionIndex() {
        $content = 'Экшен индекс админ-панели';
        //отобразим страницу
        echo $this->render->renderPage('admin-panel.php', ['content' => $content, 'is_admin' => $this->is_admin]);
    }

    public function actionTest() {
        $content = 'экшен тест';
        //отобразим страницу
        echo $this->render->renderPage('admin-panel.php', ['content' => $content, 'is_admin' => $this->is_admin]);
    }

    /**
     * Метод выводит список пользователей
     */
    public function actionUserList($params) {
        if ($this->is_admin) {
            //нужно создать шаблон для рендера таблицы из массива
            $count = 20; //захардкодил тут пока
            $page = 0;
            if (!empty($params)){ //проверяем были ли переданы в запросе гет-параметры
                $count = (int) $params["count"]; //количество пользователей на странице
                $page = (int) $params["page"]; //страница, с которой нужно начать вывод
            }
            $content = Users::getUsersList($count, $page);
        }else $content = 'Эта информация только для администраторов';
        //отобразим страницу
    echo $this->render->renderPage('admin-panel.php', ['content' => $content, 'is_admin' => $this->is_admin]);
    }
}