//提交评论
$("#comment").click(function(){
     if (isGuest == 1) {
        $('#loginModal').modal('show');
        //alertMsg("请先登录");
     } else {
        var form = $('form#comment-form');
        $.ajax({
            type : 'post',
            url : form.attr('action'),
            data : form.serialize(),
            dataType : 'json',
            success : function (data) {
                   if (data.status == true) {
                       $("#comment-content").val('');
                       $("input[name=verifyCode]").val('');
                       $('#re-title').hide();
                       $('#parentId').val('');
                       $.pjax.reload({container:"#comment-list"});
                       alertMsg("发表评论成功");
                   } else {
                       alertMsg(data.message);
                   }
                   $("input[name=verifyCode]").parent().find("img").click();
            }
        });
     }
});