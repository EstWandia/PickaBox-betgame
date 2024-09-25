<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bet $model */

$this->title = 'Update Bet: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
