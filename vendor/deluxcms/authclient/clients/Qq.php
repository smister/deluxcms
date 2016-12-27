<?php

namespace deluxcms\authclient\clients;

use yii\authclient\OAuth2;

class Qq extends OAuth2
{
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';

    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';

    public $apiBaseUrl = 'https://graph.qq.com';

    public function initUserAttributes()
    {
        //Array ( [client_id] => 101196234 [openid] => 1E5463D73D3D9FA1D3BB34F1C4D14B31 )
        $retData = $this->api('oauth2.0/me', 'GET');
        //Array ( [ret] => 0 [msg] => [is_lost] => 0 [nickname] => 林少. [gender] => 男 [province] => 广东 [city] => 汕尾
        // [year] => 1990 [figureurl] => http://qzapp.qlogo.cn/qzapp/101196234/1E5463D73D3D9FA1D3BB34F1C4D14B31/30
        // [figureurl_1] => http://qzapp.qlogo.cn/qzapp/101196234/1E5463D73D3D9FA1D3BB34F1C4D14B31/50
        // [figureurl_2] => http://qzapp.qlogo.cn/qzapp/101196234/1E5463D73D3D9FA1D3BB34F1C4D14B31/100
        // [figureurl_qq_1] => http://q.qlogo.cn/qqapp/101196234/1E5463D73D3D9FA1D3BB34F1C4D14B31/40
        // [figureurl_qq_2] => http://q.qlogo.cn/qqapp/101196234/1E5463D73D3D9FA1D3BB34F1C4D14B31/100
        // [is_yellow_vip] => 0 [vip] => 0 [yellow_vip_level] => 0 [level] => 0 [is_yellow_year_vip] => 0 )
        $data = $this->api('user/get_user_info', 'GET', [
            'oauth_consumer_key' => $retData['client_id'],
            'openid' => $retData['openid'],
        ]);
        $data['id'] = $retData['openid'];

        return $data;
    }

    public function defaultName()
    {
        return 'qq';
    }

    public function defaultTitle()
    {
        return '';
    }

    protected function sendRequest($request)
    {
        $response = $request->send();

        if (!$response->getIsOk()) {
            throw new InvalidResponseException($response, 'Request failed with code: ' . $response->getStatusCode() . ', message: ' . $response->getContent());
        }

        //这里需要处理一下QQ特殊数据
        $content = $response->getContent();
        if (strpos($content, 'callback') !== false) {
            $lpos = strpos($content, '(');
            $rpos = strrpos($content, ')');

            $content = substr($content, $lpos + 1, $rpos - $lpos -1);

            $response->setContent($content);
            $response->setFormat(\yii\httpclient\Client::FORMAT_JSON);
        }
        return $response->getData();
    }

    public function getOpenId()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['id'];
    }

    public function getUsername()
    {
        return $this->getOpenId();
    }

    public function getNickname()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['nickname'];
    }

    public function getGender()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['gender'] == '男' ? 1 : 0;
    }

    public function getAddress()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['province'] . ' ' . $userAttributes['city'];
    }

    public function getAvatar()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['figureurl_qq_2'];
    }
}