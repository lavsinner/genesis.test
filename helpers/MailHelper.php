<?php

namespace app\helpers;

use app\models\User;
use Yii;

class MailHelper
{
    protected static $typeTemplateMapping = [
        'login_with_email' => ['html' => 'loginWithEmail-html', 'text' => 'loginWithEmail-text'],
    ];

    /**
     * Sends an email with a link.
     *
     * @param string $email;
     * @param string $type;
     *
     * @return bool whether the email was send
     */
    public static function sendEmailWithToken($email, $type = 'login_with_email')
    {
        /* @var $user User */
        $user = User::findOne([
            'email' => $email,
        ]);

        if (!$user) {
            return false;
        }

        if (!User::isTokenValid(User::getFieldByTokenType($type))) {
            $user->generateToken($type);
            if (!$user->save()) {
                return false;
            }
        }

        return Yii::$app
            ->mailer
            ->compose(
                static::$typeTemplateMapping[$type],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($email)
            ->setSubject('Message from ' . Yii::$app->name)
            ->send();
    }
}
