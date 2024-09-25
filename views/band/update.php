<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Band $model */

$this->title = 'Update Band: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bands', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="band-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
