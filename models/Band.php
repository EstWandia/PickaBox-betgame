<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "band".
 *
 * @property string $id
 * @property float $band_amount
 * @property float $possible_win
 * @property float $rtp
 * @property float $retainer
 * @property int|null $position
 * @property int|null $correct_position
 * @property float $retainer_percentage
 * @property float $rtp_percentage
 * @property float $stake_tax
 * @property float $win_tax
 * @property string $updated_at
 */
class Band extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'band';
    }

    public static function getDb() {
        return Yii::$app->sms_db;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'retainer_percentage', 'rtp_percentage', 'updated_at'], 'required'],
            [['band_amount', 'possible_win', 'rtp', 'retainer', 'retainer_percentage', 'rtp_percentage', 'stake_tax', 'win_tax'], 'number'],
            [['position', 'correct_position'], 'integer'],
            [['updated_at'], 'safe'],
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
            'band_amount' => 'Band Amount',
            'possible_win' => 'Possible Win',
            'rtp' => 'Rtp',
            'retainer' => 'Retainer',
            'position' => 'Position',
            'correct_position' => 'Correct Position',
            'retainer_percentage' => 'Retainer Percentage',
            'rtp_percentage' => 'Rtp Percentage',
            'stake_tax' => 'Stake Tax',
            'win_tax' => 'Win Tax',
            'updated_at' => 'Updated At',
        ];
    }

}
