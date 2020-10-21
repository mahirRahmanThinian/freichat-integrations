<?php

$name = base64_encode($name);
$avatar = base64_encode($avatar);
$pubKey = explode("$$", $token)[0];
$change = date('Ymd');
$friendIdsEncoded = json_encode($friendIds);

echo <<<EOL
<script type="text/javascript">
    import('{$baseUrl}/v1/freichat-float.js?pubKey=$pubKey&userId=$id&displayName=$name&displayImage=$avatar&change=$change');
EOL;

if ($friendIds !== null) {
    echo <<<EOL
    FreiChatClient = {
        friendIds: `$friendIdsEncoded`
    }
EOL;
}


echo "</script>"

?>