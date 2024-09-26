<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'choice') ?>

    <?= $form->field($model, 'band_id') ?>

    <?= $form->field($model, 'msisdn') ?>

    <?= $form->field($model, 'stake') ?>

    <?php // echo $form->field($model, 'net_stake') ?>

    <?php // echo $form->field($model, 'net_win') ?>

    <?php // echo $form->field($model, 'win_tax') ?>

    <?php // echo $form->field($model, 'stake_tax') ?>

    <?php // echo $form->field($model, 'rtp') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
