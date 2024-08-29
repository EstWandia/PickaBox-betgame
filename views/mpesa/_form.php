<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MpesaPayments $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mpesa-payments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSISDN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'InvoiceNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BusinessShortCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ThirdPartyTransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransactionType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OrgAccountBalance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BillRefNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_archived')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'deleted_at')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'state')->textInput() ?>

    <?= $form->field($model, 'station_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tickets')->textInput() ?>

    <?= $form->field($model, 'moved')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
