<?php

namespace my\helpers;

use DateTime;
use DateTimeZone;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\RichText;
use PhpOffice\PhpSpreadsheet\Style\Color;

class Help
{
    public static $oilIcons = [
        'Шелл'              => 'shell',
        'ГПН'               => 'gazprom-neft',
        'газпром'           => 'gazprom-neft',
        'ЛУКОЙЛ'            => 'lukoil',
        'Нефтьмагистраль'   => 'neft-magistral',
        'Татнефть'          => 'tat-neft',
        'Технология'        => 'azst',
        'НефтеПромСервис'   => 'npserv',
        'Уралконтрактнефть' => 'ukn',
        'ПЕРЕКРЕСТОК'       => 'perekrestokoil',
        'Голд Ойл Рязань'   => 'autoryazan',
        'Сити-Ойл'          => 'oil13',
        'Валар'             => 'astra-azs',
        'Петролстарт'       => 'petro',
        'ТД НМ'             => 'neft-magistral',
        'Трансойл'          => 'transoil',

    ];
    //Добваить Башнефть

    public static $filesRus = [
        'Torg12'         => 'ТОРГ-12 (Товарная накладная)',
        'ActService'     => 'Акт услуг',
        'InvoiceAdvance' => 'Счет-фактура на аванс',
        'Invoice'        => 'Счет-фактура',
        'Transactions'   => 'Оборот по обслуживанию',
        'ActTransfer'    => 'Акт приема-передачи',
        'UPD'            => 'УПД (Универсальный передаточный документ)',
        'ReportDetailed' => 'Отчет',

    ];

    public static $financeFileDescription = [
        'Платежное поручение входящее' => 'Поступление денежных средств',
        'Реализация товаров и услуг'   => 'Списание денежных средств',
    ];


    public static $financePeriod = [
        'this_month'     => 'Текущий месяц',
        'previous_month' => 'Прошлый месяц',
        '3months'        => 'Последние 3 месяца',
        'this_year'      => 'Текущий год',
        'previous_year'  => 'Прошлый год',
        '3years'         => 'Последние 2 года',
    ];


    public static $edo = [
        'Тензор'        => '<img src="https://tensor.ru/favicon.ico"><a href="https://reg.tensor.ru/auth/" target=\'_blank\'>Тензор</a>',
        'Контур'        => '<img src="https://kontur.ru/favicon.ico"><a href="https://kontur.ru/" target=\'_blank\'>ЗАО "ПФ" "СКБ Контур"</a>',
        'Диадок'        => '<img src="https://www.diadoc.ru/favicon.ico"> <a href=\'https://www.diadoc.ru/\' target=\'_blank\'>Диадок</a>',
        'Калуга Астрал' => '<img src="http://astralnalog.ru/favicon.ico"><a href="http://astralnalog.ru" target=\'_blank\'>Калуга Астрал</a>',
        'СБИС'          => '<img src="https://sbis.ru/favicon.ico"><a href="https://sbis.ru" target=\'_blank\'>СБИС</a>',
        'Такском'       => '<a href="http://taxcom.ru" target=\'_blank\'>Такском</a>',
    ];


    public static $edo2 = [
        'Тензор'        => ['icon' => 'https://tensor.ru/favicon.ico', 'link' => 'https://reg.tensor.ru/auth/'],
        'Контур'        => ['icon' => 'https://kontur.ru/favicon.ico', 'link' => 'https://kontur.ru/'],
        'Диадок'        => ['icon' => 'https://www.diadoc.ru/favicon.ico', 'link' => 'https://auth.kontur.ru/?tabs=1,1,0,0&customize=diadoc&back=https%3A%2F%2Fdiadoc.kontur.ru%2F'],
        'Калуга Астрал' => ['icon' => 'http://astralnalog.ru/favicon.ico', 'link' => 'http://astralnalog.ru/'],
        'СБИС'          => ['icon' => 'https://sbis.ru/favicon.ico', 'link' => 'https://sbis.ru'],
        'Такском'       => ['link' => 'https://lk.taxcom.ru/'],
    ];

    public static function getEdoName($search, $getlink = null)
    {


        foreach (self::$edo2 as $key => $oilIcon) {
            if (strstr(mb_strtolower($search, 'UTF-8'), mb_strtolower($key, 'UTF-8'))) {


                $link = "";

                if (isset($oilIcon['icon'])) {
                    $link .= "<img src=\"" . $oilIcon['icon'] . "\"> ";
                }

                if (isset($oilIcon['link'])) {
                    $link .= "<a href=\"" . $oilIcon['link'] . "\" target='_blank'>" . $key . "</a>";
                }

                if ($getlink and isset($oilIcon['link'])) {
                    $link = $oilIcon['link'];
                }


                if (!empty($link)) {
                    return $link;
                }


            }
        }

        return " ЭДО ";


    }


    public static function getCountMonth($search)
    {
        // с какого месяца начать|длительность
        $data = [0, 3];
        switch ($search) {
            case 'this_month':
                $data = [0, 1];
                break;
            case 'previous_month':
                $data = [1, 1];
                break;
            case '3months':
                $data = [0, 3];
                break;
            case 'this_year':
                $data = [0, date('n')];
                break;
            case 'previous_year':
                $temp = date('n') + 1;
                $data = [$temp, 12];
                break;
            case '3years':
                $data = [0, 24];
                break;
        }

        return $data;

    }


    /**Вывод ошибое на экрван
     *
     * @param null $errors
     */
    public static function modelErrors($errors = null, $display = 1)
    {
        if (isset($errors)) {

            if (is_array($errors)) {
                foreach ($errors as $error) {

                    if ($display) {
                        \Yii::$app->session->setFlash('warning', $error);
                    }


                    \Yii::warning($error);
                }

            } else {
                if ($display) {
                    \Yii::$app->session->setFlash('warning', $errors);
                }

                \Yii::warning($errors);
            }
        }
    }


    public static function clean($string)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    /**Вывести дату из ms SQL
     *
     * @param $date
     *
     * @return string
     */
    public static function normalDate($date, $minus = true, $returnDefault = 'd.m.Y')
    {
        $date = new DateTime($date);
        if ($minus) {
            $date->modify('-2000 years');
        }

        if ($date->format('Y') < 1970) {
            $date = new DateTime('1970-01-01 00:00:00');
        }


        return $date->format($returnDefault);

    }

    /**Проверкуа даты
     *
     * @param $date
     *
     * @return bool
     */
    public static function validateDate($date)
    {
        $d = \DateTime::createFromFormat('Y-m-d', $date);

        return $d && $d->format('Y-m-d') === $date;
    }


    /**Подсветка меню
     *
     * @param      $url
     * @param null $dropdown
     *
     * @return string
     */
    public static function menu($url, $dropdown = null)
    {


        if (\Yii::$app->request->pathInfo == $url) {
            $return = "active";
        } elseif ($url != "" and strstr(\Yii::$app->request->pathInfo, $url)) {
            $return = "active";
        } elseif ($dropdown) {
            $return = "dropdown";
        } else {
            $return = "@@menu.messaging";
        }

        return $return;
    }


    /**Иконки заправок
     *
     * @param      $url
     * @param null $dropdown
     *
     * @return string
     */
    public static function iconOil($search)
    {
        $search2 = explode("]", $search);

        if (isset($search2[1])) {
            $title = $search2[1];
        } else {
            $title = $search2[0];
        }

        $title2 = explode("ИНН", $title);


        foreach (self::$oilIcons as $key => $oilIcon) {
            if (strstr(mb_strtolower($search, 'UTF-8'), mb_strtolower($key, 'UTF-8'))) {
                return "<img  src='/images/oil_icon/" . $oilIcon . ".ico' title='" . $title2[0] . "'  data-toggle=\"tooltip\"   width=16>";
            }
        }

        return "<img  src='/images/oil_icon/unknown.png'  title='" . $title2[0] . "'  data-toggle=\"tooltip\"   width=16>";


    }


    /** Русское имя файлов
     *
     * @param      $url
     * @param null $dropdown
     *
     * @return string
     */
    public static function filesRus($search)
    {
        foreach (self::$filesRus as $key => $rus) {
            if (stristr($search, $key)) {
                $date = explode("_", $search);

                return $rus . " от " . substr($date['0'], 6) . "." . substr($date['0'], 4, 2) . "." . substr($date['0'], 0, 4);
            }
        }

        return $search;
    }


    public static function financeDescrioption($search)
    {
        foreach (self::$financeFileDescription as $key => $rus) {
            if (stristr($search, $key)) {
                return $rus;
            }
        }

        return $search;
    }


    public static function validateAddress($address)
    {
        $address = str_replace("г.МоскваМосква", "г.Москва ", $address);
        $address = str_replace("Московская область", "Московская область ", $address);


        return $address;
    }


    public static function getYears($countYears = 4)
    {
        $array = [];
        for ($i = date(Y); $i > date(Y) - $countYears; $i--) {
            $array[$i] = $i;
        }

        return $array;
    }


    /** Для выпадающего списка
     *
     * @param array $array
     * @param       $corrent
     */
    public static function ul(array $array, $corrent, $keyName, $defaultValue)
    {


        foreach ($array as $key => $item) {
            if ($key == $corrent) {
                $defaultValue = $item;
            }
        }

        $data = " <div class=\"btn-group m-r-10\">
         <button aria-expanded=\"false\" data-toggle=\"dropdown\" class=\"btn-block btn-outline  btn-info dropdown-toggle waves-effect waves-light\" type=\"button\">" . $defaultValue . " <span class=\"caret\"></span></button>
           ";
        $data .= "<ul role=\"menu\" class=\"dropdown-menu animated flipInX\">\n";

        foreach ($array as $key => $item) {

            $data .= "<li><a href=\"?" . $keyName . "=" . $key . "\">" . $item . "</a></li>\n";

        }
        $data .= "</ul></div>\n";

        return $data;
    }


    /**Бухгалтерская отчетность группируем  Реализация товаров и услуг
     *
     * @param array $array
     */
    public static function financeTransaction(array $array)
    {
        $temp = [];
        foreach ($array as $key => $transaction) {

            $temp[$key]['ducument'] = $transaction['ducument'];
            $temp[$key]['date']     = self::normalDate($transaction['date'], false);
            $temp[$key]['motion']   = $transaction['motion'];
            $temp[$key]['summa']    = $transaction['summa'];

            if ($key > 0) {

                if ($temp[$key - 1]['ducument'] == $temp[$key]['ducument'] and $temp[$key - 1]['motion'] == $temp[$key]['motion'] and $temp[$key - 1]['date'] == $temp[$key]['date']) {
                    $temp[$key]['delete']    = 1;
                    $temp[$key - 1]['summa'] = $temp[$key - 1]['summa'] + $temp[$key]['summa'];
                }
            }
        }

        //Удаляем элемент из массива
        foreach ($temp as $key => $tem) {
            if ($tem['delete'] == 1) {
                if (isset($temp[$key['delete']])) {
                    ;
                }
                unset($temp[$key]);
            }
        }


        return $temp;
    }


    /**
     *Взять месчяцы от текущий даты
     */
    public static function getMonthForeach()
    {


        $date = new DateTime();
        $date->modify('+1 month');
        $array = [];
        for ($i = 0; $i < 12; $i++) {
            $date->modify('-1 month');

            $array[] = $date->format('n-Y');
        }

        return array_reverse($array);


    }


    /**Цвета для графиков
     *
     * @param null $transparency
     *
     * @return array
     */
    public static function getColor($n = 5, $transparency = null)
    {

        $array = ['236, 64, 122', '66, 165, 245', '38, 166, 154', '255, 238, 88', '156, 204, 101', '92, 89, 255', '255 157 104'];

        if (isset($transparency)) {
            $transparency = ",0.1";
        } else {
            $transparency = "";
        }

        $return = [];
        for ($i = 0; $i < $n; $i++) {
            if (isset($array[$i])) {
                $return[] = "rgb(" . $array[$i] . $transparency . ")";
            } else {
                $color = rand(1, 255) . "," . rand(128, 255) . "," . rand(128, 255);;
                $return[] = "rgb(" . $color . $transparency . ")";
            }

        }

        return $return;

    }


    /**Цвета для графиков
     *
     * @param null $transparency
     *
     * @return array
     */
    public static function getColor2($key, $n)
    {

        if ($key == 'АИ-95') {
            return 1;
        }

        if ($key == 'АИ-92') {
            return 0;
        }

        if ($key == 'АИ-98') {
            return 2;
        }

        if ($key == 'ДТ') {
            return 3;
        }


        return $n;


    }


    public static function getMonthForeach2()
    {


        $date = new DateTime();
        $date->modify('+1 month');

        $array = [];
        $m     = "";
        for ($i = 0; $i < 12; $i++) {


            $date->modify('-1 month');


            // Защита от дублей месяцев
            if ($m == $date->format('n')) {

                $date->modify('-1 month');
            }

            $m = $date->format('n');

            $array[] = \Yii::$app->params['ruMonth'][$m] . " " . $date->format('Y');

        }

        return (array_reverse($array));


    }


    public static function num2str($num)
    {
        $nul     = 'ноль';
        $ten     = [
            ['', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
            ['', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'],
        ];
        $a20     = ['десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать'];
        $tens    = [2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто'];
        $hundred = ['', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот'];
        $unit    = [ // Units
                     ['копейка', 'копейки', 'копеек', 1],
                     ['рубль', 'рубля', 'рублей', 0],
                     ['тысяча', 'тысячи', 'тысяч', 1],
                     ['миллион', 'миллиона', 'миллионов', 0],
                     ['миллиард', 'милиарда', 'миллиардов', 0],
        ];
        //
        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }
                $uk     = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                } # 20-99
                else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                } # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            } //foreach
        } else {
            $out[] = $nul;
        }
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        $data  = trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));


        return self::mb_ucfirst($data);
    }

    /**
     * Склоняем словоформу
     * @ author runcore
     */
    private static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }
        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }
        if ($n == 1) {
            return $f1;
        }

        return $f5;
    }


    /** Cклонения существительных
     *
     * @param $n
     * @param $form1
     * @param $form2
     * @param $form3
     *
     * @return mixed
     */
    public static function plural($n, $form1, $form2, $form3)
    {
        $plural = ($n % 10 == 1 && $n % 100 != 11 ? 0 : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 or $n % 100 >= 20) ? 1 : 2));
        switch ($plural) {
            case 0:
            default:
                return $form1;
            case 1:
                return $form2;
            case 2:
                return $form3;
        }
    }


    public static function nds($summa)
    {
        return $summa / 1.18 * 0.18;
    }


    public static function getToplivo($now = 1, $param = 'summa')
    {
        $gg = "";


        if ($now == 1) {
            $n = date("n");
        } else {
            $n = date('n', strtotime('first day of previous month'));
        }


        if (\Yii::$app->session['toplivo']) {
            $top = Json::decode(\Yii::$app->session['toplivo']);

            $nn = 0;
            foreach ($top as $toplico) {


                if ($top[0]['pDay']) {

                    if ($n == $toplico['pMonth'] and date("Y") == $toplico['pYear']) {
                        $nn = $nn + $toplico[$param];
                    }


                } else {

                    if ($n == $toplico['pMonth'] and date("Y") == $toplico['pYear']) {
                        return $toplico[$param];
                    }
                }


                //return $toplico[$param];//закоментиорвать

            }
            if ($top[0]['pDay']) {
                return $nn;
            }


        }

        // return $gg;

    }


    public static function getMont($now = 1)
    {
        $gg = "";


        if ($now == 1) {
            $n = date("n");
        } else {
            $n = date('n', strtotime('first day of previous month'));
        }

        return \Yii::$app->params['ruMonth'][$n];


        // return $gg;

    }

    public static function getStatusCard($status)
    {

        switch ($status) {
            case '81D78BAB7F30C39A427AC024BC45119F':
                $data = 'Активна';
                break;
            case 'B0750601E13D90F3485BCD7EAB90AA21':
                $data = 'Заблоктрована';
                break;
            case '8C7949980F94169B4210E69D6F962E04':
                $data = 'Стоп лист';
                break;
            case '877F5E4C39BDAFFE4860691C5AE5C1BA':
                $data = 'Стоп лист';
                break;


        }

        return $data;


    }


    /** Получить количество карт
     *
     * @param string $status
     *
     * @return mixed
     */
    public static function getCountCards($status = 'all')
    {


        $cards = JSON::decode(\Yii::$app->session['countCard']);


        if ($status == 'blockAll') {
            return $cards['all'] - $cards['active'] - $cards['block'];
        }

        if ($status == 'activeAll') {
            if ($cards['block'] > 0) {
                return $cards['all'] - $cards['active'];
            } else {
                return $cards['active'];
            }
        }


        return $cards[$status];


    }


    /** Чекбоксы типов топлива
     *
     * @param null $fuels
     * @param null $param
     *
     * @return string
     */
    public static function fuelCheckbox($fuels = null, $param = null, $cc = null)
    {


        $checkbox = "";
        $ff       = \Yii::$app->params['oil'];
        if (isset($cc) and (mb_strlen($cc) != '10')) {

            unset($ff[0]);
        }


        foreach ($ff as $key => $oil) {

            $cheked = false;

            if (isset($fuels)) {
                foreach (explode(",", $fuels) as $fue) {
                    if (trim($fue) == trim($oil)) {
                        $cheked = true;
                    }
                }
            }


            $checkbox .= '<label>' . Html::checkbox("fuel[" . $cc . "][" . $oil . "]", $cheked, $param) . " " . $oil . '</label>  <br>';


        }

        return $checkbox;


    }

    /**Мое полное имя
     * @return string
     */
    public static function getMyName($user = null)
    {

        if ($user) {

        }


        $name = "";
        $name .= \Yii::$app->user->identity->surname . "  ";

        if (!empty(\Yii::$app->user->identity->first_name)) {
            $name .= mb_substr(\Yii::$app->user->identity->first_name, 0, 1) . ".";
        }
        if (!empty(\Yii::$app->user->identity->patronymic)) {
            $name .= mb_substr(\Yii::$app->user->identity->patronymic, 0, 1) . ".";
        }


        if (trim($name) == '') {
            $name = 'Пользователь';
        }

        return $name;
    }


    public static function mySubstr($text, $lenght = 50)
    {
        if (mb_strlen($text) > $lenght) {

            $string = substr($text, 0, $lenght);
            $end    = strlen(strrchr($string, ' '));
            $end2   = strlen(strrchr($string, '-'));


            if ($end > $end2) {
                $end3 = $end;
            } else {
                $end3 = $end2;
            }

            $string = substr($string, 0, -$end3);
            $text   = "<span title=' " . $text . " '  data-toggle=\"tooltip\">" . $string . "...</span>";
        }


        return $text;


    }

    public static function mb_ucfirst($string, $encoding = "UTF-8")
    {
        $strlen    = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then      = mb_substr($string, 1, $strlen - 1, $encoding);

        return mb_strtoupper($firstChar, $encoding) . $then;
    }


    public static function Pdf($name, $html)
    {

        $html                      .= "<br><br> Отчет сформирован: ";
        $formatter                 = new \yii\i18n\Formatter;
        $formatter->datetimeFormat = 'php:d.m.Y H:i';
        $formatter->timeZone       = 'Europe/Moscow';
        $html                      .= $formatter->asDateTime("now");


        $pdf = new Pdf([
            'orientation'  => Pdf::ORIENT_LANDSCAPE,
            //  'mode' => Pdf::MODE_CORE,
            //  'destination'=> Pdf::DEST_DOWNLOAD,
            'destination'  => Pdf::DEST_BROWSER,
            //  'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline'    => ' body{background-color: #fff;} ',
            'filename'     => 'Report.pdf',
            'marginRight'  => '5',
            'marginLeft'   => '5',
            'marginTop'    => '5',
            'marginBottom' => '10',
            'options'      => ['title' => 'Report'],

        ]); // or new Pdf();


        $mpdf = $pdf->api; // fetches mpdf api


        $mpdf->shrink_tables_to_fit = 8;
        $mpdf->use_kwt              = true;
        $mpdf->table_keep_together  = true;


        // $mpdf->WriteHtml($html); // call mpdf write html


        //$filename = \Yii::$app->basePath . '/temp/invoices/'.$filename.'.pdf';

        $file_name = $name . '_' . date("Y-m-d") . ".pdf";
        $pdf->Output($html, $file_name); // call the mpdf api output as needed
        $pdf->render();


    }


    public static function Exel($name, $html)
    {
        $dir = __DIR__ . '/../../yii/vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';
        require_once($dir);

        $data = $html;


        $helper = new Sample();
        if ($helper->isCli()) {
            //  echo 'This example should only be run from a Web Browser' . PHP_EOL;
            return;
        }

        $spreadsheet = new Spreadsheet();


        $richText = new RichText();


        $payable = $richText->createTextRun('КАРДЕКС');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', $richText);

        $richText = new RichText();
        $payable  = $richText->createTextRun($name);
        $payable->getFont()->setBold(false);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A2', $richText);

        $richText = new RichText();
        $payable  = $richText->createTextRun('Компания: ' . \Yii::$app->session['company']);
        $payable->getFont()->setBold(false);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('Договор: ' . \Yii::$app->session['dogovor']);
        $payable->getFont()->setBold(false);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A4', $richText);

        $richText = new RichText();
        $payable  = $richText->createTextRun('Отчет сформирован: ' . date('d.m.Y'));
        $payable->getFont()->setBold(false);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A5', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('Карта');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A7', $richText);

        $richText = new RichText();
        $payable  = $richText->createTextRun('Дата');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('B7', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('Держатель');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('C7', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('ТО');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('D7', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('Ардрес ТО');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('E7', $richText);


        $richText = new RichText();
        $payable  = $richText->createTextRun('Услуга');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('F7', $richText);
        $richText = new RichText();
        $payable  = $richText->createTextRun('Операция');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('G7', $richText);
        $richText = new RichText();
        $payable  = $richText->createTextRun('Количество');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('H7', $richText);
        $richText = new RichText();
        $payable  = $richText->createTextRun('Цена на ТО');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('I7', $richText);
        $richText = new RichText();
        $payable  = $richText->createTextRun('Стоимость на ТО');
        $payable->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->setCellValue('J7', $richText);


        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:J1');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A2:J2');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A3:J3');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A4:J4');
        $spreadsheet->setActiveSheetIndex(0)->mergeCells('A5:J5');


        $n = 8;

        $summa = $summa2 = 0;
        foreach ($data as $dat) {


            $oils = "";
            foreach (explode(",", $dat['oil']) as $oil) {
                $oils .= $oil . " ";
            }

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $n, "#" . $dat['CodCard'])//, PHPExcel_Cell_DataType::TYPE_STRING
                ->setCellValue('B' . $n, Help::normalDate($dat['Period'], false, 'd.m.Y H:i:s'))
                ->setCellValue('C' . $n, $dat['owner'])
                ->setCellValue('D' . $n, $dat['postavka'])
                ->setCellValue('E' . $n, Help::mySubstr(Help::validateAddress($dat['address']), 120))
                ->setCellValue('F' . $n, $oils)
                ->setCellValue('G' . $n, $dat['vid'])
                ->setCellValue('H' . $n, mb_substr($dat['counts'], 0, -1))
                ->setCellValue('I' . $n, $dat['price'])
                ->setCellValue('J' . $n, $dat['summa']);

            $summa  = $summa + $dat['summa'];
            $summa2 = $summa2 + mb_substr($dat['counts'], 0, -1);


            $n++;
        }


        //$spreadsheet->getActiveSheet()->getStyle('A1:C1')->getFont()->setSize(16);
        $n++;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('J' . $n, $summa);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('H' . $n, $summa2);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $n, 'Итого: ');


        // Create new Spreadsheet object

        // Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Maarten Balliauw')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');
        // Add some data
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');

        $spreadsheet->getActiveSheet()
            ->setCellValue('B1', 'Simple')
            ->setCellValue('C1', 'PhpSpreadsheet');


        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(25);   //ширина колонок
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(35);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(35);


        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        $fname = urlencode("Оборот_по_обслуживанию_");


        header('Content-Disposition: attachment;filename=' . $fname . date("Y-m-d") . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        exit;


    }


}