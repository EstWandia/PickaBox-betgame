<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

        <?php $form = ActiveForm::begin(['options' => ['class' => 'user','enctype' => 'multipart/form-data']]); ?>
        <?= $form->field($model, 'username')->textInput(['class' => 'form-control form-control-user','autofocus' => true,'required' => true, 'placeholder' => 'Username'])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-user','required' => true, 'placeholder' => "Password"])->label(false) ?>
        <?= $form->field($model, 'rememberMe')->checkbox(); ?>
        <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
                                    <hr>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>