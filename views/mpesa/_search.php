<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpesaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mpesa-payments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'TransID') ?>

    <?= $form->field($model, 'FirstName') ?>

    <?= $form->field($model, 'MiddleName') ?>

    <?= $form->field($model, 'LastName') ?>

    <?php // echo $form->field($model, 'MSISDN') ?>

    <?php // echo $form->field($model, 'InvoiceNumber') ?>

    <?php // echo $form->field($model, 'BusinessShortCode') ?>

    <?php // echo $form->field($model, 'ThirdPartyTransID') ?>

    <?php // echo $form->field($model, 'TransactionType') ?>

    <?php // echo $form->field($model, 'OrgAccountBalance') ?>

    <?php // echo $form->field($model, 'BillRefNumber') ?>

    <?php // echo $form->field($model, 'TransAmount') ?>

    <?php // echo $form->field($model, 'is_archived') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'station_id') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'tickets') ?>

    <?php // echo $form->field($model, 'moved') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
