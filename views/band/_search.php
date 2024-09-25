<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BandSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="band-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'band_amount') ?>

    <?= $form->field($model, 'possible_win') ?>

    <?= $form->field($model, 'rtp') ?>

    <?= $form->field($model, 'retainer') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'correct_position') ?>

    <?php // echo $form->field($model, 'retainer_percentage') ?>

    <?php // echo $form->field($model, 'rtp_percentage') ?>

    <?php // echo $form->field($model, 'stake_tax') ?>

    <?php // echo $form->field($model, 'win_tax') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
