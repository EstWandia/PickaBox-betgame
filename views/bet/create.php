<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Bet $model */

$this->title = 'Create Bet';
$this->params['breadcrumbs'][] = ['label' => 'Bets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
