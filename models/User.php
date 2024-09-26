<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }
    public function rules()
    {
      
        return [
            [['sender_name','password','temp_password'], 'string'],
            [['created_date', 'modified_date'], 'safe'],
            [['is_deleted','perm_group','defaultpermissiondenied','extpermission','created_by'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['api_token'], 'text'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password ===password_hash($password, PASSWORD_DEFAULT);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
        /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
            'is_deleted' => 'Is Deleted',
            'perm_group' => 'perm_group',
            'defaultpermissiondenied' => 'defaultpermissiondenied',
            'extpermission' => 'extpermission',
            'temp_password' => 'temp_password',
            'api_token' => 'api_token',
        ];
    }
}
