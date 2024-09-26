<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GameDepositSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Game Deposits';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-deposit-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php #Html::a('Create Game Deposit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
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
            //'state',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
