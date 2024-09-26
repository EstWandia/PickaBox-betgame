<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inbox */

$this->title = 'Create Inbox';
$this->params['breadcrumbs'][] = ['label' => 'Inboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inbox-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
