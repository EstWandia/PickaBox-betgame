<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ussd $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ussd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msisdn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'transaction_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
