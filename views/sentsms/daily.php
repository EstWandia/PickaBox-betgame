<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'DAILY SENT SMS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sent-sms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Sent Sms', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>DATE</th>
                <th>TOTAL</th>
                <th>DLR</th>
                <th>SENDER</th>
            </tr>
        <thead>
        <tbody>
            <?php
                $total_sum = 0;
                foreach($data as $row ){
                    $total_sum += $row['total'];    
            ?>
            <tr>
                <td><?php echo $row['day_total']?></td>
                <td><?php echo $row['total'] ?></td>
                <td><?php echo $row['dlr'] ?></td>
                <td><?php echo $row['sender'] ?></td>
            </tr>
            <?php } ?>
            <tr>
                <td><strong><strong>TOTAL : <?php echo $total_sum;  ?> </strong></strong></td> 
            </tr>
        </tbody>
    </table>


</div>
