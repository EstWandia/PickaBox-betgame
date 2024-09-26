<?php

namespace app\controllers;

use Yii;
use app\models\SentSms;
use app\models\SentSmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SentSmsController implements the CRUD actions for SentSms model.
 */
class SentsmsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['create', 'update','index','players','daily','monthly','promotional','transactional'],
                'rules' => [
                    [
                        'actions' => ['create', 'update','index','players','daily','monthly','promotional','transactional'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if(!Yii::$app->user->isGuest){
                                return TRUE;
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SentSms models.
     * @return mixed
     */
    public function actionTransactional()
    {
        $searchModel = new SentSmsSearch();
        $category="notbulk";
        $start_date = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 23:59:59'); 
        $criterion = Yii::$app->request->getQueryParam('criterion', null);
    
        if ($criterion === 'daily') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59'); 
        } elseif ($criterion === 'monthly') {
            $start_date =date("Y-m-01");// First day of the month
            $end_date =date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));
        } elseif ($criterion === 'range') {
            $start_date = Yii::$app->request->getQueryParam('from', $start_date);
            $end_date = Yii::$app->request->getQueryParam('to', $end_date);
        }
    
        // Call the search method with the category and date range
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $category, false, false, $start_date, $end_date);
        return $this->render('transactional', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionPromotional()
    {
        $searchModel = new SentSmsSearch();
        $category="bulk";
        $start_date = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 23:59:59'); 
        $criterion = Yii::$app->request->getQueryParam('criterion', null);
    
        if ($criterion === 'daily') {
            $start_date = date('Y-m-d 00:00:00');
            $end_date = date('Y-m-d 23:59:59');
        } elseif ($criterion === 'monthly') {
            $start_date =date("Y-m-01");// First day of the month
            $end_date =date("Y-m-".cal_days_in_month(CAL_GREGORIAN,date("m"),date("Y")));
        } elseif ($criterion === 'range') {
            $start_date = Yii::$app->request->getQueryParam('from', $start_date);
            $end_date = Yii::$app->request->getQueryParam('to', $end_date);
        }
    
        // Call the search method with the category and date range
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $category, false, false, $start_date, $end_date);

        return $this->render('promotional', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SentSms model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDownloadMessageCount()
    {
        $query = (new \yii\db\Query())
            ->select([
                'DATE_FORMAT(created_date, "%Y-%m") as month',
                'COUNT(*) as message_count'
            ])
            ->from('inbox')
            ->where(['between', 'created_date', '2023-07-01 00:00:00', '2034-06-30 23:59:59'])
            ->groupBy(['month'])
            ->orderBy(['month' => SORT_ASC])
            ->all();

        // Prepare CSV content
        $csvData = "Month,Message Count\n";
        foreach ($query as $row) {
            $csvData .= $row['month'] . ',' . $row['message_count'] . "\n";
        }

        // Set headers to prompt the user to download the file
        Yii::$app->response->setDownloadHeaders('29111_message_count_jul2023_jun2034.csv', 'text/csv', false, strlen($csvData));
        return $csvData;
    }


    /**
     * Creates a new SentSms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function Create()
    {
        $model = new SentSms();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SentSms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SentSms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SentSms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SentSms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SentSms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }  
    public function actionMonthly(){
        $sentSms = new SentSms();
        $data = $sentSms->getMonthlySentSms();
        return $this->render('monthly', [
            'data' => $data,
        ]);
    }
    public function actionDaily(){
        $sentSms = new SentSms();
        $data = $sentSms->getDailySms();
        return $this->render('daily', [
            'data' => $data,
        ]);
    }
            //removed action
            public function actionPlayers()
            {
                $this->players();
        
            }
            private function players()
            {
                $response=[];
                
                $response=SentSms::getPlayers();
                $filename="unique_players".date("Y-m-d-His").".csv";
                header( 'Content-Type: text/csv; charset=utf-8' );
                header( 'Content-Disposition: attachment; filename='.$filename );
                $output = fopen( 'php://output', 'w' );
                ob_start();
                for($i=0;$i<count($response); $i++)
                {
                    $arr=[];
                    $row=$response[$i];
                    array_push($arr,$row['phone_number']);   
                    fputcsv( $output,$arr);
                    
                }
                Yii::$app->end();
                return ob_get_clean();
            }
    
}
