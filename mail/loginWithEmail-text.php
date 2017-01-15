<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

$loginLink = Yii::$app->urlManager->createAbsoluteUrl(['site/login-with-email', 'token' => $user->login_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to login:

<?= $loginLink ?>
