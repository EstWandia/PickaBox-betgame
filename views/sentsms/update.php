<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SentSms */

$this->title = 'Update Sent Sms: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Sent Sms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sent-sms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
