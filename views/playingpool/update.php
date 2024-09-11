<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PlayingPool $model */

$this->title = 'Update Playing Pool: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Playing Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="playing-pool-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>