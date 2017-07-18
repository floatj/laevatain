<?php

namespace App\Classes;
/**
 * Created by PhpStorm.
 * User: johnny_liao
 * Date: 2017/7/18
 * Time: 下午2:39
 */

use App\Api\Telegram as Telegram;

Class PollingWorker
{

    function __construct()
    {
        //...
    }

    function run()
    {
        echo "Polling worker class\n";

        //引用 Telegram Api
        //$tg = new \App\Api\TelegramApi();

        //echo "tg 物件 ok\n";
    }


}