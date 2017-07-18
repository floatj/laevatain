<?php
namespace App\Api;

class Telegram{

    protected $bot_token;
    protected $bot_url;

    function __construct()
    {
        //讀取設定
        $config = config('api.telegram');

        $this->bot_token = $config['token'];
        $this->bot_url = $config['url'];

        if (empty($this->bot_token) OR empty($this->bot_url)) {
            //設定檔錯誤
            $err_msg = "ERROR: 設定檔有誤，請重新檢查！\n";
            die($err_msg);
        }

        //依 bot 基本設定資料去建構 curl query 的 url
        $this->bot_url = $this->bot_url.$this->bot_token."/";

    }

    //測試印出設定
    function dump_config()
    {
        echo "config dump:\n";
        var_dump($this->bot_token);
        var_dump($this->bot_url);
    }

    function sendMsg($chat_id, $msg)
    {

        //---send msg
        $url        = $this->bot_url . "sendMessage?chat_id=" . $chat_id ;

        $post_fields = array(
            'chat_id'   => $chat_id,
            'text'      => $msg
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        //echo "sending message $chat_id , please wait...";

        //debug: 計算執行時間
        $time_start = microtime(true);

        $output = curl_exec($ch);

        //debug: 計算執行時間
        $exec_time = microtime(true) - $time_start;

        //echo "\n執行時間：$exec_time\n";
        return $output;
    }

    function getUpdates($timeout = 60, $offset = 0)
    {
        //if($offset != 0) echo "offset 不為 0 !! -> $offset\n";
        //echo "timeout = $timeout\n";

        //收訊息
        $url        = $this->bot_url . "getUpdates".( intval($timeout)>0 ? "?timeout=".intval($timeout) : "").($offset>0 ? "&offset=".$offset : "");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT,  $timeout);

        //debug: 計算執行時間
        $time_start = microtime(true);

        $output = curl_exec($ch);

        //debug: 計算執行時間
        $exec_time = microtime(true) - $time_start;

        //echo "\n執行時間：$exec_time\n";
        return json_decode($output, true);
    }

}
