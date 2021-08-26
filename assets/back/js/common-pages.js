"use strict";
$(document).ready(function() {
    var url = $("#base_url").val();
	var input = $("form").first().find(':input').first().attr('class');
  	$("."+input).first().focus();
    // $('.theme-loader').addClass('loaded');
    /*$('.theme-loader').animate({
        'opacity': '0',
    }, 1200);*/
    setTimeout(function() {
        $('.theme-loader').fadeOut();
    }, 1000);
    // $('.pcoded').addClass('loaded');

    $('form').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: $( this ).attr('action'),
            type: 'post',
            data: $( this ).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
            },
            success: function(result) {
                $("."+input).first().focus();
                notify(`${(result.status) ? "Success" : "Error"} : `, result.message, result.status ? "success" : "danger");
                if (result.redirect) {
                    setTimeout(function() {
                        window.location.href = result.redirect;
                    }, 1000);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("."+input).first().focus();
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    });
});