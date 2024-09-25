<?php

use app\models\GameTransactionLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\GameTransactionLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Game Transaction Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-transaction-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php #Html::a('Create Game Transaction Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'json_data:ntext',
            'date',
            'api_type',
            'CheckoutRequestID',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, GameTransactionLog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
