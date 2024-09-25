<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GameDisbursement $model */

$this->title = 'Create Game Disbursement';
$this->params['breadcrumbs'][] = ['label' => 'Game Disbursements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-disbursement-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
