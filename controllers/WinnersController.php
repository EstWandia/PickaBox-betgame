<?php

namespace app\controllers;

use app\models\Winners;
use app\models\WinnersSearch;
use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\IntegrityException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WinnersController implements the CRUD actions for Winners model.
 */
class WinnersController extends Controller
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
     * Lists all Winners models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WinnersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Winners model.
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
     * Creates a new Winners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Winners();

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
     * Updates an existing Winners model.
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
     * Deletes an existing Winners model.
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
     * Finds the Winners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Winners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Winners::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionSavewinners()
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
        if (!is_array($data) || !isset($data['transid'], $data['amount'], $data['phone_number'], $data['game'],$data['name'],)) {
            Yii::$app->response->statusCode = 400;
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 'error',
                'message' => 'Missing required data'
            ];
        }
    
        $trans_id = $data['transid'];
        $amount = $data['amount'];
        $phone_number = $data['phone_number'];
        $game = $data['game'];
        $name = $data['name'];
    
        $check = Winners::find()->where(['transid' => $trans_id])->count();
        if ($check == 0) {
            try {
                $model = new Winners();
                $model->id = Uuid::generate()->string;
                $model->transid = $trans_id;
                $model->name = $name;
                $model->phone_number= $phone_number;
                $model->game = $game;
                $model->amount = $amount;
                $model->created_at = date("Y-m-d H:i:s");
                $model->updated_at = date("Y-m-d H:i:s");
                Yii::$app->db->createCommand()->update('mpesa_payments', ['state' => 1])->execute();
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
        if (in_array($action->id, array('play', 'callback','savempesa', 'savewinners'))) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    
}
