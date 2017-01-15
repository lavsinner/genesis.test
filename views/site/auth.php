<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\AuthForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Auth';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-auth">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to auth:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-auth']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Auth', ['class' => 'btn btn-primary', 'name' => 'auth-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
