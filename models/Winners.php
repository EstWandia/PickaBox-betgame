<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "winning_table".
 *
 * @property string $id
 * @property string $transid
 * @property string $name
 * @property string $phone_number
 * @property string $game
 * @property float $amount
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $deleted_at
 */
class Winners extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'winning';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'transid', 'name', 'phone_number', 'game', 'amount'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['transid', 'name', 'phone_number', 'game'], 'string', 'max' => 255],
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
            'transid' => 'Transid',
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'game' => 'Game',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }
}
