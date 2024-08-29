<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ussd $model */

$this->title = 'Update Ussd: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ussds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ussd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
