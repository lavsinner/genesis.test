<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl(['site/login-with-email', 'token' => $user->login_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to login:</p>

    <p><?= Html::a(Html::encode($loginLink), $loginLink) ?></p>
</div>
