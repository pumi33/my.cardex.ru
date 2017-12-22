$('.pre-selected-options-block').multiSelect({
    selectableHeader: "<div class=\"btn btn-block btn-outline btn-success\">Активные карты</div> <input type='text' class='search-input' autocomplete='off' placeholder='номер карты'>",
    selectionHeader: "<div class=\"btn btn-block btn-outline btn-danger\"> Стоп лист</div><input type='text' class='search-input' autocomplete='off' placeholder='номер карты'>",

    afterInit: function (ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function (e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function (e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function () {
        this.qs1.cache();
        this.qs2.cache();
        $('#block-card-button').removeAttr('disabled');


    },
    afterDeselect: function () {
        this.qs1.cache();
        this.qs2.cache();

     count = $(".pre-selected-options-block :selected").length;
        if(count==0){
            $('#block-card-button').attr('disabled', true);
        }



    }

});



$('.pre-selected-options-unblock').multiSelect({
    selectableHeader: "<div class=\"btn btn-block btn-outline btn-danger\">Стоп лист</div> <input type='text' class='search-input' autocomplete='off' placeholder='номер карты'>",
    selectionHeader: "<div class=\"btn btn-block btn-outline btn-success\">Активировать карты</div><input type='text' class='search-input' autocomplete='off' placeholder='номер карты'>",

    afterInit: function (ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function (e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function (e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function () {
        this.qs1.cache();
        this.qs2.cache();
        $('#block-card-button').removeAttr('disabled');
    },
    afterDeselect: function () {
        this.qs1.cache();
        this.qs2.cache();

        count = $(".pre-selected-options-unblock :selected").length;
        if(count==0){
            $('#block-card-button').attr('disabled', true);
        }

    }

});


$('.pre-selected-options2').multiSelect({
    selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='номер карты / владелец'>",
    selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='номер карты / владелец '>",
    selectionFooter: "<div class='custom-header' class='btn'><input type='button' class='btn btn-default btn-sm' id='button_limite' value='Изменить лимиты'  style='width: 100%'></div>",
    afterInit: function (ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function (e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function (e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function () {
        this.qs1.cache();
        this.qs2.cache();
        $('.custom-header').show();
    },
    afterDeselect: function () {
        this.qs1.cache();
        this.qs2.cache();

        $('.custom-header').show();
    }
});


$('.pre-selected-options-analytics').multiSelect({
    selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='номер карты / владелец'>",
    selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='номер карты / владелец '>",
    selectionFooter: "<div class='custom-header2' class='btn'><input type='button' class='btn btn-default btn-sm' id='button_select'  value='Построить графики для выбранных карт' style='width: 100%'></div>",
    afterInit: function (ms) {
        var that = this,
            $selectableSearch = that.$selectableUl.prev(),
            $selectionSearch = that.$selectionUl.prev(),
            selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
            selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

        that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function (e) {
                if (e.which === 40) {
                    that.$selectableUl.focus();
                    return false;
                }
            });

        that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function (e) {
                if (e.which == 40) {
                    that.$selectionUl.focus();
                    return false;
                }
            });
    },
    afterSelect: function () {
        this.qs1.cache();
        this.qs2.cache();
        $('.custom-header').show();
    },
    afterDeselect: function () {
        this.qs1.cache();
        this.qs2.cache();

        $('.custom-header').show();
    }
});







$('.mm').click(function () {

alert(1);
});

$('#button_limite').click(function () {

    nomer='';
    $(".ms-elem-selection.ms-selected span").each(function () {
        arra_text = $(this).text().split(" ");
        nomer = nomer+arra_text[0]+'|';
    });
    window.location.href = window.location.pathname+"?"+$.param({'theme':'4','cards':nomer})
});







$('#button_select').click(function () {

    nomer='';
    $(".ms-elem-selection.ms-selected span").each(function () {
        arra_text = $(this).text().split(" ");
        nomer = nomer+arra_text[0]+'|';
    });
    window.location.href = window.location.pathname+"?"+$.param({'select':'1','cards':nomer})
});


/*

$('#button_limite').click(function () {


    $(".mylimite").html('<br><br><table width="160%" border="0" class="addtable">');

    if ($(".ms-elem-selection.ms-selected span").length > 0) {

        var selectedValues = [];
        $(".d3 .ms-elem-selection.ms-selected span").each(function () {
            //alert($(this).text());

            arra_text = $(this).text().split(" ");
            nomer = arra_text[0];


            if (nomer.length == '10') {
                disabled = ' disabled ';
            } else {
                disabled = '  ';
            }

            s_vid = '<select ' + disabled + '>';
            oils.forEach(function (item, i, arr) {
                if (item == card_fuel[nomer]) {
                    selected = ' selected ';
                } else {
                    selected = '';
                }


                s_vid = s_vid + '<option ' + selected + '>' + item + '</option>';
            });
            s_vid = s_vid + '</select>';


            s_type = '<select>';
            types.forEach(function (item, i, arr) {
                if (item == card_type[nomer]) {
                    selected = ' selected ';
                } else {
                    selected = '';
                }

                s_type = s_type + '<option ' + selected + '>' + item + '</option>';
            });
            s_type = s_type + '</select>';


            llim = card_limite[nomer];

            td = '<tr><td colspan="2"><hr></he></td></tr><tr><td>Карта</td><td><span class="navbar-title2">' + $(this).text() + '</span></td></tr>';


            if (nomer.length == '10') {
                td = td + '<tr><td>Вид топлива</td><td>' + s_vid + ' Для смены вида топлива необходимо приехать к нам в офис</td></tr>';
            } else {
                addid='foradd'+nomer;
                addid=  addid.toString()
                td = td + '<tr><td>Вид топлива</td><td>' + s_vid + ' <span class="jvectormap-zoomin mm" onclick="addOil(' + nomer + ')">+</span>' +
                    '<span id="j'+nomer+'" class="ggg">111</span> </td></tr>';
            }

            td = td + '<tr><td>Лимит</td><td><input type="number"  class="lim10" value="' + llim + '"> литров ' + s_type + '</td></tr>';

            $(".mylimite table").append(td);


            selectedValues.push($(this).text());


        });


        $(".mylimite ").append('</table>');

        //  alert(card_limite.m1162002444)
        //  $(".mylimite").html(selectedValues);


    }


});

function addOil(id) {

    var name = document.getElementById(id).value;

    console.log(name);
    //   alert(fors);

    //$(".ggg").append("aaaaaaaaaaaaaa");

    $('#j' + id).append("aaa444aaaaaaaaaaa");
    $('#j' + id).hide();
    //  alert(id);
}

*/