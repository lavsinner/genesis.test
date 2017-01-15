<?php
namespace app\models;

use yii\base\Model;

/**
 * Auth form
 */
class AuthForm extends Model
{
    public $username;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Auth user up.
     *
     * @param integer $id
     * @return User|null the saved model or null if saving fails
     */
    public function auth($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findIdentity($id);

        if (!$user) {
            $user = new User();
            $user->email = $this->email;
        }

        $user->status = User::STATUS_ACTIVE;
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
