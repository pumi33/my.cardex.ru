<?php

namespace my\models;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;
use my\helpers\Help;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Login form
 */
class Report extends Model
{
    private       $filtercard = null;
    public static $oils       = [];


    public function setFilterCard($cards)
    {
        $this->filtercard = $cards;
    }


    public function getTransaction($response, $param = 'kolvo', $owner2 = 'owner', $group = 'CodCard')
    {


        $group = 'oil';


        if ($response->isOk) {


            $data  = [];
            $owner = [];
            foreach (Help::getMonthForeach() as $key => $value) {
                $value2 = explode("-", $value);


                //заполняем нулями
                foreach (($response->data) as $rdata) {
                    $data[$rdata[$group]][$key] = 0;
                    $owner[$rdata[$group]]      = $rdata[$group];
                }


                // распеределяем данные
                foreach ($response->data as $rdata) {
                    if ($value2['1'] == $rdata['pYear'] and $value2['0'] == $rdata['pMonth']) {
                        $data[$rdata[$group]][$key] = $rdata[$param];
                    }


                }

            }


        }


        $dd['data']  = $data;
        $dd['owner'] = $owner;


        return $dd;
    }


    public function getTransactionOld($act = 'groupbycard', $param = 'kolvo', $owner2 = 'owner', $group = 'CodCard')
    {
        $client   = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl(\Yii::$app->params['api-url'] . '/dogovors/transaction/')
            ->setData(['dogovor' => \Yii::$app->user->identity->dogovor_guid, 'act' => $act, 'filtercard' => $this->filtercard])
            ->send();


        if ($response->isOk) {


            $data  = [];
            $owner = [];
            foreach (Help::getMonthForeach() as $key => $value) {
                $value2 = explode("-", $value);


                //заполняем нулями
                foreach (($response->data) as $rdata) {
                    $data[$rdata[$group]][$key] = 0;
                    $owner[$rdata[$group]]      = $rdata[$group] . " (" . $rdata[$owner2] . ")";

                }


                // распеределяем данные
                foreach ($response->data as $rdata) {
                    if ($value2['1'] == $rdata['pYear'] and $value2['0'] == $rdata['pMonth']) {
                        $data[$rdata[$group]][$key] = $rdata[$param];
                    }


                }

            }

        }


        $dd['data']  = $data;
        $dd['owner'] = $owner;


        return $dd;
    }


    public static function forChart($data, $group)
    {


        $results_data = ArrayHelper::index($data->data, null, 'fulldate');
        $results_oil  = ArrayHelper::index($data->data, null, 'oil');


        $dats = [];
        foreach ($results_data as $key => $result) {

            foreach ($results_oil as $oil => $ollll) {

                $ok[$oil] = 0;
                foreach ($result as $res) {

                    if ($res['oil'] == $oil) {
                        $dt[$oil][] = $res[$group];
                        $ok[$oil]   = 1;
                    }
                }
                if ($ok[$oil] == 0) {
                    $dt[$oil][] = 0;
                }


            }


            if (count($keys = explode('-', $key)) == 2) {
                //месяц
                $key2 = \Yii::$app->params['ruMonth'][$keys[1]] . " " . $keys[0];
            } else {
                $key2 = $keys[2] . " " . \Yii::$app->params['ruMonthSkl'][$keys[1]] . " " . $keys[0];
            }

            $dats[] = $key2;


        }

        self::$oils[$group] = $dats;


        $colors = Help::getColor(50);


        $js = "";
        $n  = 0;


        //  print_r($results_oil);
        //    $collator = new \Collator('ru_RU)');
        //$collator->sort($results_oil);


        if (\Yii::$app->session['is_admin']) {


            //    print_r($results_oil);

        }

        foreach ($results_oil as $key => $dat) {


            $js .= "{
                                    label: '" . $key . "',
                                    data: " . Json::encode($dt[$key]) . ",
                                    backgroundColor:'" . $colors[Help::getColor2($key, $n)] . "',
                                    borderColor: '" . $colors[Help::getColor2($key, $n)] . "',
                                    fill: false,
                                   
                                },\n";
            $n++;
        }


        return substr($js, 0, -1);


    }


    public static function forBar($response, $tipe)
    {


        $colors = Help::getColor(10);

        if ($response->isOk) {
            $n = 0;
            foreach ($response->data as $rdata) {
                //  print_r($rdata);
                $dat[]  = $rdata['oil'];
                $type[] = round($rdata[$tipe], 2);
                //$color[] = $colors[$n];
                $color[] = $colors[Help::getColor2($rdata['oil'], $n)];


                $n++;
            }
        }


        return $js = "data: " . Json::encode($type) . ",
                backgroundColor: " . Json::encode($color) . ",
                label: 'Dataset 1'
            }],
            labels: " . Json::encode($dat) . "";
    }


    public static function getTable($datas, $date1 = null, $date2 = null, $option = [])
    {


        $html = "";
        if (isset($option['print'])) {
            $html = "<h4 align='center'>" . $option['name'] . " (" . \Yii::$app->session['company'] . ") ";
            $html .= "<br>Договор " . \Yii::$app->session['dogovor'] . " </h4>";
            //   $html .= "<style> th{ border:  1px solid black; margin:0px;padding:0px}</style>";


            $date1 = date("d.m.Y", strtotime($date1));
            $date2 = date("d.m.Y", strtotime($date2));


            $html .= "<h5 align='center'>С " . $date1 . " по " . $date2 . "</h5>";
        }


        if ($datas) {


            $html .= ' <table id="dt2" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Карта</th>
                    <th>Дата</th>
                    <th>Держатель</th>
                    <th>ТО</th>
                    <th>Адрес ТО</th>
                    <th>Услуга</th>
                    <th>Операция</th>
                    <th>Количество</th>
                    <th>Цена на ТО</th>
                    <th>Стоимость на ТО</th>

                </tr>
                </thead>
                <tbody>';

            $i = 1;

            $n = 0;
            foreach ($datas as $d) {


                $n++;
                $i  = -$i;
                $rr = $i;


                $html .= "<tr bgcolor=\"#f0f8ff\" ";

                if ($i == 1) {
                    $html .= "style=\"background-color:'#fff\' !important;\"> ";
                } else {
                    $html .= "style=\"background-color:'#f0f8ff\' !important;\"> ";
                }

                $html .= "  <td> ";


                if (isset($option['print'])) {
                    $html .= $d['CodCard'];
                } else {
                    $html .= "   <a href=\"/card/info/" . $d['CodCard'] . " \" data-toggle=\"modal\"
                                                   data-target=\"#myModal\"
                                                   data-remote=\"false\"> " . $d['CodCard'] . "</a>";
                }


                $html .= "  </td>
                                            <td> " . Help::normalDate($d['Period'], false, 'd.m.Y H:i:s') . "</td>
                                            <td>" . $d['owner'] . "</td>
                                            <td>";

                if (isset($option['print'])) {
                    $html .= Help::mySubstr($d['postavka'], 50);
                } else {
                    $html .= Help::iconOil($d['postavka']);
                }
                $html .= "</td>
                                            <td>" . Help::mySubstr(Help::validateAddress($d['address']), 60) . "</td>
                                            <td>";


                foreach (explode(",", $d['oil']) as $oil) {
                    $html .= "<span class=\"badge\">" . $oil . "</span>";
                }

                $html .= "</td>

                                            <td> " . $d['vid'] . "</td>
                                            <td align=\"center\">" . mb_substr($d['counts'], 0, -1) . "</td>
                                            <td>" . $d['price'] . "</td>
                                            <td>" . $d['summa'] . "</td>
                                        </tr>";


            }

            $html .= " </tbody>
            </table></div>";


        } else {
            if (isset($option['notfound'])) {
                $html = $option['notfound'];
            }
        }

        return $html;


    }


}