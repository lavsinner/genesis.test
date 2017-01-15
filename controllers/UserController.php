<?php

namespace app\controllers;

use app\helpers\FileHelper;
use app\models\Image;
use app\models\User;
use app\models\UserData;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class UserController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update', 'view'],
                'rules' => [
                    [
                        'actions' => ['update', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update' => ['post', 'get'],
                    'view' => ['get']
                ],
            ],
        ];
    }

    public function actionUpdate($id)
    {
        $user = User::findIdentity($id);
        $userData = $user->userData;
        $avatar = $user->avatar;
        if (!$userData) {
            $userData = new UserData();
        }
        if (!$avatar) {
            $avatar = new Image();
        }

        if (\Yii::$app->request->post('UserData')) {
            $userData->load(\Yii::$app->request->post());
            $userData->link('user', $user);
        }

        if (\Yii::$app->request->post('Image')) {
            $avatar->avatar = UploadedFile::getInstance($avatar, 'avatar');
            if (is_object($avatar->avatar)) {
                $avatar->path = 'uploads/'.$avatar->avatar->name;
                $avatar->name = $avatar->avatar->name;
                $avatar->type = Image::TYPE_AVATAR;
                if ($avatar->upload()) {
                    $avatar->link('uploadedBy', $user);
                }
            }
        }
        return $this->render('update', ['user' => $user, 'userData' => $userData, 'avatar' => $avatar]);
    }

    public function actionView($id)
    {
        $user = User::findIdentity($id);
        return $this->render('view', ['user' => $user]);
    }

}
