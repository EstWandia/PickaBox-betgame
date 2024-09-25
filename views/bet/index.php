<?php

use app\models\Bet;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\BetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php #Html::a('Create Bet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'choice',
            'band_id',
            'msisdn',
            'stake',
            //'net_stake',
            //'net_win',
            //'win_tax',
            //'stake_tax',
            'rtp',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Bet $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
