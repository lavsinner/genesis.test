<?php

/* @var $user \app\models\User */
/* @var $userData \app\models\UserData */
/* @var $avatar \app\models\Image */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data'
    ],
]) ?>
    <div class="form-group">
        <div class="col-md-12">
            <div class="col-md-4">
                <img class="col-md-12" src="<?= \app\models\Image::getAvatar($user->avatar ? $user->avatar->path : null)?>">
                <div class="col-md-offset-3"><?= $form->field($avatar, 'avatar')->fileInput()?></div>
            </div>
            <div class="col-md-8">
                <?= $form->field($userData, 'name') ?>
                <?= $form->field($userData, 'surname') ?>
                <?= $form->field($userData, 'mobile') ?>
                <?= $form->field($userData, 'address') ?>
            </div>
        </div>
        <div class="col-lg-offset-11 col-lg-1">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>