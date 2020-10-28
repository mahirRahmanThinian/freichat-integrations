<?php
/**
 * Module module default template
 * @package Module Module for Joomla! 3.X
 * @version 1.0.3
 * @author Codologic
 * @license  GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright Codologic 2010-2019
 * @since 2019
 */

// No direct access
defined('_JEXEC') or die; ?>
<?php

$user = JFactory::getUser();        // Get the user object

if ($user->id != 0 && strpos($token, "$$") !== FALSE) {
    $document = JFactory::getDocument();

    $id = $user->id;
    $name = base64_encode($user->name);
    $hash = md5(strtolower(trim($user->email)));
    $avatar = base64_encode("https://www.gravatar.com/avatar/$hash");
    $pubKey = explode("$$", $token)[0];
    $change = date('Ymd');

    $document->addScriptDeclaration("
   import('{$freiChatBaseURL}/v1/freichat-float.js?pubKey=$pubKey&userId=$id&displayName=$name&displayImage=$avatar&change=$change');
");

}
