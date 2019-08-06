<?php

namespace com\codologic\codoforum\plugins;

/*
 * @CODOLICENSE
 */

/**
 *
 * There is no restriction whether to use OOP or procedural
 *
 * preferred pattern
 * assets/ your static resources
 *         js/  your javascript
 *         css/ your css files
 *         img/ your images
 *         tpl/ your .tpl files
 *
 * you are free to follow your own style.
 */
/**
 * All files should include below defined or die line
 *
 */
defined('IN_CODOF') or die();


//dispatch('abc', function() {echo "hi";});

/**
 * you can define your own routes using dispatch_t(get/post)
 * wildcards can be used
 * files must end with .tpl and no php is allowed inside template files
 * not even using the smarty php tags by default
 * to use any variables use the smarty assign function
 *
 * All .tpl files in a plugin must follow the below layout
 *
 * {* Smarty *}
 * {extends file='layout.tpl'}
 *
 * {block name=body}
 *
 *  YOUR PLUGIN HTML
 * {/block}
 *
 * if you want to remove the header and footer comment the {extends... } line
 *
 *
 * How to load your template file ?
 *
 * You can load your smarty tpl file for eg. my_blog.tpl using
 * \CODOF\Plugin::tpl('my_blog')
 * do not include .tpl at the end
 *
 */


use CODOF\Asset\Stream;
use CODOF\Hook;
use CODOF\Plugin;
use CODOF\Smarty\Single;
use CODOF\Store;
use CODOF\User\CurrentUser\CurrentUser;
use CODOF\User\User;
use CODOF\Util;

Util::get_config(\DB::getPDO());

function getFreichatBaseUrl()
{
    if (MODE === \Constants::MODE_PRODUCTION) {
        return "https://nodelb.freichat.com/api";
    } else {
        return "//${_SERVER['HTTP_HOST']}:8080/api";
    }
}

/**
 * @param $userId
 */
function generateFreiChat($userId)
{
    $user = (User::get($userId));
    $id = $user->id;
    $name = base64_encode($user->name);
    $avatar = base64_encode($user->getAvatar());


    $changeable = date('Ymd');

    $floatChatEnabled = true;
    $freiChatBaseURL = getFreichatBaseUrl();
    $key = Util::get_opt('FREICHAT_APP_KEY');
    $publicKey = explode("$$", $key)[0];

    $js = "
        import('{$freiChatBaseURL}/v1/freichat-dock.js?pubKey=$publicKey&userId=$id&displayName=$name&displayImage=$avatar&change=$changeable')";

    if ($floatChatEnabled) {
        $js .= "\n 
                 import('{$freiChatBaseURL}/v1/freichat-float.js?pubKey=$publicKey&userId=$id&displayName=$name&displayImage=$avatar&change=$changeable');
         \n";
    }
    add_js("freichat_plugin", array(
        'data' => $js,
        'type' => 'inline_module'
    ));
    Store::set('client_loaded', true);

    add_css("{$freiChatBaseURL}/static/v1/freichat-dock.bundle.css?change=$changeable", array(
        'name' => 'freichat_css',
        'type' => 'remote'
    ));

    \CODOF\Store::set('sub_title', _t("Private Messenger"));
    \CODOF\Smarty\Layout::load('FreiChat:FreiChat');
}



dispatch("messenger/", function () {
    $userId = \CODOF\User\CurrentUser\CurrentUser::id();
    if (CurrentUser::loggedIn()) {
        generateFreiChat($userId);
    } else {
        header('Location: ' . RURI);
    }
});

Hook::add('before_site_head', function () {

    if (CurrentUser::loggedIn()) {
        $translations = \CODOF\Store::get('translations', array());
        $translations["pmx_title"] = _t('Private Messenger');
        \CODOF\Store::set('translations', $translations);
        add_js(PLUGIN_PATH . 'FreiChat/assets/js/pm.js', array('type' => 'defer'));
    }
});

Hook::add('tpl_before_user_profile_view', function () {

    $asset = new Stream();
    $headCollection = new \CODOF\Asset\Collection('head_col');
    $headCollection->addCSS(PLUGIN_PATH . 'FreiChat/assets/css/pm.css');
    $asset->addCollection($headCollection);

    $message = _t("Message");
    $uid = Store::get('profile_uid');
    if (CurrentUser::loggedIn() && Store::get('profile_uid') != CurrentUser::id()) {
        $content = <<<EOD
        <div data-uid="$uid" class="freichat_send_pm_box codo_btn codo_btn_primary">
            <i class="fa fa-envelope-o"></i> $message
        </div>
EOD;

        Plugin::storeContent('block_profile_user_statistics_after', $content);
    }
});

require_once "FreiChatClientAPI.php";