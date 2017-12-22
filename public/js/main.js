/*----------------------------*/
/*  MENU  */
/*----------------------------*/
$('.menu li').hover(function () {
    $(this).find('ul').toggle();
});
$('.mobile-menu li').click(function () {
    $(this).find('ul').toggle();
});

function menuSwitcher() {
    if ($(window).width() < 1330) {
        $('.mobile-switch').attr('href', '#');
        $('.mobile-toggle').click(function () {
            $('.mobile-menu').toggle();
        });
    } else {
        $('.mobile-switch').attr('href', '/');
        $('.mobile-toggle').unbind("click");
    }
}
menuSwitcher();

$(window).resize(function () {
    menuSwitcher();
});

/*----------------------------*/
/*  FIXED ELEMENT  */
/*----------------------------*/
function fixToTop() {
    var getElement = $('.fix-to-top');

    if (getElement.length != 0) {
        var div = '<div class="fix-placeholder"></div>';
        var body = $('body');

        if (body.find('.fix-placeholder').length == 0) {
            getElement.after(div);
        }
        getElement.css({'position': 'fixed'});
        body.find('.fix-placeholder').css({'width': '100%', 'height': getElement.height() + 'px'});
    }

}
fixToTop();
$(window).resize(function () {
        fixToTop();
    }
);

/*----------------------------*/
/*  FORM VALIDATE  */
/*----------------------------*/
/*
$('#account-enter').validate({
    rules: {
        login: {
            required: true
        },
        pass: {
            required: true
        }
    },
    messages: {
        login: {
            required: "Введите Ваш логин"
        },
        pass: {
            required: "Введите Ваш пароль"
        }
    },
    submitHandler: function (form,event) {
       //console.log(form);
        //event.trigger()
        //$(form).submit();
    }
});

$('#add-money').validate({
    rules: {
        account: {
            required: false
        },
        money: {
            required: false
        }
    },
    messages: {
        account: {
            required: "Введите Ваш номер счёта"
        },
        money: {
            required: "Введите сумму"
        }
    }//,
    /*submitHandler: function (form,event) {
     console.log(form,event);
       // event.trigger()

});
$('#pass-recover').validate({
    rules: {
        phone: {
            required: true
        },
        account: {
            required: true
        }
    },
    messages: {
        phone: {
            required: "Введите Ваш номер телефона"
        },
        account: {
            required: "Введите Ваш номер счёта"
        }
    }/*,
    submitHandler: function (form) {
        console.log(form);

});

*/

/*----------------------------*/
/*  error msg  */
/*----------------------------*/

$(document).ready(function(){
    if($('.error_msg').size()>0){
       var msg = $('.error_msg').html()
        console.log(msg.match(/<br>/i))
        //$('.error_msg').html(msg.replace("<br>",""))
        if(msg.match(/<br>/i)!=null){
            var arr= msg.split('<br>')

            $('.error_login').html(arr[0]).show()
            $('.error_pass').html(arr[1]).show()
        }else if(msg.match(/Логин/i)!=null){
            $('.error_login').html(msg).show()
        }else if(msg.match(/Пароль/i)!=null){
            $('.error_pass').html(msg).show()
        }else{
            $('.error_msg').show()
        }
       // $('.error_msg').show()
       // console.log(msg)
    }
})

$('#pass-recover').on('submit',function(e){
  //  e.preventDefault();
    var val = $('#phone').cleanVal();
    $('#phone').val('+7'+val)
  //  $(this).submit();

})


window.setTimeout(function() {


    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 5000);




