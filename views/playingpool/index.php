<?php

use app\models\PlayingPool;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Playing Pools';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playing-pool-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Playing Pool', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'transid',
            'name',
            'msisdn',
            'reference',
            'amount',
            'created_at',
            //'updated_at',
            //'state',
            //'deleted_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, PlayingPool $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
