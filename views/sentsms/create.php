<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SentSms */

$this->title = 'Create Sent Sms';
$this->params['breadcrumbs'][] = ['label' => 'Sent Sms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
