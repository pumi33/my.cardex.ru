<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use my\models\User;

$this->title = 'Контактные лица';

?>
<div class="col-sm-12">
    <div class="white-box">


        <?php


        if (isset($users)) {

            print "<table class='table'>";

            print "<tr><th>Пользователь</th><th>E-mail</th><th>Телефон</th><th>Создан</th><th>Последний заход</th><th></th></tr>";

            foreach ($users as $user) {
                print "<tr>";
                print "<td> <i class=\"fa fa-user user" . $user->status . "\" aria-hidden=\"true\" data-toggle=\"tooltip\" title=\"" . \Yii::$app->params['role'][$user->status] . "\"></i> " . Html::a($user->full_name, Url::to(['user/update', 'id' => $user->id])) . "</td>";
                print "<td>" . $user->email . "</td>";
                print "<td>" . $user->phone . "</td>";
                print "<td>" . date("d.m.Y H:i", strtotime($user->created_at)) . "</td>";
                print "<td>";
                ($user->logged_in_at) ? print date("d.m.Y H:i", strtotime($user->logged_in_at)) : print 'не было';
                print "</td>";
                print "<td align='right'><span style='float: right'>";

                if (\Yii::$app->user->can('edits') and $user->status != User::STATUS_SUPERADMIN and $user->id != \Yii::$app->user->identity->id) {

                    print Html::a('<i class="fa fa-user-times" aria-hidden="true"></i>
 Удалить', ['delete', 'id' => $user->id], [
                        'class' => 'label label-danger',
                        'data'  => [
                            'confirm' => 'Удалить этого пользователя?',
                            'method'  => 'post',
                        ],
                    ]);

                }


                print " </span> </td>";
                print "</tr>";
            }
            print "</table>";


        }


        if (\Yii::$app->user->can('edits')) { ?>
            <div align=" left
            ">
                <?= Html::a('<i class="fa fa-user-plus" aria-hidden="true"></i> Добавить
 ', '/user/create', ['class' => 'btn btn-info waves-effect waves-light', 'name' => 'login-button']) ?>
            </div>
            <br>
        <? } ?>


    </div>
</div>







