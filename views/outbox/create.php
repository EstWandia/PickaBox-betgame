<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Outbox $model */

$this->title = 'Create Outbox';
$this->params['breadcrumbs'][] = ['label' => 'Outboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outbox-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
