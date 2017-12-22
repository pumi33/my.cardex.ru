<?

use yii\helpers\Html;

if (!empty($save_card)) {


    print "<table class='table'>";

    print "<tr>
        <th>Держатель</th>
        <th>Вид топлива/услуги</th>
        <th>Тип топливной карты</th>
        <th>Лимит топлива</th>
        <td>&nbsp;</td>

    </tr>";


    foreach ($save_card as $card) {
        print "<tr>";

        if (!empty($card['own'])) {
            print "<td>" . Html::encode($card['own']) . "</td>";
        } else {
            print "<td>-</td>";
        }


        print "<td>" . $card['fuel_type'] . "</td>
        <td>" . Yii::$app->params['card_type'][$card['card_type']] . "</td>";

        if ($card['limite_fuel_value'] > 0) {
            print "  <td>" . $card['limite_fuel_value'] . " л. " . Yii::$app->params['typeLimite2'][$card['limite_fuel_type']] . "</td>";
        } else {
            print "<td>-</td>";
        }

        print "<td>";
        print Html::a('<i class="fa fa-trash-o" aria-hidden="true"></i>', ['/feedback/', 'delete_id' => $card['id'], 'theme' => 1], [
            'class' => 'label label-danger',
            'data'  => [
                //  'confirm' => 'Убрать эту карту?',
                'method' => 'post',
            ],
        ]);
        print "<td>";


        print " </tr>";


    }
    print "</table>";

    print "<div align=left>";
    print "Стоимось активации карт: <b>" . count($save_card) * Yii::$app->params['card_price'] . "</b> руб.";
    print "</div>";

    print "<br>";

}
?>