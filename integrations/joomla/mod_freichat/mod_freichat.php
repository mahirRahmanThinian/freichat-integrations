<?php

/**
 * Module module entry point
 * @package Module Module for Joomla! 3.X
 * @version 1.0.3
 * @author Codologic
 * @license  GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright Codologic 2010-2019
 * @since 2019
 */

// No direct access
defined('_JEXEC') or die;

require_once 'config.php';

$freiChatBaseURL = API_BASE_PATH;
$token = $params->get('token');
require JModuleHelper::getLayoutPath('mod_freichat');