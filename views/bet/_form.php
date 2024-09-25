<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Bet $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'choice')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'band_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stake')->textInput() ?>

    <?= $form->field($model, 'net_stake')->textInput() ?>

    <?= $form->field($model, 'net_win')->textInput() ?>

    <?= $form->field($model, 'win_tax')->textInput() ?>

    <?= $form->field($model, 'stake_tax')->textInput() ?>

    <?= $form->field($model, 'rtp')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
