<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactional Sms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-transactional">
    <div class="panel panel-info">
        <div class="panel-heading"> Filters</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->renderFile('@app/views/layouts/partials/_datetimesec_filter_.php', [
                        'data' => [],
                        'url'  => '/sentsms/transactional',
                        'from' => date( 'Y-m-d H:i:s', strtotime( '-5 hours' ) )
                    ])?>
                </div>
            </div>
            <div class="row">
                <?= $this->render('//_notification'); ?>  
            </div>
        </div>
    </div>


    <?php
    $gridColumns = [['class' => 'yii\grid\SerialColumn'],

            'id',
            'receiver',
            'sender',
            'message:ntext',
            'dlr',
            'created_date',
            //'category',

           // ['class' => 'yii\grid\ActionColumn'],
        ];
        echo \kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'autoXlFormat'=>true,
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'export'=>[
                'showConfirmAlert'=>false,
                'target'=> \kartik\grid\GridView::TARGET_BLANK
            ],
            'columns' => $gridColumns,
            'pjax'=>true,
        'showPageSummary'=>true,
        'toolbar' => [
            '{toggleData}',
                    '{export}',
        ],
        'panel'=>[
            'type'=>'default',
            'heading'=>' transactional sentsms'
        ]
    ]); ?>
</div>