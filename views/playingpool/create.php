<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PlayingPool $model */

$this->title = 'Create Playing Pool';
$this->params['breadcrumbs'][] = ['label' => 'Playing Pools', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="playing-pool-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
