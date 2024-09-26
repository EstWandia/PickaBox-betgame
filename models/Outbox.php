<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "outbox".
 *
 * @property string $id
 * @property string|null $receiver
 * @property string|null $message
 * @property string $created_at
 * @property int|null $status
 * @property string|null $category
 * @property string|null $sender
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['message'], 'string'],
            [['created_at'], 'safe'],
            [['status'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['receiver', 'sender'], 'string', 'max' => 20],
            [['category'], 'string', 'max' => 50],
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
            'receiver' => 'Receiver',
            'message' => 'Message',
            'created_at' => 'Created At',
            'status' => 'Status',
            'category' => 'Category',
            'sender' => 'Sender',
        ];
    }
}
