<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\ForbiddenHttpException;
use yii\helpers\Url;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $patronymic
 * @property string $last_visit
 * @property string $confirm_key
 * @property string $phone
 * @property string $phone_2
 * @property string $city
 * @property string $address
 * @property integer $phone_provider
 * @property integer $phone_provider_2
 * @property integer $region
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_SIGN_UP = 'sign_up';
    const SCENARIO_SIGN_IN = 'sign_in';
    const SCENARIO_SIGN_IN_SOCIAL = 'sign_in_social';
    const SCENARIO_SELLER_CONTACTS = 'sellerContacts';

    const PHONE_PROVIDER_VELC = 1;
    const PHONE_PROVIDER_MTS = 2;
    const PHONE_PROVIDER_LIFE = 3;
    const PHONE_PROVIDER_CITY = 4;

    public $password_raw;
    public $password_repeat;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'phone'], 'required', 'on' => 'sellerContacts'],
            [['username', 'email', 'password_reset_token'], 'unique'],
            [['email'], 'safe', 'on' => self::SCENARIO_SIGN_IN_SOCIAL],
            [['source_id'], 'unique', 'on' => self::SCENARIO_SIGN_IN_SOCIAL],
            [['source_id'], 'required', 'on' => self::SCENARIO_SIGN_IN_SOCIAL],
            [['phone_provider', 'region', 'phone_provider_2'], 'integer'],
            [['username', 'email'], 'required'],
            ['password_hash', 'required', 'when' => function ($model) {
                return !$model->isNewRecord && trim($model->password_repeat) === '' && trim($model->password_raw) === '';
            }],
            ['email', 'email'],
            [['username', 'phone', 'address', 'city', 'phone_2'], 'trim'],
            [['source'], 'safe'],
            ['password_raw', 'required', 'when' => function ($model) {
                return trim($model->password_repeat) !== '' || trim($model->password_hash) === '';
            }],
            ['password_repeat', 'required', 'when' => function ($model) {
                return trim($model->password_raw) !== '' || trim($model->password_hash) === '';
            }],
            ['password_raw', 'string', 'length' => [5, 64]],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_raw'/*, 'message'=>"Passwords are not matching"*/],
            ['username', 'string', 'length' => [4, 64]],
            [['first_name', 'last_name', 'middle_name', 'patronymic'], 'string', 'max' => 256],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * Returns a list of scenarios and the corresponding active attributes.
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_SELLER_CONTACTS => [
                'first_name',
                'phone_provider_2',
                'phone_2',
                'phone_provider',
                'phone',
                'last_name',
                'city',
                'region',
            ],
            self::SCENARIO_DEFAULT => [
                'username',
                'email',
                'password_raw',
                'password_repeat',
                'first_name',
                'last_name',
                'middle_name',
                'phone_provider_2',
                'phone_2',
                'phone_provider',
                'phone',
                'patronymic',
                '!created_at',
                '!updated_at',
                '!status',
                '!auth_key',
                '!password_hash',
                '!password_reset_token',
                '!last_visit',
            ],
            self::SCENARIO_SIGN_IN_SOCIAL => [
                'username',
                'source',
                'source_id',
                'email',
                'password_hash',
                'first_name',
                'last_name'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'usernameEmail' => 'Имя пользователя или e-mail',
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'patronymic' => Yii::t('app', 'Patronymic'),
            'last_visit' => Yii::t('app', 'Last Visit'),
            'password_raw' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Password Repeat'),
            'city' => Yii::t('app', 'City'),
            'region' => Yii::t('app', 'Region'),
            'phone' => Yii::t('app', 'Phone'),
            'phone_2' => Yii::t('app', 'Additional phone'),
            'phone_provider' => Yii::t('app', 'Provider'),
            'phone_provider_2' => Yii::t('app', 'Provider'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $identity
     * @return static|null
     */
    public static function findByUsernameOrEmail($identity)
    {
        /**
         * Try to find identity by nickname
         * @var User $user
         */
        if ($user = static::findOne(['username' => $identity, 'status' => self::STATUS_ACTIVE])) {
            return $user;
        }

        /**
         * Try to find identity by email
         * @var LoginAccount $loginAccount
         */
        if ($user = static::findOne(['email' => $identity, 'status' => self::STATUS_ACTIVE])) {
            return $user;
        }

        return null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Confirm user
     * @param $key
     * @return bool
     */
    public function confirm($key)
    {
        if (!$this->isNewRecord && $this->confirm_key === $key) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole('Registered');
            $this->confirm_key = '';
            $this->save();
            $auth->assign($role, $this->id);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Update last_visit value to current time
     */
    public function updateLastVisitTime()
    {
        $this->touch('last_visit');
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (trim($this->password_raw) !== '') {
                $this->setPassword($this->password_raw);
            }
            if ($this->isNewRecord) {
                $this->generateAuthKey();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param \yii\web\User $user user application component instance
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    public function denyAccess(\yii\web\User $user = null)
    {
        if ($user === null) {
            $user = Yii::$app->user;
        }

        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    public function getPhoneProviderName()
    {
        if (!is_numeric($this->phone_provider)) {
            return '';
        } else {
            return self::getPhoneProviders()[$this->phone_provider];
        }
    }

    public function getPhoneProvider2Name()
    {
        if (!is_numeric($this->phone_provider)) {
            return '';
        } else {
            return self::getPhoneProviders()[$this->phone_provider];
        }
    }

    /**
     * @return array
     */
    public static function getPhoneProviders()
    {
        return [
            self::PHONE_PROVIDER_VELC => 'Velcom',
            self::PHONE_PROVIDER_MTS => 'MTS',
            self::PHONE_PROVIDER_LIFE => 'Life',
            self::PHONE_PROVIDER_CITY => 'Городской',
        ];
    }


    /**
     * @return array
     */
    public static function getPhoneProviderIcons()
    {
        return [
            self::PHONE_PROVIDER_VELC => '/theme/images/elements/velcom-icon.png',
            self::PHONE_PROVIDER_MTS => '/theme/images/elements/mts-icon.png',
            self::PHONE_PROVIDER_LIFE => '/theme/images/elements/life-icon.png',
        ];
    }

    /**
     * @return array
     */
    public static function getRegions()
    {
        return [
            1 => Yii::t('app', 'Minsk'),
            2 => Yii::t('app', 'Minsk Region'),
            3 => Yii::t('app', 'Gomel Region'),
            4 => Yii::t('app', 'Mogilev Region'),
            5 => Yii::t('app', 'Vitebsk Region'),
            6 => Yii::t('app', 'Grodno Region'),
            7 => Yii::t('app', 'Brest Region'),
        ];
    }
}
