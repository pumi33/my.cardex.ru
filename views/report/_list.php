<?php
use \my\helpers\Help;


?>
<div class="list-group">
    <a data-toggle="collapse" class="list-group-item <?= $collapsed ?>" data-parent="#accordion"
       href="#collapse<?= $i ?>">
        <?= $data['month_title'] ?> г.

        <? if ($data['balance']['summa']){ ?>
        <span
                style="float: right">Остаток на конец расчетного периода: <?= \number_format($data['balance']['summa'] * -1, 2, ',', ' ') ?>
            ₽</span>
    <? } ?>

    </a>
</div>
<div id="collapse<?= $i ?>" class="panel-collapse collapse <?= $in ?>">
    <div class="panel-body">

        <?

        if ($data['files']) {
            ?>
            <h5>Документы <span class="label label-rouded label-default"
                                style="color: #0f0f0f"> <?= count($data['files']) ?></span>

                <br> <br>
                <span style="color: #797979; font-size:14px;margin-top: -54px">

            <?
            if (isset($edo['date_add_edo'])) {
                $date1 = Help::normalDate($edo['date_add_edo']);

                if ($date1 < Help::normalDate($transaction['date'], false) and $date1 != '01.01.1970') {
                    print " <img src=\"https://www.diadoc.ru/favicon.ico\">Отправлены в Диадок";
                    $diadoc = 1;
                }


            }

            if (!isset($diadoc)) {
                print "<img src=\"/images/ems.ico\"> Отправлены оригиналы документов";
            }


            ?>
</span>


            </h5>
            <table width="100%" style="max-width: 500px" cellpadding="20" cellspacing="20" border="0">
                <?
                foreach ($data['files'] as $file) {
                    ?>

                    <tr>
                        <td><i class="ti-angle-right"></i> <?= Help::filesRus($file); ?></td>
                        <td><i class="mdi mdi-file-pdf fa-fw " style="font-size: 21px;color: #DA251C;"></i>
                            <span
                                    style="margin-left: 0px">


                                <?
                                if (stristr($file, 'Transaction')) {  //Костыль, тк транзакции без подписи
                                ?>
                                <a href="/files/get?file=<?= urlencode(str_replace(".XLS", ".PDF" . "", $file)); ?>" target="_blank" rel="noindex, nofollow">PDF</a>
                                <?} else{?>
                                    <a href="/files/get?file=<?= urlencode(str_replace(".XLS", "_Sign.PDF" . "", $file)); ?>" rel="noindex, nofollow">PDF</a>
                                    <?}?>
                            </span>
                        </td>
                        <td><i class="mdi mdi-file-excel text-success"
                               style="font-size: 21px; color: #1D7044;"></i>
                            <span style="margin-left: -3px"><a
                                        href="/files/get?file=<?= urlencode($file); ?>" target="_blank" rel="noindex, nofollow">EXCEL</a></span>
                        </td>&nbsp; &nbsp; &nbsp;
                    </tr>
                    <?
                }
                ?>
            </table>
        <? } ?>

        <?


        if ($data['finance-transaction']) {
            ?>
            <table width="100" class="table">
                <tr>
                    <th>Дата</th>
                    <th>Описание</th>
                    <th>Сумма (RUB)</th>
                </tr>


                <? foreach (Help::financeTransaction($data['finance-transaction']) as $transaction) {
                    $znak = ($transaction['motion']) ? '+' : '-';

                    if ($transaction['summa'] != 0) {
                        print "<tr>";
                        print "<td>" . Help::normalDate($transaction['date'], false) . "</td>";
                        print "<td>" . Help::financeDescrioption($transaction['ducument']) . "</td>";
                        print "<td>" . $znak . \number_format(abs($transaction['summa']), 2, ',', ' ') . "</td>";
                        print "</tr>\n";
                    }
                }
                ?>


            </table>


        <? } ?>


    </div>
</div>
                                