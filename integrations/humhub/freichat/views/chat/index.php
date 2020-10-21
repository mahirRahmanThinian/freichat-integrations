<?php

use yii\helpers\Url;

$name = base64_encode($name);
$avatar = base64_encode($avatar);
$pubKey = explode("$$", $token)[0];
$change = date('Ymd');
$friendIdsEncoded = json_encode($friendIds);

$url = Yii::$app->request->getHostInfo() . \yii\helpers\Url::toRoute("search/users");


echo <<<EOL

<style type="text/css">
iframe{
    background-color: transparent;
    border: 0px none transparent;
    padding: 0px;
    overflow: hidden;
    width: 100%;
    height: calc(100vh - 120px);

}
</style>
<iframe id="freichat-frame" src="http://codologic.com/chat/?pubKey=$pubKey&userId=$id&displayName=$name&displayImage=$avatar&change=$change"/>



EOL;
?>