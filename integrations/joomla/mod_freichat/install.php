<?php
/**
 * Module module installation script
 * @package Module Module for Joomla! 3.X
 * @version 1.0.0
 * @author Codologic
 * @license  GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @copyright Codologic 2010-2019
 * @since 2019
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Script file of HelloWorld module
 */
class mod_freichatInstallerScript
{
    /**
     * Method to install the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    function install($parent)
    {
        $data = $this->generateToken();
        $table = JTable::getInstance('module');
        $table->load(array("module" => "mod_freichat"));
        $modParams = json_decode($table->params, true);

        if ($data['error'] == null) {
            $modParams['token'] = $data['key'];
        } else {
            $modParams['error'] = $data['error'];
        }

        $table->bind(array("params" => $modParams));
        $table->store();
    }

    /**
     * Method to uninstall the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    function uninstall($parent)
    {
    }

    /**
     * Method to update the extension
     * $parent is the class calling this method
     *
     * @return void
     */
    function update($parent)
    {
    }

    /**
     * Method to run before an install/update/uninstall method
     * $parent is the class calling this method
     * $type is the type of change (install, update or discover_install)
     *
     * @return void
     */
    function preflight($type, $parent)
    {
    }

    /**
     * Method to run after an install/update/uninstall method
     * $parent is the class calling this method
     * $type is the type of change (install, update or discover_install)
     *
     * @return void
     */
    function postflight($type, $parent)
    {
    }

    /**
     * Generates a token for secure communication
     * If there is some error during token generation, that error is saved in module params in db
     * @return array
     *
     * @since version
     */
    private function generateToken()
    {
        $data = array(
            'domain' => $_SERVER['HTTP_HOST'],
            'platform' => 'Joomla'
        );

        $payload = json_encode($data);

        require_once 'config.php';

        $freiChatBaseURL = API_BASE_PATH;

        try {
            $ch = curl_init("$freiChatBaseURL/v1/keys/free/register");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($payload))
            );

            // Submit the POST request
            $key = curl_exec($ch);
        } catch (Exception $e) {
            return array("key" => null, "error" => $e->getMessage());
        }

        return array("key" => $key, "error" => null);
    }
}