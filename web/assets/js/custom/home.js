$(document).ready(function () {
    var ias = jQuery.ias({
        container: '#timeline .box-content',
        item: '.publication-item',
        pagination: '#timeline .pagination',
        next: '#timeline .pagination .next_link',
        triggerPageThreshold: 5
    });

    ias.extension(new IASTriggerExtension({
        text: 'Ver mas publicaciones',
        offset: 3
    }));

    ias.extension(new IASSpinnerExtension({
        src: '/../assets/images/ajax-loader.gif'
    }));

    ias.extension(new IASNoneLeftExtension({
        text: 'No hay mas publicationes'
    }));

    ias.on('ready', function (event) {
       buttons();
    });

    ias.on('rendered', function (event) {
        buttons();
    });
});

function buttons()
{
    $('[data-toggle="tooltip"]').tooltip();

    $(".btn-img").unbind("click").click(function () {
       $(this).parent().find('.pub-image').fadeToggle();
    });
    
    $(".btn-delete-pub").unbind('click').click(function () {
       $(this).parent().parent().addClass('hidden');
       
       $.ajax({
          url: '/publication/remove/'+$(this).attr("data-id"),
          type: 'GET',
           success: function (response) {
               console.log(response);
           }
       });
    });

    $(".btn-like").unbind('click').click(function () {
        $(this).addClass("hidden");
        $(this).parent().find('.btn-unlike').removeClass("hidden");
       $.ajax({
       url: '/like/'+$(this).attr("data-id"),
       type: 'GET',
       success: function (response) {
             console.log(response);
         }
       });
    });

    $(".btn-unlike").unbind('click').click(function () {
        $(this).addClass("hidden");
        $(this).parent().find('.btn-like').removeClass("hidden");
        $.ajax({
            url: '/unlike/'+$(this).attr("data-id"),
            type: 'GET',
            success: function (response) {
                console.log(response);
            }
        });
    });
}