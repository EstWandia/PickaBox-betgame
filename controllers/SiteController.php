<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Outbox;
use app\models\SentSms;
use app\models\Inbox;
use app\models\Game;
use app\components\Digitain;
use app\components\Myhelper;

class SiteController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','players'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest)
        {
            $outbox_count=0;
            // $sent_sms_count=SentSms::getSentsmsCount();
            $sent_sms_count = 0;
            $inbox_count=0;
            // $inbox_count=Inbox::getInboxCount();
            return $this->render('index',[
                "outbox_count"=>$outbox_count,
                "sent_sms_count"=>$sent_sms_count,
                "inbox_count"=>$inbox_count
            ]);
        }
        else{
            $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $this->layout="login";
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->layout="login";
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionGames()
    {
        $this->shopGameData();

    }
    private function shopGameData()
    {
        $response=[];
        $response=Game::getGame();   
        $filename="shop_games_".date("Y-m-d-His").".csv";
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename='.$filename );
        $output = fopen( 'php://output', 'w' );
        ob_start();
        $data=['GAMEID','DATETIME','HT','VS','AT','1','X','2','OVER','UNDER','GG', 'NG'];
        fputcsv( $output,$data);
        
        for($i=0;$i<count($response); $i++)
        {
            $arr=[];
              $row=$response[$i];
              $datetime=Myhelper::formatJsonDate($row->D);
              array_push($arr,$row->ScN);
              array_push($arr,$datetime);
              array_push($arr,strtoupper($row->HT));
              array_push($arr,"VS");
              array_push($arr, strtoupper($row->AT));
              $one=0;
              $x=0;
              $two=0;
              $over=0;
              $under=0;
              $gg = 0;
              $ng = 0;
              for($j=0; $j< count($row->StakeTypes); $j++) {                              
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
                if($stake_type->Id==3){     
                    for($b = 0; $b < count($stakes); $b++){
                        $stake = $stakes[$b];
                        if($stake->SC == 1 && $stake->A == 2.5){
                            $over = $stake->F;
                        }
                        if($stake->SC == 2 && $stake->A == 2.5){
                            $under = $stake->F;
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
            array_push($arr, $one, $x, $two, $over, $under, $gg, $ng);   
            fputcsv( $output,$arr);
        }
        Yii::$app->end();
        return ob_get_clean();
    }
    public function actionMoremarkets()
    {
        $response=[];
        $response=Game::getGame();   
        $filename="shop_games_".date("Y-m-d-His").".csv";
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename='.$filename );
        $output = fopen( 'php://output', 'w' );
        ob_start();
        $header = [' ',' ',' ',' ','Standard',' ',' ','Double chance', ' ', ' ','Over 2.5', ' ', 'Goals', ' ','Half Time',' ', ' ', 'Highest Scoring Half', ''];
        $data=['#','DATE','EVENT','Win1','X','Win2','1X','12','X2','O 25','U 25','GG', 'NG','F1','FX','F2', 'M1', 'MX', 'M2'];
        fputcsv( $output,$header);
        
        $groupedGames = [];
        foreach ($response as $game) {
            $leagueName = "Football. ".strtoupper($game->CN);
            if (!isset($groupedGames[$leagueName])) {
                $groupedGames[$leagueName] = [];
            }
            $groupedGames[$leagueName][] = $game;
        }
        foreach ($groupedGames as $leagueName => $games) {
            fputcsv($output, [$leagueName]);
            fputcsv($output, $data);
            foreach ($games as $game) {
                $arr = [];
                $datetime = Myhelper::formatJsonDate($game->D);
                $event = strtoupper($game->HT). " - ". strtoupper($game->AT);
                array_push($arr, $game->ScN, $datetime, $event);
    
                $one=0;$x=0;$two=0;
              $onex = 0;$onetwo = 0;$twox = 0;
              $over=0;$under=0;
              $gg = 0;$ng = 0;
              $f1 =0;$fx = 0;$f2 = 0;
              $m1 = 0; $mx = 0; $m2 = 0;
              for($j=0; $j< count($game->StakeTypes); $j++) {                              
                $stake_type=$game->StakeTypes[$j];

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
                            $onex=$stake->F; 
                        }                   
                        if($stake->SC==2) {                        
                            $onetwo=$stake->F;
                        }                    
                        if($stake->SC==3){                        
                            $twox=$stake->F;
                        }                
                    }        
                    
                }
                if($stake_type->Id==3){     
                    for($b = 0; $b < count($stakes); $b++){
                        $stake = $stakes[$b];
                        if($stake->SC == 1 && $stake->A == 2.5){
                            $over = $stake->F;
                        }
                        if($stake->SC == 2 && $stake->A == 2.5){
                            $under = $stake->F;
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
                if($stake_type->Id==722){ 
                    for($c = 0; $c < count($stakes); $c++){
                        $stake = $stakes[$c];
                        if($stake->SC == 1){
                            $f1 = $stake->F;
                        }
                        if($stake->SC == 2){
                            $fx = $stake->F;
                        }
                        if($stake->SC == 3){
                            $f2 = $stake->F;
                        }
                    }                          
                } 
                if($stake_type->Id==7){ 
                    for($c = 0; $c < count($stakes); $c++){
                        $stake = $stakes[$c];
                        if($stake->SC == 1){
                            $m1 = $stake->F;
                        }
                        if($stake->SC == 2){
                            $mx = $stake->F;
                        }
                        if($stake->SC == 3){
                            $m2 = $stake->F;
                        }
                    }                          
                }          
                           
                

            }  
            array_push($arr, $one, $x, $two,$onex,$onetwo, $twox, $over, $under, $gg, $ng, $f1, $fx, $f2, $m1, $mx, $m2);   
            fputcsv( $output,$arr);            
        }
        }
        Yii::$app->end();
        return ob_get_clean();
    }
    public function actionMoni()
    {
        $data=Game::getGame();
        var_dump(json_encode($data[0]));
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
