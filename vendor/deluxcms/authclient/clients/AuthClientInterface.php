<?php

namespace deluxcms\authclient\clients;

interface AuthClientInterface
{
    public function getOpenId();
    public function getUsername();
    public function getNickname();
    public function getGender();
    public function getAddress();
    public function getAvatar();
}