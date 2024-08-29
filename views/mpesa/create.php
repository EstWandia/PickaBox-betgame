<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MpesaPayments $model */

$this->title = 'Create Mpesa Payments';
$this->params['breadcrumbs'][] = ['label' => 'Mpesa Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mpesa-payments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
