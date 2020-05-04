<?php

namespace app\models;

use app\engine\Db;
use app\engine\VarDump;


/**
 * Класс отвечает за работу с таблицей structure базы данных и обработку данных из этой таблицы
 * Class Structure
 * @package app\models
 */
class Structure extends Model
{
    public $id;
    public $user_id;
    public $group_id;
    public $create_date;
    public $change_date;
    public $is_delete;
    
    public function __construct
    (
        $user_id = null,
        $group_id = null,
        $create_date = null,
        $change_date = null,
        $is_delete = null
    )
    {
        $this->user_id = $user_id;
        $this->group_id = $group_id;
        $this->create_date = $create_date;
        $this->change_date = $change_date;
        $this->is_delete = $is_delete;
    }

    public static function getTableName()
    {
        return "structure";
    }

    public function getProperties() {
        return [
            'user_id'=>$this->user_id,
            'group_id'=>$this->group_id,
            'create_date'=>$this->create_date,
            'change_date'=>$this->change_date,
            'is_delet'=>$this->is_delet
        ];
    }

}