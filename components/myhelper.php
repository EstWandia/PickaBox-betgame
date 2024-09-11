<?php


namespace app\components;

use app\models\MpesaPayments;
use app\models\Outbox;
use app\models\Template;
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
                '6' => 1000
            ];

            if (isset($amounts[$lastElement])) {
                $amount = $amounts[$lastElement];
                return intval(round($amount));
            }
        }

        return null;
    }



    public static function ReqToPay($id, $msisdn, $reference, $amount)
    {
        $request = [
            "transid" => $id,
            "amount" => $amount,
            "externalId" => $id,
            "msisdn" => $msisdn,
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
    public static function winningPlayer($arr, $id, $msisdn, $reference, $randomNumber, $amount)
    {

        $mpesa = (int) myhelper::getAmountAttained('PICKABOX');
        var_dump($mpesa);
        $disburse = (int) myhelper::getAmountDisbursed('PICKABOX');
        $winningAmount = $mpesa - $disburse;
        var_dump($winningAmount);
        $idsArray = explode('*', $arr);
        $phone_number = $msisdn;
        $game = $reference;

        if (count($idsArray) >= 2) {
            $firstValue = $idsArray[0];
            $secondValue = $idsArray[1];
            $totalCount = count($idsArray);

            if ($winningAmount < 0) {
                // Use the constant values if the winningAmount is negative
                $money = ['50', '100', '0', '200', '0', '0'];
            } else {
                // Calculate 20%, 30%, and 50% of the winningAmount
                $twentyPercent = (int) ($winningAmount * 0.20);
                $thirtyPercent = (int) ($winningAmount * 0.30);
                $fiftyPercent = (int) ($winningAmount * 0.50);

                // Create the money array
                $money = ['0', '0', '0', (int) $twentyPercent, (int) $thirtyPercent, (int) $fiftyPercent];

                // Optionally shuffle the array if needed
                shuffle($money);
            }

            // Create an associative array with numeric keys starting from 1
            $shuffledMoney = [];
            foreach ($money as $index => $value) {
                $shuffledMoney[$index + 1] = (int) $value; // Index + 1 to start keys from 1
            }

            // Output the shuffled associative array
            print_r($shuffledMoney);
            $transid = $id;

            if (in_array($firstValue, ['1']) && in_array($secondValue, ['1', '2'])) {
                if ($secondValue == '1') {
                    $secondLastArr = $idsArray[$totalCount - 2];
                } elseif ($secondValue == '2') {
                    $secondLastArr = $randomNumber;
                }
                var_dump($shuffledMoney[$secondLastArr]);

                if (isset($shuffledMoney[$secondLastArr]) && ($shuffledMoney[$secondLastArr] > 0) && ($shuffledMoney[$secondLastArr] <= $winningAmount) && $amount !== 1000) {

                    $disburse = isset($shuffledMoney[$secondLastArr]) ? $shuffledMoney[$secondLastArr] : 0;
                    self::getPickWinnerData($transid, $disburse, $msisdn, $reference);
                    self::saveOutboxPick($transid, $idsArray, $randomNumber, $totalCount, $shuffledMoney, $disburse, 'WIN');
                } else if (isset($shuffledMoney[$secondLastArr]) && ($shuffledMoney[$secondLastArr] > 0) && ($shuffledMoney[$secondLastArr] <= $winningAmount) && $amount == 1000) {

                    $fiftyPercentIndex = array_search((int) $fiftyPercent, $shuffledMoney);

                    // If 50% amount is found in shuffledMoney
                    if ($fiftyPercentIndex !== false) {
                        $disburse = $shuffledMoney[$fiftyPercentIndex];
                        self::getPickWinnerData($transid, $disburse, $msisdn, $reference);
                        self::saveOutboxPick($transid, $idsArray, $randomNumber, $totalCount, $shuffledMoney, $disburse, 'WIN');
                    } else {
                        self::saveOutboxPick($transid, $idsArray, $randomNumber, $totalCount, $shuffledMoney, $disburse, 'LOSE');
                    }
                } else {
                    // If amountToCheck is not valid or conditions not met, handle as lose
                    self::saveOutboxPick($transid, $idsArray, $randomNumber, $totalCount, $shuffledMoney, $disburse, 'LOSE');
                }
            }
        } else {
            return "Invalid input or condition not met";
        }
    }

    public static function getamountAttained($type)
{
    // Determine the reference value based on the type
    $referenceValue = ($type == 'RASHARASHA') ? 'RASHARASHA' : 'PICKABOX';

    // Prepare the SQL query with the reference condition
    $sql = "SELECT SUM(amount) as total 
            FROM playing_pool  
            WHERE DATE(created_at) = CURDATE() 
              AND reference = :reference"; // Filter for today's date and the reference value

    // Execute the query with the reference parameter
    $total = Yii::$app->db->createCommand($sql)
        ->bindValue(':reference', $referenceValue)
        ->queryScalar(); // Fetch a single value

    // Return 0 if the result is NULL, cast to int
    return $total !== null ? (int) $total : 0;
}



public static function getAmountDisbursed($type)
{
    // Determine the reference value based on the type
    $referenceValue = ($type == 'RASHARASHA') ? 'RASHARASHA' : 'PICKABOX';

    // Prepare the SQL query with the reference condition
    $sql = "SELECT SUM(amount) as total 
            FROM winning  
            WHERE DATE(created_at) = CURDATE() 
              AND game = :game"; // Filter for today's date and the reference value

    // Execute the query with the reference parameter
    $total = Yii::$app->db->createCommand($sql)
        ->bindValue(':game', $referenceValue)
        ->queryScalar(); // Fetch a single value

    // Return 0 if the result is NULL, cast to int
    return $total !== null ? (int) $total : 0;
}



    public static function getRashaRashaAmount($ussdString, $type = 'WIN')
    {
        $idsArray = explode('*', $ussdString);

        if (!empty($idsArray) && isset($idsArray[1])) {
            $index = (int) $idsArray[1];
            $amounts = [
                '1 KES 20 - WIN 60',
                '2 KES 50 - WIN 3,500',
                '3 KES 100 - WIN 4,020',
                '4 KES 200 - WIN 13,600',
                '5 KES 500 - WIN 18,750',
                '6 KES 1000 - WIN 30,000'
            ];

            if (isset($amounts[$index - 1])) {
                $selectedString = $amounts[$index - 1];
                $pattern = $type === 'KES' ? '/KES\s(\d+)/' : '/WIN\s([\d,]+)/';

                if (preg_match($pattern, $selectedString, $matches)) {
                    $result = str_replace(',', '', $matches[1]);

                    // Convert result to integer
                    $result = (int) $result;

                    return $result;
                }
            }
        }

        return null;
    }



    public static function winningPlayerRasharasha($ussdString, $id, $msisdn, $reference,$disburseamount)
    {
        $transid = $id;
        $mpesa = (int) myhelper::getAmountAttained('RASHARASHA');
        var_dump($mpesa);
        $disburse = (int) myhelper::getAmountDisbursed('RASHARASHA');
        $winningAmount = $mpesa - $disburse;
        var_dump($winningAmount);
        $idsArray = explode('*', $ussdString);
        $phone_number = $msisdn;
        $game = $reference;
        $playeramount=myhelper::getRashaRashaAmount($ussdString, 'KES');
        $doubledisburseamount = (int) (2 * $disburseamount);
        
        if (count($idsArray) >= 2) {
            if ($winningAmount > $disburseamount && !in_array($playeramount, [20, 50])) {
                self::getRashaWinnerData($transid, $disburseamount, $msisdn, $reference);
                myhelper::saveRasharashaOutbox($id, $ussdString, 'WIN');
            } else if ($winningAmount >= $doubledisburseamount && in_array($playeramount, [20, 50])) {
                self::getRashaWinnerData($transid, $disburseamount, $msisdn, $reference);
                myhelper::saveRasharashaOutbox($id, $ussdString, 'WIN');
            } else {
                myhelper::saveRasharashaOutbox($id, $ussdString, 'LOSE');
            }
        } else {
            return "Invalid input or condition not met";
        }
    }
    public static function saveRasharashaOutbox($id, $ussdString, $type = 'WIN')
    {
        $transid = $id;
        $ticketId = '#' . substr(bin2hex(random_bytes(3)), 0, 6);
        $round = '#' . substr(bin2hex(random_bytes(5)), 0, 10);
        $payment = MpesaPayments::find()->where(['transid' => $transid])->one();

        if (!$payment) {
            return "Payment record not found for {$type} case";
        }

        $templateName = ($type == 'LOSE') ? 'lose_rasharasha' : 'winner_rasharasha';
        $template = Template::find()->where(['name' => $templateName])->one();

        if (!$template) {
            return "Template not found for {$type} case";
        }

        $message = $template->message;
        $name = $payment->name ?? 'Player';
        $outbox = new Outbox();
        $outbox->id = $transid;

        if ($type == 'LOSE') {
            $outbox->type = $type;
            $rank = rand(1, 99);
            $message = str_replace(['[ticket]', '[rank]', '[round]', '[name]'], [$ticketId, $rank, $round, $name], $message);
        } else {
            $outbox->type = $type;
            $amount = myhelper::getRashaRashaAmount($ussdString, 'WIN');
            $date = date('Y-m-d H:i:s');
            $message = str_replace(['[name]', '[amount]', '[round]', '[date]'], [$name, $amount, $round, $date], $message);
        }

        $outbox->message = $message;

        return $outbox->save(false) ? null : "Failed to save outbox message: " . print_r($outbox->getErrors(), true);
    }
    public static function getPickWinnerData($transid, $disburse, $msisdn, $reference)
    {

        $phone_number = $msisdn;
        $game = $reference;

        // Find the payment record
        $paymentRecord = MpesaPayments::find()->where(['transid' => $transid])->one();
        if (!$paymentRecord) {
            return ["error" => "Payment record not found"];
        }
        $name = $paymentRecord->name;

        // Prepare the request data
        $request = [
            "transid" => $transid,
            "amount" => $disburse,
            "externalId" => $transid,
            "phone_number" => $phone_number,
            "game" => $game,
            "name" => $name
        ];

        $url = SAVE_WINNER;
        $headers = ['Content-Type: application/json'];
        myhelper::curlPost($request, $headers, $url);

        // return $response;
    }
    public static function getRashaWinnerData($transid, $disburseamount, $msisdn, $reference)
    {

        $phone_number = $msisdn;
        $game = $reference;

        // Find the payment record
        $paymentRecord = MpesaPayments::find()->where(['transid' => $transid])->one();
                if (!$paymentRecord) {
                    return "Payment record not found";
                }
                $name = $paymentRecord->name;

                $request = [
                    "transid" => $transid,
                    "amount" => $disburseamount,
                    "externalId" => $transid,
                    "phone_number" => $phone_number,
                    "game" => $game,
                    "name" => $name
                ];

                $url = SAVE_WINNER;
                $headers = ['Content-Type: application/json'];
                $response = myhelper::curlPost($request, $headers, $url);

        // return $response;
    }



    public static function saveOutboxPick($transid, $idsArray, $randomNumber, $totalCount, $shuffledMoney, $disburse, $type = 'LOSE')
    {
        // Generate a random ticket
        $ticket = '#' . substr(bin2hex(random_bytes(3)), 0, 6);

        // Fetch the payment record
        $payment = MpesaPayments::find()->where(['transid' => $transid])->one();
        if (!$payment) {

            return "Payment record not found for losing case";
        }

        // Fetch the template
        $templateName = ($type == 'LOSE') ? 'lose_pickabox' : 'winner_pickabox';
        $template = Template::find()->where(['name' => $templateName])->one();
        if (!$template) {

            return "Template not found for $type case";
        }

        $message = $template->message;


        // Build the shuffled money string
        $shuffledMoneyString = '';
        foreach ($shuffledMoney as $key => $value) {
            $shuffledMoneyString .= 'BOX' . $key . ' KES ' . $value . ' ';
        }
        $shuffledMoneyString = trim($shuffledMoneyString);

        // Determine the replacement values based on the type
        if ($type == 'LOSE') {
            if (isset($idsArray[0]) && $idsArray[0] === 1 && isset($idsArray[1]) && $idsArray[1] === 1) {
                $secondLastArr = $idsArray[$totalCount - 2];
                $message = str_replace(['[randomNum]', '[Ticket]', '[box]'], [$secondLastArr, $ticket, $shuffledMoneyString], $message);
            } else {
                $message = str_replace(['[randomNum]', '[Ticket]', '[box]'], [$randomNumber, $ticket, $shuffledMoneyString], $message);
            }
        } elseif ($type == 'WIN') {
            if (isset($idsArray[0]) && $idsArray[0] === 1 && isset($idsArray[1]) && $idsArray[1] === 1) {
                $secondLastArr = $idsArray[$totalCount - 2];
                $message = str_replace(['[amount]', '[randomNum]', '[Ticket]', '[box]'], [$disburse, $secondLastArr, $ticket, $shuffledMoneyString], $message);
            } else {
                $message = str_replace(['[amount]', '[randomNum]', '[Ticket]', '[box]'], [$disburse, $randomNumber, $ticket, $shuffledMoneyString], $message);
            }
        }



        // Create and save the Outbox record
        $outbox = new Outbox();
        $outbox->id = $payment->transid;
        $outbox->message = $message;

        if (!$outbox->save(false)) {
            return "Failed to save outbox message: " . print_r($outbox->getErrors(), true);
        }

        return "Outbox message saved successfully";
    }
}
