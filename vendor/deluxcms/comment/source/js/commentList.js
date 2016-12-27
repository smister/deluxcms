$(function(){
    //回复按钮
    $(".recomment-user").click(function(){
        $("#comment-recomment").val($(this).attr('data'));
        $("#recomment-user").html('@' + $(this).parent().parent().parent().find(".media-heading").html());
        $('#re-title').show();
    });

    $("#remove-recomment").click(function(){
        $('#re-title').hide();
        $('#comment-recomment').val('');
    });

})
