<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpesaPayments $model */

$this->title = 'Update Mpesa Payments: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mpesa Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mpesa-payments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
