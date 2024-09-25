<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GameTransactionLogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="game-transaction-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
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
