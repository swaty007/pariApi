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


    public function createRegister($ref, $number, $password)
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
            "loginName" =>  substr($number,3), // поле ввода (для теста используй номера 001212111-001212999)
            "mobile" =>  $number, // поле ввода
            "password" =>  $password, // автосгенерированный пароль - по типу 6 символов из которых    минимум одна цифра
            "receiveEmail" =>  $number, // поле ввода
            "receiveSms" =>  $number, // поле ввода
            "verificationType" =>  1
        );

        return $this->apiCall('https://parimatch.co.tz/rest/customer/account/register', $data);
    }

    public function checkCode ($code, $user_id, $password) {
        $data = array(
            "activationCode" => $code, //код из смс(когда будешь на этом этапе, спросишь у меня)
            "activationType" => "account-and-sms",
            "customerId" => $user_id //переменная из ответа прошлого запроса
        );
//        "code": 200,
//    "description": "OK.",
//    "data": true


//        "code": 457,
//    "description": "Activation not succeeded"


        return $this->apiCall('https://parimatch.co.tz/rest/customer/account/activate-account', $data);
    }
    public function login ($number, $password) {

        $data = array(
            "login" => substr($number,3), // то что было в поле ввода при первой итерации
            "password" => $password, //автосгенерированный пароль при первой итерации
        );

        $data = array(
            'login' => 127746355,
            'password' => 'Pm12345'
        );
        $res = $this->apiCall('https://parimatch.co.tz/rest/customer/session/login', $data);
        if ($res['code'] == 200) {
            $sms = $this->sendSms($number, $password);
            return $res;
        } else {
            return $res;
        }
//        string(75) "{"code":500,"description":"Thrown in Betting Api || Thrown in Betting Api"}" array(2) { ["code"]=> int(500) ["description"]=> string(46) "Thrown in Betting Api || Thrown in Betting Api" }
//        string(858) "{"code":200,"description":"OK.","data":{"auth":"4xQyd1H54FU4Pme243anY2IvisLK8kw","language":"EN ","logged":true,"userId":189438,"login":"123223121","sessionIP":null,"lastBalanceCheck":1574710577789,"lastBonusBalanceCheck":1574710577836,"firstName":"null","lastName":"null","email":"","balance":0.0,"bonusBalance":null,"currencyCode":"TZS","pinCode":"null","sessionStart":1574710577789,"bonusBalanceList":[],"mobile":"255123223121","countryCode":"TZ","bankId":null,"brandId":1,"accountStatus":null,"notifications":[{"taskId":620723,"objectId":189438,"customerId":189438,"type":10,"status":0,"subject":"Today registered","message":"{\"type\":41,\"registration\":true,\"postBackNotify\":\"registration\"}","regDate":1574260757824,"modDate":1574260757824,"expDate":2709556757824}],"userIdHash":"ff4a5587dbc83105678b88bd5e8acf009b30f2bb511e0276d33b69e3d3073abf"}}" array(3) { ["code"]=> int(200) ["description"]=> string(3) "OK." ["data"]=> array(24) { ["auth"]=> string(31) "4xQyd1H54FU4Pme243anY2IvisLK8kw" ["language"]=> string(3) "EN " ["logged"]=> bool(true) ["userId"]=> int(189438) ["login"]=> string(9) "123223121" ["sessionIP"]=> NULL ["lastBalanceCheck"]=> int(1574710577789) ["lastBonusBalanceCheck"]=> int(1574710577836) ["firstName"]=> string(4) "null" ["lastName"]=> string(4) "null" ["email"]=> string(0) "" ["balance"]=> float(0) ["bonusBalance"]=> NULL ["currencyCode"]=> string(3) "TZS" ["pinCode"]=> string(4) "null" ["sessionStart"]=> int(1574710577789) ["bonusBalanceList"]=> array(0) { } ["mobile"]=> string(12) "255123223121" ["countryCode"]=> string(2) "TZ" ["bankId"]=> NULL ["brandId"]=> int(1) ["accountStatus"]=> NULL ["notifications"]=> array(1) { [0]=> array(10) { ["taskId"]=> int(620723) ["objectId"]=> int(189438) ["customerId"]=> int(189438) ["type"]=> int(10) ["status"]=> int(0) ["subject"]=> string(16) "Today registered" ["message"]=> string(63) "{"type":41,"registration":true,"postBackNotify":"registration"}" ["regDate"]=> int(1574260757824) ["modDate"]=> int(1574260757824) ["expDate"]=> int(2709556757824) } } ["userIdHash"]=> string(64) "ff4a5587dbc83105678b88bd5e8acf009b30f2bb511e0276d33b69e3d3073abf" } }


    }
    private function sendSms ($number, $password) {
        $username_api = Yii::$app->params['usernameApi'];
        $pass_api = Yii::$app->params['passApi'];
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
            curl_setopt($this->ch, CURLOPT_HEADER, true);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($post_data));

        $data = curl_exec($this->ch);
        $header_size = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);
        $header = substr($data, 0, $header_size);
        $data = substr($data, $header_size);

        if ($data !== false) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with
                // Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, true);
            }
            if ($dec !== null && count($dec)) {
                $dec['headers'] = $header;
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
