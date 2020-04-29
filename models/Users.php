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
            $user = static::getOneWhere('hash', $hash); //запрашиваем объект пользователя из базы по хешу
            if($user) { //проверяем создался ли объект пользователя из базы (если не создался, $user будет равно false)
                $_SESSION['login'] = $user->login; //если объект создался, записываем в сессию логин пользователя
                return true;
            } else return false;
        }else return false;
    }

    public static function getLogin() {
        //return 'fdsdd';
        return $_SESSION['login'];
    }


}