<?php

namespace app\controllers;

use app\models\MpesaPayments;
use app\models\MpesaSearch;
use app\models\Ussd;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
    public function actionCallback() {
        $sessionId   = $_POST["sessionId"];
        $serviceCode = $_POST["serviceCode"];
        $phoneNumber = $_POST["phoneNumber"];
        $text        = $_POST["text"];
        $ussddata =  Ussd::saveSession($phoneNumber, $text);
        
        if ($text == "") {
            // This is the first request. Note how we start the response with CON
            $response  = "CON What would you want to check \n";
            $response .= "1. Pick-a-Box \n";
            $response .= "2. Rasha Rasha \n";
            $response .= "3. Ma-Tatu \n";
            $response .= "4. Ongea Nasi \n";
            $response .= "5. Shinda upto 1.5Million INSTANT \n";
        
        } else if ($text == "1") {
            // Business logic for first level response
            $response = "CON Choose account information you want to view \n";
            $response .="CON Cheza Pick-a-Box Shinda 
            KES.1,500,000/- Instant!! \n";
            $response = "1: Chagua Nambari";
            $response = "1: Chaguliwa Nambari";
            if ($text == "1*1"){

            }if($text == "2"){
                $randomNumber = rand(1, 10);
                $response = "CON Umechagua nambari: $randomNumber\n";
                $response .= "Nunua tiketi Sasa\n";
                $response .= "1: KES. 50/-\n";
                $response .= "2: KES. 100/-\n";
                $response .= "3: KES. 150/-\n";
                $response .= "4: KES. 200/-\n";
                $response .= "5: KES. 500/-\n";
                $response .= "6: KES. 1000/-\n";
            }
                    
        
        } else if ($text == "2") {
            // Business logic for first level response
            // This is a terminal request. Note how we start the response with END
            $response = "END Your phone number is ".$phoneNumber;
        
        } else if($text == "1*1") { 
            // This is a second level response where the user selected 1 in the first instance
            $accountNumber  = "ACC1001";
        
            // This is a terminal request. Note how we start the response with END
            $response = "END Your account number is ".$accountNumber;
        
        }
        
        // Echo the response back to the API
        header('Content-type: text/plain');
        echo $response;
}
public function beforeAction($action)
    {            
        if (in_array($action->id,array('play','movitelplay','callback','collectioncallback','vodadisbursementcallback','vodacollectioncallback'))) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
}