<?php

namespace app\controllers;

use app\components\myhelper;
use app\models\MpesaPayments;
use app\models\MpesaSearch;
use app\models\Ussd;
use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\IntegrityException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * MpesaController implements the CRUD actions for MpesaPayments model.
 */
class MpesaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MpesaPayments models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MpesaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MpesaPayments model.
     * @param string $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MpesaPayments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MpesaPayments();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MpesaPayments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MpesaPayments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MpesaPayments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return MpesaPayments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MpesaPayments::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function getPlayerHeader()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return;
        }
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');
    }    
    public function actionPlay()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }
        
        $this->getPlayerHeader();    
        $sessionId = Yii::$app->request->post("sessionId");
        $serviceCode = Yii::$app->request->post("serviceCode");
        $msisdn = Yii::$app->request->post("phoneNumber");
        $ussdString = Yii::$app->request->post("text");
        $randomNumber = rand(1, 6); 
        if(!isset($msisdn) || !isset($ussdString))
        {
            return;
        }
    
        $model = new Ussd();
        $model->id = Uuid::generate()->string;
        $model->service_code = $serviceCode;
        $model->msisdn = $msisdn;
        $model->ussd_str = $ussdString;
        $model->session_id = $sessionId;
        $model->user_ip = Yii::$app->request->userIP;
        $model->save(false);
    
        $message_arr = explode("*", $ussdString);
        $ussdString = implode("*", $message_arr);
    
        if ($ussdString === "") {
            // Initial request
            $response = "CON What would you want to check \n";
            $response .= "1. Pick-a-Box \n";
            $response .= "2. Rasha Rasha \n";
            $response .= "3. Ma-Tatu \n";
            $response .= "4. Ongea Nasi \n";
            $response .= "5. Exit \n";
        } else if ($ussdString === "1") {
            // First level response when "1" is selected
            $response = "CON Cheza Pick-a-Box Shinda KES.1,500,000/- Instant!!\n";
            $response .= "1. Chagua Nambari \n";
            $response .= "2. Chaguliwa Nambari \n";
        } else if ($ussdString === "1*1") {
            // Prompt for a number
            $response = "CON Weka nambari ya bahati kati ya 1 hadi 6\n";
        } else if (in_array($ussdString, PICKABOX)) {
            // Handle Pick-a-Box choices
            $number = substr($ussdString, -1);
            $response = "CON Umechagua nambari: $number\n";
            $response .= "Nunua tiketi Sasa\n";
            $response .= "1: KES. 50/-\n";
            $response .= "2: KES. 100/-\n";
            $response .= "3: KES. 150/-\n";
            $response .= "4: KES. 200/-\n";
            $response .= "5: KES. 500/-\n";
            $response .= "6: KES. 1000/-\n";
        } else if ($ussdString === "1*2") {
            // Generate a random number
            $randomNumber = rand(1, 6);
            $response = "CON Umechaguliwa nambari: $randomNumber\n";
            $response .= "Nunua tiketi Sasa\n";
            $response .= "1: KES. 50/-\n";
            $response .= "2: KES. 100/-\n";
            $response .= "3: KES. 150/-\n";
            $response .= "4: KES. 200/-\n";
            $response .= "5: KES. 500/-\n";
            $response .= "6: KES. 1000/-\n";
        } else if (in_array($ussdString, USSD_MONEY)) {
            // Handle payment requests
            $id = Uuid::generate()->string;
            $reference = myhelper::processGameIds($ussdString);
            $amount = myhelper::getAmount($ussdString);
            myhelper::reqToPay($id, $msisdn, $reference, $amount);
            myhelper::winningPlayer($ussdString, $id, $msisdn, $reference, $randomNumber);
            $response = LAST_LEVEL_MESSAGE;
        } else if ($ussdString === "2") {
            // Response for Rasha Rasha
            $response = "CON RASHA RASHA Chagua Kikundi\n";
            $response .= "Nunua tiketi Sasa\n";
            $response .= "1:  KES 20- WIN 1,360\n";
            $response .= "2:  KES 50 - WIN 3,500 \n";
            $response .= "3:  KES 100 - WIN 4,020 \n";
            $response .= "4:  KES 200 - WIN 13,600\n";
            $response .= "5:  KES 500 - WIN 18,750\n";
            $response .= "6: KES. 1000 - WIN 30,000\n";
        } else if (in_array($ussdString, RASHARASHA)) {
            // Handle Rasha Rasha payments
            $id = Uuid::generate()->string;
            $reference = myhelper::processGameIds($ussdString);
            $amount = myhelper::getRashaRashaAmount($ussdString);
            myhelper::reqToPay($id, $msisdn, $reference, $amount);
            $response = LAST_LEVEL_MESSAGE;
            myhelper::winningPlayer($ussdString, $id, $msisdn, $reference, $randomNumber);
        } else {
            // Invalid request
            $response = INVALID_REQUEST;
        }
        // Send the response back to the USSD API
        header('Content-type: text/plain');
        echo $response;
    }
    
    public function actionMakepayment($amount, $msisdn, $reference) {
        // Payment processing through external service
        $url = 'https://localhost:8000/mpesapayments/savempesa'; // Ensure this URL is correctly reachable from your environment
        $data = array(
            'amount' => $amount,
            'msisdn' => $msisdn,
            'transid' =>$id,
            'reference'=>$reference
        );
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'ApiKey: ' // Insert the correct API key here
        );
        $response = Myhelper::curlPost($url, $data, $headers); // Assuming Myhelper::curlPost is correctly defined to make POST requests
        return $response;
    }
    public function actionSavempesa()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return;
        }
    
        // Get and decode the JSON input
        $jsondata = file_get_contents('php://input');
        $data = json_decode($jsondata, true);
        
        // Check if json_decode failed
        if (json_last_error() !== JSON_ERROR_NONE) {
            Yii::$app->response->statusCode = 400;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error',
                'message' => 'Invalid JSON data'
            ];
        }
    
        // Check if $data is an array and contains required keys
        if (!is_array($data) || !isset($data['transid'], $data['amount'], $data['msisdn'], $data['reference'])) {
            Yii::$app->response->statusCode = 400;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error',
                'message' => 'Missing required data'
            ];
        }
    
        $trans_id = $data['transid'];
        $amount = $data['amount'];
        $msisdn = $data['msisdn'];
        $reference = $data['reference'];
    
        $check = MpesaPayments::find()->where(['transid' => $trans_id])->count();
    
        if ($check == 0) {
            try {
                $model = new MpesaPayments();
                $model->id = Uuid::generate()->string;
                $model->transid = $trans_id;
                $model->name = rand(2, 99) . 'FirstName'; // Example Name
                $model->msisdn = $msisdn;
                $model->reference = $reference;
                $model->amount = $amount;
                $model->created_at = date("Y-m-d H:i:s");
                $model->updated_at = date("Y-m-d H:i:s");
                $model->save(false);
            } catch (IntegrityException $e) {
                Yii::error("IntegrityException: " . $e->getMessage());
                Yii::$app->response->statusCode = 500;
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'status' => 'error',
                    'message' => 'Failed to save data'
                ];
            }
        }
    
        // Set response
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        Yii::$app->response->data = $data; // Set the data property, not content
        return Yii::$app->response->data;
    }
        
    
    public function beforeAction($action) {
        // Disable CSRF validation for specific actions
        if (in_array($action->id, array('play', 'callback','savempesa', 'vodacollectioncallback'))) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
}