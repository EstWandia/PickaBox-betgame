<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outbox".
 *
 * @property string $id
 * @property int|null $status
 * @property string|null $message
 * @property string|null $category
 * @property string|null $created_at
 */
class Outbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'outbox';
    }

    public static function getDb()
    {
        return Yii::$app->sms_db;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['created_at'], 'integer'],
            [['id','type'], 'safe'],
            [['message','type'], 'string'],
            [['id'], 'string', 'max' => 36],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state' => 'State',
            'message' => 'Message',
            'category' => 'Category',
            'created_at' =>'Created At'
        ];
    }
}
