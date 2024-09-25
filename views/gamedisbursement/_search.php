<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GameDisbursementSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="game-disbursement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bet_id') ?>

    <?= $form->field($model, 'msisdn') ?>

    <?= $form->field($model, 'transaction_id') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
