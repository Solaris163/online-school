<?php

namespace app\models;

use app\engine\Db;
use app\engine\VarDump;


/**
 * Класс отвечает за работу с таблицей users базы данных и обработку данных из этой таблицы
 * Class Users
 * @package app\models
 */
class Users extends Model
{
    public $id;
    public $login;
    public $pass;
    public $hash;
    public $email;
    public $name;
    public $surname;
    public $page_vk;
    public $create_date;
    public $change_date;
    public $is_delete;
    public $description;
    
    public function __construct
    (
        $login = null,
        $pass = null,
        $hash = null,
        $email = null,
        $name = null,
        $surname = null,
        $page_vk = null,
        $create_date = null,
        $change_date = null,
        $is_delete = null,
        $description = null
    )
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->hash = $hash;
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->page_vk = $page_vk;
        $this->create_date = $create_date;
        $this->change_date = $change_date;
        $this->is_delete = $is_delete;
        $this->description = $description;
    }

    public static function getTableName()
    {
        return "users";
    }

    public function getProperties() {
        return [
            'login'=>$this->login,
            'pass'=>$this->pass,
            'hash'=>$this->hash,
            'email'=>$this->email,
            'name'=>$this->name,
            'surname'=>$this->surname,
            'page_vk'=>$this->page_vk,
            'create_date'=>$this->create_date,
            'change_date'=>$this->change_date,
            'is_delete'=>$this->is_delete,
            'description'=>$this->description,
        ];
    }

    public static function isAuth() { //функция проверяет есть ли пользователь в сессии если есть возвращает true,
        //если нет, проверяет есть ли хеш в cookie, если есть то записывает пользователя в сессию
        if(isset($_SESSION['login'])) { //проверяем, есть ли в сессии логин пользователя
            return true;
        } elseif(isset($_COOKIE['hash'])) { //проверяем, есть ли в COOKIE хеш
            $hash = $_COOKIE['hash'];
            //Проверим, есть ли в таблице users пользователь с таким хешем, также найдем в таблице structure группы этого пользователя и
            //проверим, обладают ли эти группы правами администратора
            $sql = "SELECT users.login, groups.id as group_id, groups.is_admin FROM users
            LEFT JOIN structure ON users.id = structure.user_id
            LEFT JOIN groups ON structure.group_id = groups.id
            WHERE users.hash = '{$hash}';";
            $resultArr = Db::getInstance()->queryAll($sql);

            if(!empty($resultArr)) { //проверяем нашелся ли пользователь в базе.
                $_SESSION['login'] = $resultArr[0]["login"]; //записываем в сессию логин пользователя
                //Переберем массив $resultArr, и получим массив групп, в которые входит пользователь
                //Также перебирая массив, проверим, является ли хоть одна из групп административной
                $groupsArr = []; //массив групп пользователя
                $is_admin = false;
                foreach ($resultArr as $result) {
                    $groupsArr[] = $result["group_id"];
                    if ($result["is_admin"] === '1') {$is_admin = true;}
                }
                $_SESSION['is_admin'] = $is_admin; //запишем в сессию является пользователь администратором
                return true;
            } else return false;
        }else return false;
    }

    public static function isAdmin() {
        return $_SESSION['is_admin'];
    }

    public static function getLogin() {
        return $_SESSION['login'];
    }

    /**
     * Метод находит в базе и отдает список пользователей с группами, в которые они входят
     * @param int $count число пользователей на одной странице
     * @param int $page номер страницы, с которой начать показ
     */
    public static function getUsersList($count = 20, $page = 0){
        //Найдем фамилии нужных пользователей (за один запрос не получилось, при добавдении LIMIT в подзапрос, результат теряется)
        $rowStart = $count*$page; //строка с которой следует начать вывод
        $sql = "SELECT id, surname FROM users ORDER BY surname LIMIT {$rowStart} , {$count};";
        $usersArr = Db::getInstance()->queryAll($sql);
        //Получим строку с id пользователей 
        $str = '';
        foreach ($usersArr as $user) {
            $str .= ',' . $user['id'];
        }
        $str = mb_substr($str, 1); //обрежем первую запятую
        $sql = "SELECT users.login as login, users.name as user_name, users.surname, groups.id as group_id, groups.name as group_name FROM users
            LEFT JOIN structure ON users.id = structure.user_id
            LEFT JOIN groups ON structure.group_id = groups.id
            WHERE users.id IN ({$str}) ORDER BY users.surname;";
        $resultArr = Db::getInstance()->queryAll($sql);
        VarDump::varDump($resultArr);
    }
}