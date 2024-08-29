<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MpesaPayments $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mpesa Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mpesa-payments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'TransID',
            'FirstName',
            'MiddleName',
            'LastName',
            'MSISDN',
            'InvoiceNumber',
            'BusinessShortCode',
            'ThirdPartyTransID',
            'TransactionType',
            'OrgAccountBalance',
            'BillRefNumber',
            'TransAmount',
            'is_archived',
            'created_at',
            'updated_at',
            'deleted_at',
            'state',
            'station_id',
            'operator',
            'tickets',
            'moved',
        ],
    ]) ?>

</div>
