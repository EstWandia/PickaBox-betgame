<?php
namespace app\components;
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\models;
use app\components\Myhelper;
use app\models\Outbox;
use app\models\Inbox;






class Sdp extends Component {
    public static function getToken()
    {
        $postData=array(
            'username'=>SAFARICOM_SMS_APIUSERNAME,
            'password'=>SAFARICOM_SMS_APIPASSWORD
        );
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest'
        );
        $url=SAFARICOM_SMS_TOKENAPI;
		$response = Myhelper::curlPost($postData,$headers,$url);
        return $response;
    }
    public static function getRefreshToken($refreshToken)
    {
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest',
            'X-Authorization: Bearer '.$refreshToken
        );
        $url=SAFARICOM_SMS_REFRESHTOKENAPI;
		$response = Myhelper::curlGet($headers,$url);
        return $response;
    }
    public static function sendBulkSms($id,$msisdn,$message,$sender)
    {
        
        $call_back="https://jambobet.app/api/bulkdlr";
        if(in_array($sender,['JAMBOSPIN','JambobetInf','PIGA-KAZI']))
        {
            $packageId=PROMOTIONAL_PACKGEID;
        }
        else
        {
            $packageId=SAFARICOM_PACKAGEID;
        }
        $postData =  [
            "timeStamp" => time(),
            "dataSet"   => [
                [
                    "userName"          => SAFARICOM_SMS_BULKUSERNAME,
                    "channel"           => "SMS",
                    "packageId"         =>$packageId,
                    'oa'=>$sender,
                    "msisdn"            => $msisdn,
                    "message"           =>$message,
                    "uniqueId"          =>$id,
                    "actionResponseURL"=>$call_back
                ]
            ]
        ];
        $token=json_decode(Sdp::getToken())->token;
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest',
            'X-Authorization: Bearer '.$token
        );
        $url=SAFARICOM_SMS_BULKSMS;
		$response = Myhelper::curlPost($postData,$headers,$url);
        return $response;
    }
    public static function promoDemo($id,$msisdn,$message,$sender)
    {
        
        $call_back="https://jambobet.app/api/bulkdlr";
        $postData =  [
            "timeStamp" => time(),
            "dataSet"   => [
                [
                    "userName"          => SAFARICOM_SMS_BULKUSERNAME,
                    "channel"           => "SMS",
                    "packageId"         =>PROMOTIONAL_PACKGEID,
                    'oa'=>$sender,
                    "msisdn"            => $msisdn,
                    "message"           =>$message,
                    "uniqueId"          =>$id,
                    "actionResponseURL"=>$call_back
                ]
            ]
        ];
        $token=json_decode(Sdp::getToken())->token;
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest',
            'X-Authorization: Bearer '.$token
        );
        $url=SAFARICOM_SMS_BULKSMS;
		$response = Myhelper::curlPost($postData,$headers,$url);
        return $response;
    }
    public static function sendBatch($dataset)
    {
        $postData =  [
            "timeStamp" => time(),
            "dataSet"   =>$dataset
        ];
        $token=json_decode(Sdp::getToken())->token;
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest',
            'X-Authorization: Bearer '.$token
        );
        $url=SAFARICOM_SMS_BULKSMS;
		$response = Myhelper::curlPost($postData,$headers,$url);
        return $response;
    }
    public static function sendOnDemandSms($request_id,$link_id,$msisdn,$message)
    {
        $data = [
            [
                "name"=> "Msisdn",
                "value"=> $msisdn
            ],
            [
                "name"=> "Content",
                "value"=> $message
            ],
            [
                "name"=> "OfferCode",
                "value"=> SAFARICOM_SMS_ONDEMAND_OFFERCODE
            ],
            [
                "name"=> "CpId",
                "value"=> SAFARICOM_SMS_CPID
            ],
            [
                "name"=> "LinkId",
                "value"=> $link_id
            ]
        ];
        $postData = [
            "requestId"=> $request_id,
            //"requestTimeStamp"=> $this->SDP->generateTimestamp(),
            "channel"=> "APIGW",
            "operation"=> "SendSMS",
            "requestParam" => [
                "data"=> $data
            ]
        ];
        $token=json_decode(Sdp::getToken())->token;
        $headers=array(
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest',
            'X-Authorization: Bearer '.$token
        );
        $url=SAFARICOM_SMS_ONDEMAND_SEND;
		$response = Myhelper::curlPost($postData,$headers,$url);
        return $response;
    }
    public static function activateSubscription($requestId, $offerCode, $phoneNumber,$headers) {
        $time_stamp=time();
        $body = [
            "requestId" => $requestId,
            "requestTimeStamp" => $time_stamp,
            "Channel"=> "SMS",
            "Operation"=> "ACTIVATE",
            "requestParam"=> [
                "data"=> [
                    [
                        "name"=> "OfferCode",
                        "value"=> $offerCode
                    ],
                    [
                        "name"=> "Msisdn",
                        "value"=> $phoneNumber
                    ],
                    [
                        "name"=> "Language",
                        "value"=> "1"
                    ],
                    [
                        "name"=> "CpId",
                        "value"=> SAFARICOM_SMS_CPID
                    ]
                ]
            ]
        ];
        $url=SAFARICOM_SMS_SUBSCRIPTION;
        $response = Myhelper::curlPost($body,$headers,$url);
        return $response;
    }
}
?>