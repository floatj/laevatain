<?php
namespace App\Lib;

use App\Api\Telegram as TelegramApi;


//@todo 思考一下這些到底該放哪邊??? controller???
/* 一些輔助用的 Lib */
class TelegramLib
{

    /**
     * 取得最新一筆的 offset
     */
    public function getLatestOffset($ret)
    {
        //若 api 有回傳結果，且 result 不為空，則取最後一筆 result 的 update_id
        return ($ret['ok'] == true AND empty($ret['result'])) ? 0 : end($ret['result'])['update_id'];
    }

    /**
     * 處理 Updates 分割為單一訊息，並將每一則訊息傳入 processSingleMsg 作處理
     * @param $updates  API 回傳的 updates 陣列
     */
    function processUpdates($updates)
    {


        echo "\n\n\033[1;33m收到的 Updates 數量共有 ".count($updates)." 則，逐一處理: \033[m\n";

        foreach($updates as $msg)
        {

            //處理每一則訊息
            $this->processSingleMsg($msg);
        }

        echo "\n\033[1;33m所有 Updates 處理完成 \033[m\n\n";
    }

    /**
     * 處理單一訊息
     *
     * @param $msg
     */
    function processSingleMsg($msg)
    {

        echo "\n\033[1;30m處理單一訊息:\033[m\n";
        echo "-------------------------------\n";
        echo "update id = " . $msg['update_id'] . "\n";
        echo "user_id   = " . $msg['message']['chat']['id'] . "\n";
	echo "username  = " . $msg['message']['chat']['username'] . "\n";
	//防止沒有文字的狀況
	if(!empty($msg['message']['text']))
	    echo "msg       = " . $msg['message']['text'] . "\n";
	else
            $msg['message']['text'] = "(null)";
        echo "-------------------------------\n";

        //處理這則訊息 (回應使用者, 不回應使用者... or 其他可指定的動作)
        $this->engageSingleMsg($msg['message']['chat']['id'], $msg['message']['text']);

    }

    /**
     * 處理單一訊息 bot 行為
     * @param $user_id  發送訊息的使用者 id
     * @param $text     發送訊息的內容
     */
    function engageSingleMsg($user_id, $text)
    {
        //(debug) 測試用 -- 延遲一秒
        //sleep(1);

        //@todo 加入更多可選擇的處理動作
        $this->echoSingleMsg($user_id, $text, "你好，你剛剛說的話是: ");
    }

    /**
     * 回應使用者訊息
     * @param $user_id
     * @param $text
     */
    function echoSingleMsg($user_id, $text, $prefix="")
    {

        //@todo 這邊設計顯然有問題，classes -> lib -> api ???
        //@todo 需要 refactor 並思考放置位置

        $tg = new TelegramApi();
        $ret = $tg->sendMsg($user_id, $prefix . $text);

        //API 回傳值是 json，需要 decode 再使用，否則會出現錯誤
        $ret = json_decode($ret,true);

        if ($ret['ok'] == true) {
            echo "發送訊息成功\n";
            //print_r($ret);
        } else {
            echo "\033[1;31m發送訊息失敗，請檢查設定檔或網路狀況\033[m\n";
        }
    }


}
