<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GameDisbursement */

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
