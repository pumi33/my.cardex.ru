<?php
use yii\helpers\Html;
use  my\helpers\Help;

?>

<form method="get">
    <?

    if (!$month)
        $month = date('n');
    if (!$year)
        $year = date('Y');


    ?>

        <div class="row">
            <div style="float: left">
                <?= Html::dropdownList('month', $month, \Yii::$app->params['ruMonth'], ['class' => 'form-control max100', 'id' => 'statusCard', 'prompt' => 'Месяц', 'required' => 'required']); ?>
            </div>
            <div style="float: left">
                <?= Html::dropdownList('year', $year, Help::getYears(), ['class' => 'form-control max100', 'id' => 'statusCard2', 'prompt' => 'Год', 'required' => 'required']); ?>
            </div>

            <?php
            if (!empty($ccard))
                print Html::hiddenInput('card', $ccard);
            ?>


            <div style="float: left;margin-left: 4px">
                <?= Html::submitButton('Сформировать', ['class' => 'btn btn-inverse waves-effect waves-light  height38']) ?>
            </div>
        </div>


</form>
