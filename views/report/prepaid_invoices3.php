<?php
use  my\helpers\Help;;

?>
<style>
    .credit-table td {
        color:#000;
    }
</style>

﻿<table cellpadding="0" cellspacing="0" border="0" class="credit-table" >
    <tbody>
    <tr>
        <td colspan="3"><font face="Times New Roman" size="4"><b>Общество с ограниченной ответственностью «ЛУКОЙЛ-Интер-Кард»</b></font></td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3"><font face="Times New Roman" size="4"><b>Адрес: 400131 Россия, Волгоградская обл., г.Волгоград, ул. Коммунистическая, 13А<br>тел.: 8-800-1000-911</b></font></td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3"><font face="Times New Roman" size="4"><b>СЧЕТ №RU245006954-1496311258 от 01 Июня 2017 г.</b></font></td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3">
            <font face="Times New Roman" size="4">
                <b>Организация: Общество с ограниченной ответственностью "КАРДЕКС"</b><br>
                <b>Адрес: 117997, Россия, г.Москва,  , ул. Вавилова, д.69/75</b><br>
                <b>ИНН/КПП: 7701995420/773601001</b><br>
                <b>Договор №RU245006954&nbsp;от&nbsp;03.12.2013</b>
            </font>
        </td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td height="40" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3" align="center"><font face="Times New Roman" size="3"><b>Образец заполнения платежного поручения</b></font></td>
    </tr>
    <tr>
        <td colspan="3">
            <table border="1" bordercolor="black" cellspacing="0" cellpadding="2px" class="credit-table" width="900">
                <tbody>
                <tr>
                    <td><font face="Times New Roman" size="3">Получатель<br />ИНН 3444197347/345250001<br />Общество с ограниченной ответственностью «ЛУКОЙЛ-Интер-Кард»</font></td>
                    <td valign="bottom"><font face="Times New Roman" size="3">Сч. №</font></td>
                    <td valign="bottom"><font face="Times New Roman" size="3">40702810200000101271</font></td>
                </tr>
                <tr>
                    <td rowspan="2"><font face="Times New Roman" size="3">Банк получателя<br/>Филиал Петрокоммерц ПАО Банка «ФК Открытие» г. Москва</font></td>
                    <td><font face="Times New Roman" size="3">БИК</font></td>
                    <td><font face="Times New Roman" size="3">044525727</font></td>
                </tr>
                <tr>
                    <td><font face="Times New Roman" size="3">Сч. №</font></td>
                    <td><font face="Times New Roman" size="3">30101810745250000727</font></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="10" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3">
            <table border="1" bordercolor="black" cellspacing="0" cellpadding="2px" class="credit-table" width="900">
                <tbody>
                <tr>
                    <td><font face="Times New Roman" size="3">№</font></td>
                    <td align="center"><font face="Times New Roman" size="3">Наименование товара</font></td>
                    <td align="center" width="80"><font face="Times New Roman" size="3">Единица измерения</font></td>
                    <td align="center" width="80"><font face="Times New Roman" size="3">Количество</font></td>
                    <td align="center" width="80"><font face="Times New Roman" size="3">Цена</font></td>
                    <td align="center" width="100"><font face="Times New Roman" size="3">Сумма</font></td>
                </tr>
                <tr>
                    <td align="right"><font face="Times New Roman" size="3">1</font></td>
                    <td><font face="Times New Roman" size="3">Нефтепродукты</font></td>
                    <td align="center"><font face="Times New Roman" size="3">---</font></td>
                    <td align="center"><font face="Times New Roman" size="3">---</font></td>
                    <td align="center"><font face="Times New Roman" size="3"> <?= \number_format($summa, 2, ',', ' '); ?>.00</font></td>
                    <td align="right"><font face="Times New Roman" size="3"> <?= \number_format($summa, 2, ',', ' '); ?>.00</font></td>
                </tr>
                <tr>
                    <td align="right" colspan="5" style="border: 1px solid #FFF; border-right-color: #000; border-top-color: #000;"><font face="Times New Roman" size="3"><b>Итого:</b></font></td>
                    <td align="right"><font face="Times New Roman" size="3"><b> <?= \number_format($summa, 2, ',', ' '); ?>.00</b></td>
                </tr>
                <tr>
                    <td align="right" colspan="5" style="border: 1px solid #FFF; border-right-color: #000;"><font face="Times New Roman" size="3"><b>В том числе НДС 18%:</b></font></td>
                    <td align="right"><font face="Times New Roman" size="3"> <?= round($summa/100*18,2);?></td>
                </tr>
                <tr>
                    <td align="right" colspan="5" style="border: 1px solid #FFF; border-right: 1px solid #000;"><font face="Times New Roman" size="3"><b>Всего к оплате:</b></font></td>
                    <td align="right"><font face="Times New Roman" size="3"><b> <?=\number_format($summa, 2, ',', ' ')?>.00</b></font></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td colspan="3"><font face="Times New Roman" size="3">Всего наименований 1, на сумму <?= \number_format($summa, 2, ',', ' '); ?>.00 руб.<br /><b><?=Help::num2str($summa)?></b></font></td>
    </tr>
    <tr>
        <td height="20" colspan="3"></td>
    </tr>
    <tr>
        <td valign="middle" width="40%">
            Начальник отдела технического сопровождения клиентов                <br />
            <font face="Times New Roman" size="3">по доверенности №16/711  от 19.12.2016</font>
        </td>
        <td valign="middle" align="center" width="20%">
        </td>
        <td valign="middle" align="right" width="40%">
            __________________(А. В. Окружнова)
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
    </tbody>
</table>