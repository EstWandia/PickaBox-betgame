<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ussd $model */

$this->title = 'Create Ussd';
$this->params['breadcrumbs'][] = ['label' => 'Ussds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ussd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
