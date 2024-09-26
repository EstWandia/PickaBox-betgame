<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Band */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="band-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'band_amount')->textInput() ?>

    <?= $form->field($model, 'possible_win')->textInput() ?>

    <?= $form->field($model, 'rtp')->textInput() ?>

    <?= $form->field($model, 'retainer')->textInput() ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'correct_position')->textInput() ?>

    <?= $form->field($model, 'retainer_percentage')->textInput() ?>

    <?= $form->field($model, 'rtp_percentage')->textInput() ?>

    <?= $form->field($model, 'stake_tax')->textInput() ?>

    <?= $form->field($model, 'win_tax')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
