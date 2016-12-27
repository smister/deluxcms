<?php

namespace deluxcms\authclient\clients;

use yii\authclient\OAuth2;

class Weibo extends OAuth2 implements AuthClientInterface
{
    public $authUrl = 'https://api.weibo.com/oauth2/authorize';

    public $tokenUrl = 'https://api.weibo.com/oauth2/access_token';

    public $apiBaseUrl = 'https://api.weibo.com';

    public function initUserAttributes()
    {
        //Array ( [uid] => 2034704230 [appkey] => 3522944249 [scope] => [create_at] => 1480521225 [expire_in] => 157679999 )
        $retData = $this->api('oauth2/get_token_info', 'POST');
        //Array ( [id] => 2034704230 [idstr] => 2034704230 [class] => 1 [screen_name] => S_林少 [name] => S_林少
        // [province] => 44 [city] => 3 [location] => 广东 深圳 [description] => smister , 为技术而生
        // [url] => http://www.mrs.pw
        // [profile_image_url] => http://tva4.sinaimg.cn/crop.0.0.180.180.50/79471f66jw1e8qgp5bmzyj2050050aa8.jpg
        // [profile_url] => u/2034704230 [domain] => [weihao] => [gender] => m [followers_count] => 59
        // [friends_count] => 73 [pagefriends_count] => 0 [statuses_count] => 24 [favourites_count] => 12
        //[ptype] => 0 [allow_all_comment] => 1
        // [avatar_large] => http://tva4.sinaimg.cn/crop.0.0.180.180.180/79471f66jw1e8qgp5bmzyj2050050aa8.jpg
        // [avatar_hd] => http://tva4.sinaimg.cn/crop.0.0.180.180.1024/79471f66jw1e8qgp5bmzyj2050050aa8.jpg
        // [verified_reason] => [verified_trade] => [verified_reason_url] => [verified_source] => [verified_source_url]
        // => [follow_me] => [online_status] => 0 [bi_followers_count] => 19 [lang] => zh-cn [star] => 0 [mbtype] => 0
        // [mbrank] => 0 [block_word] => 0 [block_app] => 0 [credit_score] => 80 [user_ability] => 0 [urank] => 21 )
        return $this->api('2/users/show.json', 'GET', ['uid' => $retData['uid']]);
    }

    public function defaultName()
    {
        return 'weibo';
    }

    public function defaultTitle()
    {
        return '';
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
        return $userAttributes['name'];
    }

    public function getGender()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['gender'] == 'm' ? 1 : 0;
    }

    public function getAddress()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['location'];
    }

    public function getAvatar()
    {
        $userAttributes = $this->getUserAttributes();
        return $userAttributes['avatar_hd'];
    }
}