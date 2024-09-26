<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GameTransactionLog */

$this->title = 'Create Game Transaction Log';
$this->params['breadcrumbs'][] = ['label' => 'Game Transaction Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-transaction-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
