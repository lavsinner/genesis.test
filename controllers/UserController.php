<?php

namespace app\controllers;

use app\helpers\FileHelper;
use app\models\Image;
use app\models\User;
use app\models\UserData;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if (\Yii::$app->user->getId() !== (int) $id) {
            $this->redirect(['/user/view', 'id' => \Yii::$app->user->getId()]);
        }
        $user = User::findIdentity($id);
        if (!$user) {
            throw new NotFoundHttpException('User with id ' . $id . ' not found');
        }
        $userData = $user->userData ?: new UserData();
        $avatar = $user->avatar ?: new Image();

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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $user = User::findIdentity($id);
        if (!$user) {
            throw new NotFoundHttpException('User with id ' . $id . ' not found');
        }
        return $this->render('view', ['user' => $user]);
    }

}
