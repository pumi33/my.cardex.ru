<?
$this->registerJs("

var now = new Date()


var buttonCommon = {
exportOptions: {
format: {
body: function ( data, row, column, node ) {
// Strip $ from salary column to make it numeric
data = $('<p>' + data + '</p>').text();

if ( column === 0) {

data='#'+data;
}

return data;

}
}
}
};



function gettime()
{
var date = new Date();
var newdate = date.getFullYear()+'-'+date.getMonth()+'-'+date.getDate();
//setInterval(gettime, 1000);
return newdate;
}



jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
return this.flatten().reduce( function ( a, b ) {
if ( typeof a === 'string' ) {
a = a.replace(/[^\d.-]/g, '') * 1;
}
if ( typeof b === 'string' ) {
b = b.replace(/[^\d.-]/g, '') * 1;
}

return a + b;
}, 0 );
} );















$('#dt').DataTable({

'order': [[ 1, 'desc' ]],

drawCallback: function () {
var api = this.api();

},


dom: 'B',



buttons: [
{
extend: 'pdfHtml5',
orientation: 'landscape',
pageSize: 'LEGAL',
text:      '<i class=\"fa fa-file-pdf-o\"></i>',
titleAttr: 'PDF',
filename: '*_' + gettime(),



exportOptions: {
//  columns: [0,1,2,3,4,5,6,7,8,9],



format: {
body: function ( data, row, column, node ) {
// Strip $ from salary column to make it numeric

if(column===3){
var DOM= $(\"<div>\" + data + \"</div>\");
data=  $('img', DOM).attr(\"title\")



}else if(column===1){

data = data.split(' ').join(\"\\n\\t\");

}else{

data = data.replace(/<.*?>/g, \"\");


}
return data;

}
}



},


},
$.extend( true, {}, buttonCommon, {
extend: 'excelHtml5',




text:      '<i class=\"fa fa-file-excel-o\">aaa</i>',
titleAttr: 'Excel',
filename: '*_' + gettime(),


exportOptions: {
//  columns: [0,1,2,3,4,5,6,7,8,9],



format: {

header:  function (data, columnIdx) {
return columnIdx + ': ' + data + \"\"
},



body: function ( data, row, column, node ) {
// Strip $ from salary column to make it numeric

if(column===3){
var DOM= $(\"<div>\" + data + \"</div>\");
data=  $('img', DOM).attr(\"title\")



}else if(column===1){

data = data.split(' ').join(\"\\n\\t\");


}else if ( column === 0) {
data = data.replace(/<.*?>/g, \"\");

data='#'+data.trim();


}else{

data = data.replace(/<.*?>/g, \"\");

}
return data;

}
}
}


} ),


{
extend:    'copyHtml5',
text:      '<i class=\"fa fa-files-o\"></i>',
titleAttr: 'Копировать',
title: 'КАРДЕКС \\n'+'* ' +' \\n Договор: ".\Yii::$app->session['dogovor']."',
},
{
extend:    'print',
text:      '<i class=\"fa fa-print\"></i>',
titleAttr: 'Печать',
title: '<div  align=center>КАРДЕКС \\n<br>'+'* ' +' \\n<br> Договор: ".\Yii::$app->session['dogovor']." </div>',
},



],
\"language\": {
\"url\": \"/plugins/bower_components/datatables/russian.json\"
}

});




"
);

?>



<br><br>

<table id="dt" class="display nowrap" cellspacing="0" width="100%">
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
    <tbody>

    <tr>
        <td>
            <a href="/card/info/7824861010033266274" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033266274</a>
        </td>
        <td>28.06.2017 11:05:07</td>
        <td>-</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td>Московская область Горки-6, -, -</td>
        <td>
            <span class="badge">ДТ</span>                                </td>

        <td> Покупка.</td>
        <td align="center">30.00</td>
        <td>38.92</td>
        <td>1167.60</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265458" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265458</a>
        </td>
        <td>28.06.2017 09:38:39</td>
        <td>р204хр197</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td><span title=' Московская область Кашира, 115км+900м а/д Егорьевск-Коломна-Кашира-Ненашево, Иваньковское шоссе, 2 '  data-toggle="tooltip">Московская область Кашира,...</span></td>
        <td>
            <span class="badge">ДТ</span>                                </td>

        <td> Покупка.</td>
        <td align="center">25.00</td>
        <td>38.62</td>
        <td>965.50</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265417" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265417</a>
        </td>
        <td>28.06.2017 05:55:11</td>
        <td>в908ат197</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td><span title=' Московская область Балашиха, р-н мкр. Гагарина, 21 км, трасса А103 Щелковское, левая сторона, - '  data-toggle="tooltip">Московская область Балашиха, р...</span></td>
        <td>
            <span class="badge">АИ-95</span>                                </td>

        <td> Покупка.</td>
        <td align="center">42.00</td>
        <td>41.65</td>
        <td>1749.30</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265839" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265839</a>
        </td>
        <td>27.06.2017 21:14:43</td>
        <td>-</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td>г.Москва , Свободы, 99</td>
        <td>
            <span class="badge">АИ-95</span>                                </td>

        <td> Покупка.</td>
        <td align="center">40.00</td>
        <td>41.80</td>
        <td>1672.00</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265391" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265391</a>
        </td>
        <td>27.06.2017 18:47:59</td>
        <td>н781хс197</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td>Московская область д.Новотроицкое, 81 км, -</td>
        <td>
            <span class="badge">АИ-95</span>                                </td>

        <td> Покупка.</td>
        <td align="center">35.00</td>
        <td>41.65</td>
        <td>1457.75</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265466" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265466</a>
        </td>
        <td>27.06.2017 15:25:25</td>
        <td>р134ар777</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td><span title=' Московская область Реутов, вл. 5, МКАД, 2 км, внешняя сторона, - '  data-toggle="tooltip">Московская область Реутов, вл. 5,...</span></td>
        <td>
            <span class="badge">ДТ</span>                                </td>

        <td> Покупка.</td>
        <td align="center">36.57</td>
        <td>38.62</td>
        <td>1412.33</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265383" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265383</a>
        </td>
        <td>27.06.2017 09:52:06</td>
        <td>в454ус77</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td>г.Москва , Римского-Корсакова, 5</td>
        <td>
            <span class="badge">АИ-95</span>                                </td>

        <td> Покупка.</td>
        <td align="center">40.00</td>
        <td>41.80</td>
        <td>1672.00</td>
    </tr>

    <tr>
        <td>
            <a href="/card/info/7824861010033265458" data-toggle="modal"
               data-target="#myModal" data-remote="false"> 7824861010033265458</a>
        </td>
        <td>27.06.2017 08:56:37</td>
        <td>р204хр197</td>
        <td><img  src='/images/oil_icon/lukoil.ico' title='ООО "ЛУКОЙЛ-Центрнефтепродукт" Москва'  data-toggle="tooltip"   width=16></td>
        <td><span title=' Московская область Кашира, 115км+900м а/д Егорьевск-Коломна-Кашира-Ненашево, Иваньковское шоссе, 2 '  data-toggle="tooltip">Московская область Кашира,...</span></td>
        <td>
            <span class="badge">ДТ</span>                                </td>

        <td> Покупка.</td>
        <td align="center">25.00</td>
        <td>38.62</td>
        <td>965.50</td>
    </tr>
    </tbody>
</table>