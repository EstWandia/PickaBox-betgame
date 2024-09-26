<?php
namespace app\components;
use Yii;
use yii\base\Component;
use app\components\Myhelper;
use app\models\Game;


class Digitain extends Component {
    public static function topGame()
    {
        $request=array(
            "sportId"=>1,
            "languageId"=>2,
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "stakeTypes"=>[1,2,3],
            "timeFilter"=>4
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_FEED."GetTopEventsJson";
        $response=Myhelper::httpPost($url,json_encode($request));
        $response=json_decode($response);
        return $response->GetTopEventsJsonResult;
    }
    public static function getGame()
    {
        $request=array(
            "sportId"=>1,
            "languageId"=>2,
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "stakeTypes"=>[1,37,3,26,722,7,682,999],
            "timeFilter"=>1
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_FEED."GetTopEventsJson";
        //var_dump($url);
        $request=json_encode($request);
        var_dump($request);
        $response=Myhelper::httpPost($url,$request);
        return $response;
    }

    public static function getRandomgames()
    {
        $request=array(
            "sportId"=>1,
            "languageId"=>2,
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "stakeTypes"=>[1,37,3,26,722,7,682,999],
            "timeFilter"=>1
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_FEED."GetTopEventsJson";
        //var_dump($url);
        $request=json_encode($request);
        //var_dump($request);
        $response=Myhelper::httpPost($url,$request);
        return $response;
    }
    public static function shopGame()
    {
        $request=array(
            "sportId"=>1,
            "languageId"=>2,
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "stakeTypes"=>array(1),
            "timeFilter"=>0
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_FEED."GetTopEventsJson";
        $response=Myhelper::httpPost($url,json_encode($request));
        $response=json_decode($response);
        return $response->GetTopEventsJsonResult;
    }
    public static function topSport()
    {
        $url=DIGITAIN_BASE_URL.DIGITAIN_FEED."GetTopSportsJson?languageId=2&userSystemRID=".DIGITAIN_USERSYSTEMRID;
        return Myhelper::httpGet($url);
    }
    public static function singleBet($match_id,$stake_id,$phone_number,$amount)
    {
        $placeBet=array(
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "phoneNumber"=>$phone_number,
            "matchStakes"=>array(array(
                "matchId"=>$match_id,
                "stakeId"=>$stake_id
            )),
            "betAmount"=>$amount
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_BET."PlaceBet";
        return Myhelper::httpPost($url,json_encode($placeBet));
    }
    public static function placeBet($match_stakes,$phone_number,$amount)
    {
        $placeBet=array(
            "userSystemRID"=>DIGITAIN_USERSYSTEMRID,
            "phoneNumber"=>"+".$phone_number,
            "matchStakes"=>$match_stakes,
            "betAmount"=>$amount
        );
        $url=DIGITAIN_BASE_URL.DIGITAIN_BET."PlaceBet";
        return Myhelper::httpPost($url,json_encode($placeBet));
    }
    public static function withdraw($inbox)
    {
        $amount=explode('#',trim($inbox->message))[1];
        $timestamp=time();
        $phone_number='+'.$inbox->sender;
        $req=[
            'PartnerId'=>PARTNER_ID,
            'Amount'=>$amount,
            'MobileNumber'=>$phone_number,
            'Signature'=>md5('methodCreateWithdrawalPartnerId'.PARTNER_ID.'TimeStamp'.$timestamp.'MobileNumber'.$phone_number.SECRET_KEY),
            'TimeStamp'=>$timestamp,
            'PaymentSystemId'=>PAYMENT_SYSTEM_ID,
            'PartnerPaymentSettingId'=>PARTNER_PAYMENT_SETTING_ID
    ];
    $req=json_encode($req);
    $file_name="/srv/apps/jambobet_sms/web/withdrawal.txt";
	Myhelper::writeToFile($file_name,"REQ->".$req." \n");
    $response= Myhelper::httpPost(DIGITAIN_WITHDRAWAL_URL,$req);
	Myhelper::writeToFile($file_name,"RES->".$response." \n");
    var_dump($response);
    return $response;

    }
    public static function checkBalance($phone_number)
    {
        $timestamp=time();
        //$phone_number='+'.$inbox->sender;
        $req=[
            'ClientId'=>0,
            'PartnerId'=>PARTNER_ID,
            'MobileNumber'=>$phone_number,
            'Signature'=>md5('methodCheckBalancePartnerId'.PARTNER_ID.'TimeStamp'.$timestamp.'MobileNumber'.$phone_number.SECRET_KEY),
            'TimeStamp'=>$timestamp
    ];
    $req=json_encode($req);
    //$file_name="/srv/apps/jambobet_sms/web/withdrawal.txt";
	///Myhelper::writeToFile($file_name,"REQ->".$req." \n");
    $response= Myhelper::httpPost(DIGITAIN_CHECKBALANCE_URL,$req);
	//Myhelper::writeToFile($file_name,"RES->".$response." \n");
    //var_dump($response);
    return $response;

    }
    public static function registerClient($phone_number,$pin)
    {
        $timestamp=time();
        $req=[
            'CurrencyId'=>'KES',
            'PartnerId'=>PARTNER_ID,
            'MobileNumber'=>$phone_number,
            'Pin'=>$pin,
            'Signature'=>md5('methodRegisterClientPartnerId'.PARTNER_ID.'TimeStamp'.$timestamp.'MobileNumber'.$phone_number.SECRET_KEY),
            'TimeStamp'=>$timestamp,
            'FirstName'=>$phone_number,
            'LastName'=>$phone_number
    ];
    $req=json_encode($req);
    //var_dump($req."\n");
    $file_name="/home/ubuntu/log/".date("Ymd").".txt";
	Myhelper::writeToFile($file_name,"REQ->".$req." \n");
    $response= Myhelper::httpPost(DIGITAIN_REGISTER_URL,$req);
	Myhelper::writeToFile($file_name,"RES->".$response." \n");
    //var_dump($response."\n");
    return $response;

    }
    public static function getHighlights($position)
    {
        $game = new Game();
        $data=Game::getGame();
        $message="TODAY'S TOP GAMES \n";
        $stop=$position+5;
        for($i=$position;$i<$stop; $i++)
        {
              $row=$data[$i];
              $time_stamp=Myhelper::formatJsonDate($row->D);
                $message.="ID ".$row->ScN."-".$time_stamp." \n";
                $game_id=$row->ScN;
               
                $message.=$row->HT."-".$row->AT."\n";
                $one="";
                $x="";
                $two="";
                $over15 = "";
                $over25 = "";
                $under25 = "";
                $under15 = "";
                $gg = "";
                $ng = "";
                $one_x = "";
                $one_two = "";
                $x_two = "";
                for($j=0;$j< count($row->StakeTypes); $j++)
                {
                    $stake_type=$row->StakeTypes[$j];
                    $stakes=$stake_type->Stakes;                        

                    if($stake_type->Id==1){                                
                        for($a=0;$a < count($stakes); $a++){ 
                            $stake=$stakes[$a];                    
                            if($stake->SC==1) {                        
                                $one=$stake->F; 
                            }                   
                            if($stake->SC==2) {                        
                                $x=$stake->F;
                            }                    
                            if($stake->SC==3){                        
                                $two=$stake->F;
                            }                
                        }        
                        
                    }
                    if($stake_type->Id==37){                                
                        for($a=0;$a < count($stakes); $a++){ 
                            $stake=$stakes[$a];                    
                            if($stake->SC==1) {                        
                                $one_x=$stake->F; 
                            }                   
                            if($stake->SC==2) {                        
                                $one_two=$stake->F;
                            }                    
                            if($stake->SC==3){                        
                                $x_two=$stake->F;
                            }                
                        }        
                        
                    }
                    if($stake_type->Id==3){     
                        for($b = 0; $b < count($stakes); $b++){
                            $stake = $stakes[$b];
                            if($stake->SC == 1 && $stake->A == 1.5){
                                $over15 = $stake->F;
                            }
                            if($stake->SC == 2 && $stake->A == 1.5){
                                $under15 = $stake->F;
                            }
                            if($stake->SC == 1 && $stake->A == 2.5){
                                $over25 = $stake->F;
                            }
                            if($stake->SC == 2 && $stake->A == 2.5){
                                $under25 = $stake->F;
                            }
                        }                    
                    } 
                    if($stake_type->Id==26){ 
                        for($c = 0; $c < count($stakes); $c++){
                            $stake = $stakes[$c];
                            if($stake->SC == 1){
                                $gg = $stake->F;
                            }
                            if($stake->SC == 2){
                                $ng = $stake->F;
                            }
                        }                          
                    }         
                }
                $message.="1=".$one." | X=".$x." | 2=".$two." | DC1X=".$one_x." | DC12=".$one_two." | DCX2=".$x_two." | OV1.5=".$over15." | UN1.5=".$under25." | OV2.5=".$over25." | UN2.5=".$under15." | GG=".$gg." | NG=".$ng."\n";
                $message.="---\n";
            
        }
        return $message;
    }
    public static function getStake($choice,$row)
    {
        if($choice==1)
        {
            return $row->StakeTypes[0]->Stakes[0];
        }
        if(strtolower($choice)=="x")
        {
            return $row->StakeTypes[0]->Stakes[1];
        }
        if($choice==2)
        {
            return $row->StakeTypes[0]->Stakes[2];
        }
        if(strtolower($choice)=="dc1x")
        {
            return $row->StakeTypes[1]->Stakes[0];
        }
        if(strtolower($choice)=="dc12")
        {
            return $row->StakeTypes[1]->Stakes[1];
        }
        if(strtolower($choice)=="dcx2")
        {
            return $row->StakeTypes[1]->Stakes[2];
        }
        if(in_array(strtolower($choice),["ov1.5","ov2.5"]))
        {
            $market_arr = $row->StakeTypes[2]->Stakes;
            foreach($market_arr as $obj)
            {
                if($choice == "OV1.5" && $obj->A == 1.5 && $obj->SC == 1){
                    return $obj;
                }else if($choice == "OV2.5" && $obj->A == 2.5 && $obj->SC == 1){
                    return $obj;
                }
            }
        }
        if(in_array(strtolower($choice),["un1.5","un2.5"]))
        {
            $market_arr = $row->StakeTypes[2]->Stakes;
            for($i = 0; $i < count($market_arr); $i++)
            {
                if($choice == "UN1.5" && $market_arr[$i]->A == 1.5 && $market_arr[$i]->SC == 2){
                    return $market_arr[$i];
                }else if($choice == "UN2.5" && $market_arr[$i]->A == 2.5 && $market_arr[$i]->SC == 2){
                    return $market_arr[$i];
                }
            }
        }
        if(strtolower($choice)=="gg")
        {
            return $row->StakeTypes[3]->Stakes[0];
        }
        if(strtolower($choice)=="ng")
        {
            return $row->StakeTypes[3]->Stakes[1];
        }
        if(strtoupper(substr($choice, 0, 2)) == "CS")
        {
            $stakes = $row->StakeTypes[4]->Stakes;
            return Digitain::getStakeByChoice($stakes, $choice);
        }


        return ;
    }

    public static function getStakeByChoice($stakes, $choice) {
        $choice = strtoupper($choice);
        if (strpos($choice, "CS") === 0) {
            $numbers = substr($choice, 2);
            $nums = str_split($numbers);
            $nums = implode(':', $nums);
            foreach ($stakes as $stake) {
                if ($stake->N === $nums) {
                    return $stake;
                }
            }
        }
        return null;
    }
    
}

?>