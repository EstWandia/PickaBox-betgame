<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GameTransactionLog $model */

$this->title = 'Update Game Transaction Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Transaction Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-transaction-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
