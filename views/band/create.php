<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Band */

$this->title = 'Create Band';
$this->params['breadcrumbs'][] = ['label' => 'Bands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="band-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
