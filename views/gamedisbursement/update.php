<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GameDisbursement $model */

$this->title = 'Update Game Disbursement: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-disbursement-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>