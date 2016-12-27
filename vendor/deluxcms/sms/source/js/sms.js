$(function(){
    $('.send-code').click(function(){
        var _this = this;
        var device = $("#device").val();
        var helpBlock = $(this).parent().parent().find(".help-block");
        helpBlock.parent().removeClass('has-error');
        if (device == "") {
            var deviceHelpBlock = $("#device").parent().find(".help-block");
            deviceHelpBlock.html("请填写接收验证码的方式");
            deviceHelpBlock.parent().addClass('has-error');
            return false;
        }
        $(_this).attr('disabled', true);
        $(_this).html('发送中..');
        $.ajax({
            type : 'post',
            'url' : vcodeUrl,
            data : {device : device},
            dataType : 'json',
            success : function (data) {
                if (data.status == 1) {
                    _this.setTime = 60;
                    $(_this).attr('disabled', true);
                    _this.st = setInterval(function ()
                                {
                                    _this.setTime--;
                                    if (_this.setTime > 0) {
                                        $(_this).html(_this.setTime + '秒重新发送');
                                    } else {
                                        clearInterval(_this.st);
                                        $(_this).attr('disabled', false);
                                        $(_this).html('点击发送');
                                    }
                                }, 1000);
                } else {
                    $(_this).attr('disabled', false);
                    $(_this).html('点击发送');
                    helpBlock.parent().addClass('has-error');
                    helpBlock.html(data.message);
                }
            },
            error : function (e) {
                $(_this).attr('disabled', false);
                $(_this).html('点击发送');
                console.log(e);
            }
        });
    });
})
