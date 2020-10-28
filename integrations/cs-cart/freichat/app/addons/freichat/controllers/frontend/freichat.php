<?php

use Tygh\Registry;
use Tygh\Settings;


if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    return;
}

if (empty($mode)) $mode = "denied";

if ($mode == "get_fc_url") {
    $token = Registry::get('addons.freichat.token');
    $user = $_SESSION['cart']['user_data'];

    $name = "Customer";
    if (!empty($user['firstname'])) {
        $name = $user['firstname'];

        if (!empty($user['lastname'])) {
            $name .= " " . $user['lastname'];
        }
    } else if (!empty($user['user_name'])) {
        $name = $user['user_name'];
    } else {
        $name .= "-" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 4);
    }

    if (empty($user)) {
        echo json_encode([]);
        exit;
    }

    $object_id = $user['user_id'];
    $pair_data = db_get_hash_array(
        'SELECT pair_id, image_id, detailed_id, type, position FROM ?:images_links WHERE object_id = ?i AND object_type = ?s',
        'pair_id', $object_id, 'user_photo'
    );

    foreach ($pair_data as $pair) {
        $image_id = $pair['image_id'];
    }

    $hash = md5(strtolower(trim($user['email'])));
    $avatar = "https://www.gravatar.com/avatar/$hash";
    if (!empty($image_id)) {
        $image_data = fn_get_image($image_id, $object_id, 'user_photo');
        $avatar = $image_data['image_path'];
    }

    $name = base64_encode($name);
    $avatar = base64_encode($avatar);
    $pubKey = explode("$$", $token)[0];
    $change = date('Ymd');

    $url = "https://nodelb.freichat.com/api/v1/freichat-float.js?pubKey=$pubKey&userId=$object_id&displayName=$name&displayImage=$avatar&change=$change";

    echo json_encode(["url" => $url]);
    exit;
}
