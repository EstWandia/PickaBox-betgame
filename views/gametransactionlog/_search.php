<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GameTransactionLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-transaction-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'json_data') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'api_type') ?>

    <?= $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'transID') ?>

    <?php // echo $form->field($model, 'CheckoutRequestID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
