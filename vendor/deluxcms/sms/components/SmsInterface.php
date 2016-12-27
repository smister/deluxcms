<?php

namespace deluxcms\sms\components;

interface SmsInterface
{
    public static function send($deviceNum, $code, $data = []);
}