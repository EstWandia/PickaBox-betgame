<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GameDeposit */

$this->title = 'Create Game Deposit';
$this->params['breadcrumbs'][] = ['label' => 'Game Deposits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-deposit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
