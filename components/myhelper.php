<?php


namespace app\components;

use app\models\MpesaPayments;
use Exception;
use Webpatser\Uuid\Uuid;
use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class Myhelper
 * @package app\components
 */
class myhelper extends Component
{

	public $session_key = '';

	/**
	 * Encode array from latin1 to utf8 recursively
	 *
	 * @param $dat
	 *
	 * @return array|string
	 */
public static function curlPost($postData, $headers, $url)
	{
		$ch = curl_init($url);
		curl_setopt_array($ch, array(
			CURLOPT_POST           => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_POSTFIELDS     => json_encode($postData)
		));
		// Send the request
		$response = curl_exec($ch);
		// $statusCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		// var_dump($statusCode);
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if ($response === false) {
			var_dump(curl_error($ch));
			exit();
			return curl_error($ch);
		}

		return $response;
	}
	public static function getGamesId($id)
{
   
    $arr = [
        '1' => 'PICKABOX',
        '2' => 'RASHARASHA',
        '3' => 'MA-TATU',
    ];
    
    // Check if the id exists in the array
    if (isset($arr[$id])) {
        return $arr[$id];
    }
    
    // Return null or a default value if the id is not found
    return null;
}
public static function processGameIds($idsString)
{
    // Convert the ID string to an array
    $idsArray = explode('*', $idsString);

    // Get the first element from the array
    $firstId = $idsArray[0] ?? null; // Safe access, defaults to null if not set

    // Check if the first ID is not null
    if ($firstId !== null) {
        $gameName = self::getGamesId($firstId); // Call getGamesId with the first ID

        if ($gameName !== null) {
            return $gameName; // Return the corresponding game name
        }
    }
}
public static function getAmount($ussdString)
{
    $idsArray = explode('*', $ussdString);

    if (!empty($idsArray)) {
        $lastElement = end($idsArray);

        $amounts = [
            '1' => 50,
            '2' => 100,
            '3' => 150,
            '4' => 200,
            '5' => 500,
            '6' =>1000

        ];

        if (isset($amounts[$lastElement])) {
            return $amounts[$lastElement];
        }
    }

    return null;
}

public static function ReqToPay($id,$msisdn,$reference,$amount)
	{
		$request = [
			"transid"=>$id,
			"amount" => $amount,
			"externalId" => $id,
			"msisdn" =>$msisdn,
			"reference" => $reference
		];
		$url = REQUEST_TO_PAY;
		//$jsonRequest = json_encode($request);

		//var_dump($jsonRequest);exit;
		$headers = [
			'Content-Type:application/json',
		];
		$response = myhelper::curlPost($request, $headers, $url);
		//RelTransactionLog::log(Uuid::generate()->string,$response,'mtn-stk-resp',0);
		return $response;
		//var_dump($response);exit;

		
	}
	public static function winningPlayer($arr, $id, $msisdn, $reference,$randomNumber)
{
    $constantAmt = 2000;
   $amountTocheck=myhelper::AmountAttained();
    $idsArray = explode('*', $arr);
    //var_dump($amountTocheck);exit;

    if (count($idsArray) >= 2) {
        $firstValue = $idsArray[0];
        $secondValue = $idsArray[1];
        $totalCount = count($idsArray);

        $money = [
            '1' => '50',
            '2' => '100',
            '3' => '0',
            '4' => '200',
            '5' => '0',
            '6' => '0',  
        ];
        
        if (in_array($firstValue, ['1']) && in_array($secondValue, ['1', '2'])) {
            if ($secondValue == '1') {
                $secondLastArr = $idsArray[$totalCount - 2];
            } elseif ($secondValue == '2') {
                $secondLastArr = $randomNumber;
                var_dump($secondLastArr);
            } 
            if (isset($money[$secondLastArr]) && ($money[$secondLastArr] > 0) && ($amountTocheck>=$constantAmt)) {
                //var_dump($money[$secondLastArr]);exit;
                $transid = $id;
                $amount = $money[$secondLastArr];
                $phone_number = $msisdn;
                $game = $reference;

                $paymentRecord = MpesaPayments::find()->where(['transid' => $transid])->one();

                if ($paymentRecord !== null) {
                    $name = $paymentRecord->name;
                }

                $request = [
                    "transid" => $transid,
                    "amount" => $amount,
                    "externalId" => $transid,
                    "phone_number" => $phone_number,
                    "game" => $game,
                    "name" => $name
                ];

                $url = SAVE_WINNER; 

                $headers = [
                    'Content-Type: application/json',
                ];
                $response = myhelper::curlPost($request, $headers, $url);

                return $response;
            }
		}
	}
}
public static function AmountAttained()
{
    $sql = "SELECT SUM(amount) as total FROM mpesa_payments WHERE state = 0";
    $total = Yii::$app->db->createCommand($sql)->queryScalar(); // Use queryScalar to fetch a single value
    return $total;
}
public static function getRashaRashaAmount($ussdString)
{
    $idsArray = explode('*', $ussdString);

    if (!empty($idsArray)) {
        $lastElement = end($idsArray);

        $amounts = [
            '1' => 20,
            '2' => 50,
            '3' => 100,
            '4' => 200,
            '5' => 500,
            '6' =>1000

        ];

        if (isset($amounts[$lastElement])) {
            return $amounts[$lastElement];
        }
    }

    return null;
}

}