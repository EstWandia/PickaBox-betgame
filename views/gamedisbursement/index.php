<?php

use app\models\GameDisbursement;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\GameDisbursementSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Game Disbursements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-disbursement-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php #Html::a('Create Game Disbursement', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'bet_id',
            'msisdn',
            'transaction_id',
            'amount',
            //'state',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, GameDisbursement $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
