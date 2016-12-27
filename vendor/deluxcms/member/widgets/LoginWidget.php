<?php

namespace deluxcms\member\widgets;

use Yii;
use deluxcms\member\models\LoginForm;
use yii\base\Widget;

class LoginWidget extends Widget
{
    public $model;
    public $action = ['/member/login'];
    public $captchAction = '/member/captcha';
    public $loginAjax = false;

    public $authClient = false;
    public $authUrl = ['/member/auth'];
    public $popupMode = false;
    public $authClientOptions = [
        'class' => 'auth-clients',
    ];

    public function init()
    {
        parent::init();
        if ($this->model === null) {
            $this->model = new LoginForm();
        }
    }

    public function run()
    {
        if ($this->loginAjax) {
            $this->registerAjaxLoginJs();
        }
        return $this->renderFile('@vendor/deluxcms/member/widgets/views/login.php', [
            'model' => $this->model,
            'action' => $this->action,
            'captchAction' => $this->captchAction,
            'authClient' => $this->authClient,
            'authUrl' => $this->authUrl,
            'popupMode' => $this->popupMode,
            'authClientOptions' => $this->authClientOptions,
            'loginAjax' => $this->loginAjax,
        ]);
    }

    public function registerAjaxLoginJs()
    {
         $js = <<<JS
            var isSubming = false;
            $('form#{$this->model->formName()}').on('beforeSubmit', function(e) {
               if (isSubming) return false;
               isSubming = true;
               var form = $(this);
               var formData = form.serialize();
               $.ajax({
                        url: form.attr('action'),
                        type: 'post',
                        data: formData,
                        dataType : 'json',
                        success: function (data) {
                            if (data.length == 0) {
                                isGuest = 0;
                                $("#loginModal").modal("hide");
                            } else {
                                for (id in data) {
                                   var parentNode = $("#" + id).parent().addClass('has-error');
                                   parentNode.find(".help-block").html(data[id][0]);
                                }

                                $("#loginform-verifycode-image").click();
                            }
                            isSubming = false;
                        }
              });
            }).on('submit', function(e){
                 e.preventDefault();
            });
JS;

        Yii::$app->view->registerJs($js);
    }
}