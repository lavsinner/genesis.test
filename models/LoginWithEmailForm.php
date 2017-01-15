<?php

namespace app\models;

use app\helpers\MailHelper;
use yii\base\Model;

/**
 * Password reset request form
 */
class LoginWithEmailForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email']
        ];
    }

    public function sendEmail()
    {
        return MailHelper::sendEmailWithToken($this->email);
    }

    public function getOrCreateUser()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findByEmail($this->email);

        if (!$user) {
            $user = new User();
            $user->email = $this->email;
        }

        return $user->save() ? $user : null;
    }
}
