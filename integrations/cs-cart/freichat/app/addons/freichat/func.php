<?php
/*
* © 2020 Codologic
* 
* Licensed under MIT
* @website: https://codologic.com
*  
*/

if (!defined('BOOTSTRAP')) {
    die('Access denied');
}

use Tygh\Settings;

function fn_install_freichat()
{
    $existingToken = Settings::instance()->getValue('token', 'freichat');
    if ($existingToken == null || $existingToken == "") {
        $tokenGenerator = new FreiChatTokenGenerator();
        $tokenGenerator->install();
    }
}

function fn_freichat_token_notice_handler()
{
    return __('recaptcha.freichat_token_notice');
}

class FreiChatTokenGenerator
{

    function install()
    {
        $data = $this->generateToken();
        if ($data['error'] == null) {
            Settings::instance()->updateValue('token', $data['key'], 'freichat');
        }
    }

    private function generateToken()
    {
        $data = [
            'domain' => $_SERVER['HTTP_HOST'],
            'platform' => 'CS-Cart'
        ];

        $payload = json_encode($data);
        $freiChatBaseURL = "https://nodelb.freichat.com/api";

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

