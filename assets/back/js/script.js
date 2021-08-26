"use strict";
$(document).ready(function() {
    var input = $("form").first().find(':input').first().attr('name');
    $(`input[name='${input}']`).first().focus();
    var elemprimary = document.querySelector('.js-info');
    if (elemprimary !== null)
        var switchery = new Switchery(elemprimary, { color: '#62d1f3', jackColor: '#fff' });

    var $window = $(window);
    //add id to main menu for mobile menu start
    var getBody = $("body");
    var bodyClass = getBody[0].className;
    $(".main-menu").attr('id', bodyClass);
    //add id to main menu for mobile menu end

    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });

    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-maximize");
        $(this).toggleClass("icon-minimize");
    });

    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    // card js end
    $.mCustomScrollbar.defaults.axis = "yx";
    $("#styleSelector .style-cont").slimScroll({
        setTop: "10px",
        height:"calc(100vh - 440px)",
    });
    $(".main-menu").mCustomScrollbar({
        setTop: "10px",
        setHeight: "calc(100% - 80px)",
    });
    /*chatbar js start*/

    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5,
        color: '#1b8bf9'
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });


    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function() {
        $('#mobile-collapse i').toggleClass('icon-toggle-right');
        $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
    
    $('form').submit(function (e){
        e.preventDefault();
        $.ajax({
            url: $( this ).attr('action'),
            type: 'post',
            data: new FormData(this),
            dataType: 'json',
            cache:false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
            },
            success: function(result) {
                $("."+input).first().focus();
                swal({
                    title: result.status ? "Success" : "Error",
                    text: result.message,
                    type: result.status ? "success" : "error",
                    confirmButtonClass: "btn btn-outline-danger",
                    confirmButtonText: "OK"
                },
                function(){
                    if (result.redirect) {
                        window.location.href = result.redirect;
                    }
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("."+input).first().focus();
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    });
});

$(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
    $('.theme-loader').fadeOut('slow');
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;
    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}

var form = '';

function getModalData(anchor)
{
    $.ajax({
        url: anchor.getAttribute( 'data-url' ),
        type: 'GET',
        dataType: 'html',
        beforeSend: function() {
            $('.theme-loader').fadeIn();
        },
        complete: function() {
            $('.theme-loader').fadeOut();
        },
        success: function(result) {
            if (result) {
                $("#common-modal .modal-title").html(anchor.getAttribute( 'data-title' ));
                $("#common-modal .modal-body").html(result);
                form = document.getElementById('common-modal').querySelector( 'form' );
                $("#common-modal").modal({backdrop: 'static', keyboard: false}, "show");
                let select = document.getElementById('common-modal').querySelector( 'select' );
                if (select) {
                    if (select.getAttribute('data-change') == 'true')
                        getSubCats(select);
                    /*$(".select2").select2({
                        placeholder: select.getAttribute('data-placeholder')
                    });*/
                }
            }else{
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            notify("Error : ", "Something is not going good. Try again.", "danger");
        }
    });
}

$(document).on('submit', form, function(e){
    e.preventDefault();
    saveData();
});

function addMenu()
{
    let menu = $("#view-menu").children().length + 1;
    $('#view-menu').append(`<div class="row" id="menu_${menu}"><div class="col-md-5"><div class="form-group"> <input type="text" name="sub_menu[]" class="form-control form-control-round" placeholder="Sub Menu Name"></div></div><div class="col-md-5"><div class="form-group"> <input type="text" name="sub_menu_url[]" class="form-control form-control-round" placeholder="Sub Menu URL"></div></div><div class="col-md-2"><div class="form-group"> <button type="button" class="btn btn-danger btn-outline-danger waves-effect btn-round btn-block float-right" onclick="removeMenu('menu_${menu}')">Remove</button></div></div></div>`);
}

function addFeature()
{
    let menu = $("#view-menu").children().length + 1;
    $('#view-menu').append(`<div class="row" id="batch_fecherd_${menu}"><div class="col-md-10"><div class="form-group"><input type="text" name="batch_fecherd[]" class="form-control form-control-round" placeholder="Feature"></div></div><div class="col-md-2"><div class="form-group"><button type="button" class="btn btn-danger btn-outline-danger waves-effect btn-round btn-block float-right" onclick="removeMenu('batch_fecherd_${menu}')">Remove</button></div></div></div>`);
}

function removeMenu(id)
{
    $("#"+id).remove();
}

function changeStatus(status)
{
    $("#order-status").val(status);
    table.ajax.reload();
}

function bulkUpload(upload)
{
    form = upload;
    saveData();
}

function getSubCats(select)
{
    let id = select.value;
    let dependent = select.dataset.dependent;
    let val = select.dataset.value;
    if (id == "") {
        $("#"+dependent).html('<option selected="" disabled="" >Select Sub Category</option>');
    }else{
        $.ajax({
            url: `${$('#dataTableUrl').val()}/getSubCats/${id}`,
            type: 'GET',
            dataType: 'html',
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
            },
            success: function(result) {
                $("#"+dependent).html(result);
                $('#'+dependent).val(val);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    }
}

function saveData()
{
    if (form){
        $.ajax({
            url: form.getAttribute('action'),
            type: form.getAttribute('method'),
            data: new FormData(form),
            dataType: 'json',
            cache:false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
                if ($("#bulk_upload").length > 0) {$("#bulk_upload").val('')}
            },
            success: function(result) {
                if (result.status) {
                    $("#common-modal .modal-title").html('');
                    $("#common-modal .modal-body").html('');
                    table.ajax.reload();
                    $("#common-modal").modal("hide");
                }
                swal({
                    title: result.status ? "Success" : "Error",
                    text: result.message,
                    type: result.status ? "success" : "error",
                    confirmButtonClass: "btn btn-outline-danger",
                    confirmButtonText: "Yes",
                    closeOnConfirm: true
                },
                function(){
                    if (result.redirect)
                        window.location = result.redirect;
                    else
                        return true;
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    }else{
        $("#common-modal").modal("hide");
    }
}
var script = {
  logout: function() {
    swal({
        title: "Are you sure?",
        text: "Are you sure to logout?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-outline-danger",
        confirmButtonText: "Yes",
        cancelButtonText: 'No',
        closeOnConfirm: false
    },
    function(){
        window.location = $('#logout').attr('href');
    });
  },
  status: function(id) {
    swal({
        title: "Are you sure?",
        text: "Are you sure to change status?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-outline-danger",
        confirmButtonText: "Yes",
        cancelButtonText: 'No',
        closeOnConfirm: false
    },
    function(){
        let form = $("#"+id);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            cache:false,
            async:false,
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
            },
            success: function(result) {
                table.ajax.reload();
                swal(`${(result.status) ? "Success" : "Error"}`, result.message, result.status ? "success" : "error");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    });
  },
  delete: function(id) {
    swal({
        title: "Are you sure?",
        text: "Are you sure remove this item?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn btn-outline-danger",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: 'No',
        closeOnConfirm: false
    },
    function(){
        let form = $("#"+id);
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            cache:false,
            async:false,
            beforeSend: function() {
                $('.theme-loader').fadeIn();
            },
            complete: function() {
                $('.theme-loader').fadeOut();
            },
            success: function(result) {
                table.ajax.reload();
                swal(`${(result.status) ? "Success" : "Error"}`, result.message, result.status ? "success" : "error");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                notify("Error : ", "Something is not going good. Try again.", "danger");
            }
        });
    });
  }
};