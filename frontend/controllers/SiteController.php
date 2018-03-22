<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Slider;
use common\models\AppData;
use common\models\ProductMake;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\authclient\OAuth2;
use common\models\Product;
use common\models\Page;
use common\models\MainPage;
use common\models\Teaser;
use common\models\Parsernews;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'index';
    public $bodyClass;
    private $source;
    private $source_id;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
                'minLength' => 3,
                'maxLength' => 4,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Url::remember('/account/index', 'previous');

        return parent::beforeAction($action);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $responseGet = Yii::$app->request->get();
        if (!empty($responseGet)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: https://" . $_SERVER['HTTP_HOST']);
            die();
        }

        if (Yii::$app->cache->exists('main_page')) {
            $this->bodyClass = 'main-page';

            return $this->render('index');
        } else {

            $latestAutosCompany = Product::find()->highPriority()->active()->orderBy('product.updated_at DESC')->limit(8)->all();
            $latestAutosPrivate = Product::find()->lowPriority()->active()->orderBy('product.updated_at DESC')->limit(8)->all();
            $latestNews = Page::find()->active()->news()->limit(5)->orderBy('id desc')->all();
            $mainNews = $latestNews[0];
            $teasers = Teaser::find()->active()->orderBy('lft')->all();
            $appData = AppData::getData();
            $topMakers = ProductMake::find()->top()->limit(8)->all();
            $mainPageData = MainPage::getData();
            $sliders = Slider::find()->orderBy('lft')->published()->all();
            $this->bodyClass = 'main-page';

            return $this->render('index', [
                'sliders' => $sliders,
                'latestAutosCompany' => $latestAutosCompany,
                'latestAutosPrivate' => $latestAutosPrivate,
                'mainNews' => $mainNews,
                'teasers' => $teasers,
                'appData' => $appData,
                'topMakers' => $topMakers,
                'mainPageData' => $mainPageData,
            ]);
        }
    }

    /**
     * Render partial product list view.
     *
     * @param integer $make
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionProductlist($make)
    {
        $currentMaker = ProductMake::find()->where('id=:id', [':id' => $make])->one();
        if ($currentMaker === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return Yii::$app->controller->renderPartial('_productList', [
            'currentMaker' => $currentMaker
        ]);
    }

    /**
     * Render brand view.
     *
     * @param integer $make
     * @throws NotFoundHttpException
     * @return mixed
     */
    public function actionBrand($make)
    {
        $currentMaker = ProductMake::find()->where('id=:id', [':id' => $make])->one();
        if ($currentMaker === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return Yii::$app->controller->renderPartial('_productList', [
            'currentMaker' => $currentMaker
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->returnUrl);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $urlAccount = Url::previous('previous');
            $urlForCatalog =  Url::previous('forCatalog');
            if (!empty($urlForCatalog)) {
                return $this->redirect($urlForCatalog);
            } else {
                return $this->redirect($urlAccount);
            }

        } else {
            $this->bodyClass = 'login-page';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->user->returnUrl);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(AppData::getData()['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Thank you for contacting us. We will respond to you as soon as possible'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'There was an error sending email'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->render('aftersignup', [
                        'model' => $model,
                    ]);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Confirm registration
     *
     * @throws NotFoundHttpException
     * @throws BadRequestHttpException
     * @return mixed
     */
    public function actionConfirm($key)
    {
        $model = User::find()->where('confirm_key=:confirm_key', [':confirm_key' => $key])->one();
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($model->confirm($key)) {
            return $this->render('afterconfirm', [
                'model' => $model,
            ]);
        }
        throw new BadRequestHttpException('Error during user confirmation');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                //return $this->goHome();
                return $this->render('requestPasswordResetEmailSent', [
                    'model' => $model,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /*
     * VK Oauth
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        $this->source_id = $attributes['id'];
        $this->source = $client->getId();

        /* @var $auth Auth */
        switch ($client->getId()) {
            case 'facebook':
                $auth = User::find()->where([
                    'email' => $attributes['email']
                ])->one();
                break;
            case 'vkontakte':
                $auth = User::find()->where([
                    'source' => $this->source,
                    'source_id' => $this->source_id,
                ])->one();
                break;
            case 'google':
                $auth = User::find()->where([
                    'source' => $this->source,
                    'source_id' => $this->source_id,
                ])->one();
                break;
            case 'yandex':
                $auth = User::find()->where([
                    'source' => $this->source,
                    'source_id' => $this->source_id,
                ])->one();
                break;
            case 'odnoklassniki':
                $auth = User::find()->where([
                    'source' => $this->source,
                    'source_id' => $this->source_id,
                ])->one();
                break;
        }

        if (Yii::$app->user->isGuest) {

            /*
             * Авторизация
             */
            if ($auth) {
                if (Yii::$app->user->login($auth)) {
                    $urlAccount = Url::previous('previous');
                    $urlForCatalog =  Url::previous('forCatalog');

                    if (!empty($urlForCatalog)) {
                        return $this->redirect($urlForCatalog);
                    } else {
                        return $this->redirect($urlAccount);
                    }
                }
            } /*
             * Регистрация
             */
            else {
                $password = Yii::$app->security->generateRandomString(6);
                $password_hash = Yii::$app->security->generatePasswordHash($password);
                switch ($client->getId()) {
                    case 'facebook':
                        $username = $attributes['name'];
                        $name = explode(" ", $username);
                        $first_name = $name[0];
                        $last_name = $name[1];
                        $email = $attributes['email'];
                        break;
                    case 'vkontakte':
                        $email = $attributes['domain'] . '@vk.com';
                        $first_name = (string)$attributes['first_name'];
                        $last_name = (string)$attributes['last_name'];
                        $username = $attributes['domain'];
                        break;
                    case 'google':
                        $email = $attributes['emails'][0]['value'];
                        $last_name = $attributes['name']['familyName'];
                        $first_name = $attributes['name']['givenName'];
                        $username = $first_name . ' ' . $last_name;
                        break;
                    case 'yandex':
                        $email = $attributes['default_email'];
                        $last_name = $attributes['last_name'];
                        $first_name = $attributes['first_name'];
                        $username = $attributes['display_name'];
                        break;
                    case 'odnoklassniki':
                        $email = $this->source_id . '@ok.ru';
                        $last_name = $attributes['last_name'];
                        $first_name = $attributes['first_name'];
                        $username = $first_name . ' ' . $last_name;
                        break;
                }

                $user = new User([
                    'username' => $username,
                    'email' => $email,
                    'password_hash' => $password_hash,
                    'source' => $this->source,
                    'source_id' => $this->source_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                ]);
                $user->generateAuthKey();
                $user->generatePasswordResetToken();
                $user->setScenario(User::SCENARIO_SIGN_IN_SOCIAL);
                $transaction = $user->getDb()->beginTransaction();

                if ($user->save()) {
                    $transaction->commit();
                    $auth = Yii::$app->authManager;
                    $role = $auth->getRole('Registered');
                    $auth->assign($role, $user->id);
                    Yii::$app->user->login($user);

                    $urlAccount = Url::previous('previous');
                    $urlForCatalog =  Url::previous('forCatalog');
                    if (!empty($urlForCatalog)) {
                        return $this->redirect($urlForCatalog);
                    }
                    else {
                        return $this->redirect($urlAccount);
                    }
                }
                else {
                    print_r($user->getErrors());

                }
            }
        }
    }
}
