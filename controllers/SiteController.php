<?php

namespace app\controllers;

use app\models\AuthForm;
use app\models\LoginWithEmailForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'login-with-email-request'],
                'rules' => [
                    [
                        'actions' => ['login-with-email-request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login-with-email-request']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/user/view', 'id' => $model->getUser()->getId()]);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLoginWithEmailRequest()
    {
        $model = new LoginWithEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->getOrCreateUser() && $model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to send login link for email provided.');
            }
        }

        return $this->render('loginWithEmailRequest', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return \yii\web\Response
     */
    public function actionLoginWithEmail($token)
    {
        $user = User::findByLoginToken($token);
        if ($user && ($user->status === User::STATUS_ACTIVE)) {
            $user->removeToken('login_with_email');
            $user->save();
            Yii::$app->user->login($user, 3600 * 24 * 30);
            return $this->redirect(['/user/view', 'id' => $user->getId()]);
        }

        return $this->redirect(['/site/auth', 'id' => $user->getId()]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAuth($id)
    {
        $model = new AuthForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->auth($id)) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(['/user/view', 'id' => $user->getId()]);
                }
            }
        }

        return $this->render('auth', [
            'model' => $model,
        ]);
    }
}
