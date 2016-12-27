$(document).ready(function() {

    $('.sortable').sortable({
        connectWith: '.sortable',
        tolerance: 'intersect',
        delay: 250,
        stop: function(event, ui) {
            $('.menu-link-alert').hide().filter('.alert-primary').show();
            menuLinkOrderItems = new Array();

            $(".menu-itemes .sortable-item-content").each(function(index, element) {
                $(element).find('.order').text(index);
                var linkId = $(this).data('linkid');
                var parentId = $(this).parent().parent().data('parentid');
                
                menuLinkOrderItems.push([linkId, index, parentId]);
            });

            $.ajax({
                type: "POST",
                url: saveOrdersUrl,
                data: {settings: menuLinkOrderItems},
                success: function(data){
                    $('.menu-link-alert').hide().filter('.alert-info').show();
                    setTimeout(function(){
                        $('.menu-link-alert').hide();
                    }, 1500);
                },
                error: function(data){
                    $('.menu-link-alert').hide().filter('.alert-danger').show();
                    setTimeout(function(){
                        $('.menu-link-alert').hide();
                    }, 1500);
                },
            });
        },
    });

});