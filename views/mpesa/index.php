<?php

use app\models\MpesaPayments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MpesaSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mpesa Payments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mpesa-payments-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Mpesa Payments', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'TransID',
            'FirstName',
            'MiddleName',
            'LastName',
            //'MSISDN',
            //'InvoiceNumber',
            //'BusinessShortCode',
            //'ThirdPartyTransID',
            //'TransactionType',
            //'OrgAccountBalance',
            //'BillRefNumber',
            //'TransAmount',
            //'is_archived',
            //'created_at',
            //'updated_at',
            //'deleted_at',
            //'state',
            //'station_id',
            //'operator',
            //'tickets',
            //'moved',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MpesaPayments $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
