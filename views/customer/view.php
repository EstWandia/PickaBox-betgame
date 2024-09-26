<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customer */

$this->title = $model->msisdn;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="customer-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'msisdn',
            'station_code',
            'created_at',
        ],
    ]) ?>

</div>
