<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GameDeposit */

$this->title = 'Update Game Deposit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Deposits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-deposit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
