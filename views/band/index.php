<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="band-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Band', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'band_amount',
            'possible_win',
            'rtp',
            'retainer',
            //'position',
            //'correct_position',
            //'retainer_percentage',
            //'rtp_percentage',
            //'stake_tax',
            //'win_tax',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
