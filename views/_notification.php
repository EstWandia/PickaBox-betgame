<?php
if (Yii::$app->session->hasFlash('error')) {
    ?>
    <div class="alert alert-danger"><?= Yii::$app->session->get('error'); ?></div>
    <?php
    Yii::$app->session->remove('error');
}

if (Yii::$app->session->hasFlash('success')) {
    ?>
    <div class="alert alert-success"><?= Yii::$app->session->get('success'); ?></div>
    <?php
    Yii::$app->session->remove('success');
} ?>