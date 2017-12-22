<?php
namespace my\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use my\models\User;


class UserRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->status;


           // if ($role==User::STATUS_INACTIVE or \Yii::$app->user->identity->deleted==1)
             //   return false;


            if ($item->name === 'superadmin') {
                return $role == User::STATUS_SUPERADMIN;
            } elseif ($item->name === 'admin') {
                //moder является потомком admin, который получает его права
                return $role == User::STATUS_SUPERADMIN || $role == User::STATUS_ADMIN;
            }
            elseif ($item->name === 'user') {
                return $role == User::STATUS_SUPERADMIN || $role == User::STATUS_ADMIN
                    || $role == User::STATUS_USER;
            }
        }
        return false;
    }
}