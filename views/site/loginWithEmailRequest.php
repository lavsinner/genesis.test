<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginWithEmailForm */
$this->title = 'Request login link';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')):?>
        <div class="col-md-12 alert-success">
            <h2><?= Yii::$app->session->getFlash('success');?></h2>
        </div>
    <?php endif;?>

    <?php if (Yii::$app->session->hasFlash('error')):?>
        <div class="col-md-12 alert-danger">
            <h2><?= Yii::$app->session->getFlash('error');?></h2>
        </div>
    <?php endif;?>

    <p>Please fill out your email. A link to login will be sent there.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login_with_email_form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
