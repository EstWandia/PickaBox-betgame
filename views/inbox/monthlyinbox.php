<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SentSmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MONTHLY INBOX SMS';
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
                <th>TOTAL</th>
                <th>MONTH TOTAL</th>
            </tr>
        <thead>
        <tbody>
            <?php
                $total_sum = 0;
                foreach($data as $row ){  
                    $total_sum += $row['total']; 
            ?>
            <tr>
                <td><?php echo $row['total'] ?></td>
                <td><?php echo $row['month_total']?></td>
            </tr>
        
            <?php } ?>
            <tr>
                <td><b><b>TOTAL : <?php echo $total_sum;  ?> </b></b></</td> 
            </tr>
        </tbody>
    </table>


</div>
