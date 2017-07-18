<?php

namespace App\Classes;
/**
 * LongPolling Worker
 */

use App\Api\Telegram as TelegramApi;


Class PollingWorker
{

    protected $timeout = 120;   //LongPolling 的 Timeout，目前設超過 50 秒似乎對 Telegram 官方 API 沒生效
    public $_api;               //API物件
    public $offset;             //要回傳給 GetUpdates Api 的 Offset

    function __construct()
    {
        $this->_api = new TelegramApi();
        $this->offset = 0;

        echo "- telegram api 初始化完成\n";
    }

    /**
     * 開始 long polling
     */
    function run()
    {
        //使用 long polling
        while(true) {

            //如果有回傳新的 offset 就把回傳的新的 offset 帶入參數
            //echo "new_offset = ".$new_offset."\n";
            //echo (!empty($new_offset) AND $new_offset != 0 )."\n";
            echo "\n\033[1;30m[" . date('H:i:s') . "]\033[m 送出 getUpdates API Request (long polling mode) ...\n";

            $ret = $this->_api->getUpdates($this->timeout, (!empty($new_offset) AND $new_offset != 0) ? $new_offset + 1 : $this->offset);
            $new_offset = $this->handleRet($ret);
        }

    }

    /**
     * 處理 Updates (PollingWorker 物件版本)
     *
     * @param $ret getUpdates API 回傳結果 (一大串 updates)
     * @return int $last_update_id 或 0
     */
    function handleRet($ret){

        echo "觸發 handle Ret!!\n";
        var_dump($ret);
        
        //@todo 把 lib/lib.php 內的 function refactor 並以適當方式整合進 laravel
        //$last_update_id = updatesHandler($ret);
        //return $last_update_id;
    }


}