<?php

namespace app\models;

use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "bet".
 *
 * @property string $id
 * @property string $choice
 * @property string $band_id
 * @property string $msisdn
 * @property float $stake
 * @property float $net_stake
 * @property float $net_win
 * @property float $win_tax
 * @property float $stake_tax
 * @property float $rtp
 * @property string $created_at
 */
class Bet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'choice', 'band_id'], 'required'],
            [['choice'], 'string'],
            [['stake', 'net_stake', 'net_win', 'win_tax', 'stake_tax', 'rtp'], 'number'],
            [['created_at'], 'safe'],
            [['id', 'band_id'], 'string', 'max' => 36],
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
            'choice' => 'Choice',
            'band_id' => 'Band ID',
            'stake' => 'Stake',
            'net_stake' => 'Net Stake',
            'net_win' => 'Net Win',
            'win_tax' => 'Win Tax',
            'stake_tax' => 'Stake Tax',
            'rtp' => 'Rtp',
            'created_at' => 'Created At',
        ];
    }

    public static function getBetCount()
    {
        return Bet::find()->count();
    }


}