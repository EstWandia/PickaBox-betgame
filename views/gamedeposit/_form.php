<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GameDeposit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-deposit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FirstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MiddleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'MSISDN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BusinessShortCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ThirdPartyTransID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OrgAccountBalance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TransAmount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
