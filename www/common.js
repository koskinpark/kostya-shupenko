function doClear(theText) {
    if (theText.value == theText.defaultValue) { theText.value = "" }
}
function doDefault(theText) {
    if (theText.value == "") { theText.value = theText.defaultValue }
}

function task2() {
    $(".js").snippet("javascript",{style:"random",transparent:true,showNum:false});
    var task = document.getElementById('margin');
    var wrapper = document.createElement("div");
    var select = document.createElement("select");
    task.appendChild (wrapper);

    wrapper.className = 'select-task2';

    select.size = 10;
    wrapper.appendChild (select);

    for ( var i = 0; i < 16; i++ )
    {
        option = new Option ("Option #" + i.toString(), i, false, false);
        select.options[select.options.length] = option;
        option.ondblclick = function() {select.remove (select.selectedIndex)};
    }
}


var behaviors = {};



behaviors.attach_task_8 = function(context) {
    $('#id_task8', context).submit(function() {
        var $form = $(this);
        var val = $("#id_of_counts").val();
        //отправляю POST запрос и получаю ответ
        console.log($form.attr('action'));
        $.ajax({
            url: $form.attr('action') + '?ajax',
            type: 'post',//тип запроса: get,post либо head
            data: 'counts=' + $('#id_of_counts', $form).val(),//параметры запроса
            success: function (data) {//возвращаемый результат от сервера
                $('#result').html(data);
            }
        });
        return false;
    });
}

$(document).ready(function () {


        $("#feedback-wrap").hide();

        // fade in #back-top
        $(function () {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 200) {
                    $('#feedback-wrap').fadeIn("slow");
                } else {
                    $('#feedback-wrap').fadeOut("slow");
                }
            });

            // scroll body to 0px on click
            $('#feedback-wrap').click(function () {
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });


    $('#scroll-to-contacts').click(function() {
        var curPos=$(document).scrollTop();
        var height=$("body").height();
        var scrollTime=(height-curPos)/1.73;
        $("body,html").animate({"scrollTop":height},scrollTime);
    });



    $('a.use-ajax:not(.use-ajax-processed)').each(function(){
       $(this).click(function() {
           var a = $(this);
           $.ajax({

               url: a.attr('href') + "?ajax",
               success: function(data) {
                   $('.task1-content').html(data);
                   for (behavior in behaviors) {
                       console.log(behavior);
                       behaviors[behavior]($('.task1-content'));
                   }
               }
           });
           return false;
       });
    }).addClass('use-ajax-processed');

    var give_logins_passs = function () {
        $('.generate-stuff .login-container a').on('click', function () {
            $('#login-reg').val(($(this).text()));
            return false;
        });
        $('.generate-stuff .password-container a').on('click', function () {
            $('#pass-reg').val(($(this).text()));
            return false;
        });
    }

    $('#gen-submit').on('click', function () {
        if (!$('.generate-stuff').hasClass('visible')) {
            $('.generate-stuff').toggle("slow").addClass('visible');
        }
        else {
            $.ajax({
                url: "/reg-suggestions?ajax",
                success: function(data) {
                    $('.generate-stuff').html(data);
                    give_logins_passs();
                }
            });
        }
        return false;
    });

    give_logins_passs();


});


