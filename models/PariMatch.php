<?php
namespace app\models;

use Yii;
use yii\base\Model;

class PariMatch extends Model
{
    public function  __construct()
    {
        $this->private_key = Yii::$app->params['coinPaymentsPrivateKey'];
        $this->public_key = Yii::$app->params['coinPaymentsPublicKey'];
    }
    private $private_key;
    private $public_key;
    private $ch = null;


    public function createRegister()
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Accept: */*',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Length: 341',
            'Content-Type: application/json',
            'Cookie: __cfduid=d504aadebe5b2d8d9d767f11e45804d0d1570009306; lsn=bubba',
            'Host: parimatch.co.tz',
            'User-Agent: PostmanRuntime/7.18.0',
            'X-BRAND-DATA: 1',
            'X-ODDS-SESSION: X-ODDS-SESSION',
            'cache-control: no-cache',
            'Postman-Token: f929c540-1dd9-4509-b982-4795f330a67b,c8d51a9b-93ac-4739-b3a7-01ba540a527c',
        ));
//        https://parimatch.co.tz/rest/customer/account/register
        $req = array(
            "affiliateCode" =>  "test", // parimatch.co.tz/?ref=test, взять с ссылки  на сайте
"brandCountryCode" =>  null,
"browser" => "firefox", // авто определения браузера
"channel" => "mobile", // тип представления лендинга
"device" => "desktop", // тип устройства
"countryCode" =>  "TZ", // страна
"currencyCode" =>  null,
"languageCode" =>  "EN", // язык
"loginName" =>  "255126645307", // поле ввода (для теста используй номера 001212111-001212999)
"mobile" =>  "255126645307", // поле ввода
"password" =>  "Pm12345", // автосгенерированный пароль - по типу 6 символов из которых    минимум одна цифра
"receiveEmail" =>  255126645307, // поле ввода
"receiveSms" =>  255126645307, // поле ввода
"verificationType" =>  null
        );



        return $this->apiCall('create_withdrawal', $req);
//            "code": int,
//"description": "string",
//"data":
//{
//    "value": int, // customerID, данную переменную нужно запомнить, она нужна будет дальше
//}
    }

    public function checkCode () {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Accept: */*',
            'Accept-Encoding: gzip, deflate',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Length: 93',
            'Content-Type: application/json',
            'Cookie: __cfduid=d504aadebe5b2d8d9d767f11e45804d0d1570009306; lsn=bubba',
            'Host: parimatch.co.tz',
            'Postman-Token: 1b2786f8-9ba4-4d4b-a393-986ad4ca9950,a91c8737-7eb0-4c1d-b468-ccf25ce43801',
            'User-Agent: PostmanRuntime/7.18.0',
            'X-BRAND-DATA: 1',
            'X-ODDS-SESSION: X-ODDS-SESSION',
            'cache-control: no-cache'
        ));
        //        https://parimatch.co.tz/rest/customer/account/activate-account
        $data = array(
            "activationCode" => "030358", //код из смс(когда будешь на этом этапе, спросишь у меня)
"activationType" => "account-and-sms",
"customerId" => "184941" //переменная из ответа прошлого запроса
        );
//        error
//        "code": 457,
//    "description": "Activation not succeeded"

//        "code": 200,
//    "description": "OK.",
//    "data": true


    }
    public function login () {

        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Accept: */*',
            'Accept-Encoding: gzip, deflate',
            'Authorization: Basic MjU1NzQyMDQ0Mjk1OjI1NTc0MjA0NDI5NQ==',
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Content-Length: 146',
            'Content-Type: application/json',
            'Cookie: __cfduid=d504aadebe5b2d8d9d767f11e45804d0d1570009306; lsn=bubba',
            'Host: parimatch.co.tz',
            'Postman-Token: e6e77384-4af7-42ff-93c8-0680023c1f50,a95f447f-c45a-4d3c-8a4a-abb5557e4bf7',
            'User-Agent: PostmanRuntime/7.18.0',
            'X-BRAND-DATA: 1',
            'X-ODDS-SESSION: X-ODDS-SESSION',
            'cache-control: no-cache'
        ));
//        https://parimatch.co.tz/rest/customer/session/login
        $data = array(
            "login" => "127746355", // то что было в поле ввода при первой итерации
   "password" => "Pm12345", //автосгенерированный пароль при первой итерации
   "countryCode" => "TZ",
   "channel" => "mobile",
   "browser" => "firefox",
   "device" => "desktop"
);

    }
    private function sendSms () {
//        https://6dq4e.api.infobip.com/sms/1/text/single
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Authorization: Basic eS5rb3Z5bGlhaWV2OnR1R3VyZUNodTRBciE=',
            'Host: 6dq4e.api.infobip.com',
        ));
        $data = array(
            "from" => "PARIMATCH",
	    "to" => "380504484788", // c поля ввода первой итерации
	    "text" => "Your password #password#" //автосгенерированный пароль с первой итерации
        );
    }

    private function apiCall($data = array())
    {

        // Set the API command and required fields
        $req['version'] = 1;
        $req['key'] = $this->public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');


        // Create cURL handle and initialize (if needed)
        if ($this->ch === null) {
            $this->ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);

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
