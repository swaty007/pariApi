<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PariMatch extends Model
{
    public function  __construct()
    {

    }
    private $ch = null;


    public function createRegister($ref, $number)
    {
        $data = array(
            "affiliateCode" =>  $ref, // parimatch.co.tz/?ref=test, взять с ссылки  на сайте
            "brandCountryCode" =>  null,
            "browser" => "firefox", // авто определения браузера
            "channel" => "mobile", // тип представления лендинга
            "device" => "desktop", // тип устройства
            "countryCode" =>  "TZ", // страна
            "currencyCode" =>  "TZ",
            "languageCode" =>  "EN", // язык
            "loginName" =>  $number, // поле ввода (для теста используй номера 001212111-001212999)
            "mobile" =>  $number, // поле ввода
            "password" =>  "Pm12345", // автосгенерированный пароль - по типу 6 символов из которых    минимум одна цифра
            "receiveEmail" =>  $number, // поле ввода
            "receiveSms" =>  $number, // поле ввода
            "verificationType" =>  "account-and-sms"
        );


        return $this->apiCall('https://parimatch.co.tz/rest/customer/account/register', $data);
    }

    public function checkCode ($code,$user_id) {
        $data = array(
            "activationCode" => $code, //код из смс(когда будешь на этом этапе, спросишь у меня)
            "activationType" => "account-and-sms",
            "customerId" => $user_id //переменная из ответа прошлого запроса
        );

        return $this->apiCall('https://parimatch.co.tz/rest/customer/account/activate-account', $data);
    }
    public function login ($number, $password) {

        $data = array(
            "login" => $number, // то что было в поле ввода при первой итерации
            "password" => $password, //автосгенерированный пароль при первой итерации
        );
        return $this->apiCall('https://parimatch.co.tz/rest/customer/session/login', $data);
        $sms = $this->sendSms($number,"Pm12345");

    }
    private function sendSms ($number, $password) {
        $username_api = 'o.pimonov';
        $pass_api = 'C^+S8rFg:rmFhU@M';
        $headers = array(
            "Content-Type: application/json",
            "Accept: application/json",
            "Authorization: Basic " . base64_encode($username_api . ":" . $pass_api),
            "Host: 6dq4e.api.infobip.com",
        );

        $data = array(
            "from" => "PARIMATCH",
            "to" => $number, // c поля ввода первой итерации
            "text" => "Your password '$password'" //автосгенерированный пароль с первой итерации
        );
        return $this->apiCall('https://6dq4e.api.infobip.com/sms/1/text/single', $data, $headers);
    }

    private function apiCall($url,$post_data = array(), $headers = null)
    {
        if ($headers === null) {
            $headers = array(
                "Content-Type: application/json",
                "Host: parimatch.co.tz",
                "X-BRAND-DATA: 1",
                "X-ODDS-SESSION: X-ODDS-SESSION",
            );
        }

        // Create cURL handle and initialize (if needed)
        if ($this->ch === null) {
            $this->ch = curl_init($url);
            curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($post_data));

        $data = curl_exec($this->ch);
        if ($data !== false) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with
                // Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, true);
            }
            if ($dec !== null && count($dec)) {
                return $dec;
            } else {
                // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
                return array('error' => 'Unable to parse JSON result ('.json_last_error().')');
            }
        } else {
            return array('error' => 'cURL error: '.curl_error($this->ch));
        }
    }




}
