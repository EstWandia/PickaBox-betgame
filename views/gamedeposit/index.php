<?php

use app\models\GameDeposit;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\GameDepositSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Game Deposits';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-deposit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php # Html::a('Create Game Deposit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'TransID',
            // 'FirstName',
            // 'MiddleName',
            // 'LastName',
            'MSISDN',
            'BusinessShortCode',
            'ThirdPartyTransID',
            //'OrgAccountBalance',
            'TransAmount',
            //'is_archived',
            'created_at',
            //'updated_at',
            //'deleted_at',
            'state',
            // [
            //     // 'class' => ActionColumn::className(),
            //     // 'urlCreator' => function ($action, GameDeposit $model, $key, $index, $column) {
            //     //     return Url::toRoute([$action, 'id' => $model->id]);
            //     //  }
            // ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
