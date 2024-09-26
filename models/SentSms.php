<?php

namespace app\models;
use app\components\Myhelper;
use Yii;



/**
 * This is the model class for table "sent_sms".
 *
 * @property int $id
 * @property string|null $receiver
 * @property string|null $sender
 * @property string|null $message
 * @property string $created_date
 * @property int $category
 * 
 */
class SentSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sent_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message','link_id','dlr'], 'string'],
            [['created_date'], 'safe'],
            [['user_id'], 'integer'],
            [['receiver', 'sender','category'], 'string', 'max' => 20],
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
            'sender' => 'Sender',
            'message' => 'Message',
            'dlr' => 'DLR',
            'created_date' => 'Created Date',
            'category' => 'Category',
        ];
    }
    public static function getSentsmsCount()
    {
        return SentSms::find()->count();
    }
   
    public function getDailySms(){
        //COALESCE(SUM(CEIL(CHARACTER_LENGTH(message)/160)),0) AS total
        $query = 'SELECT COUNT(receiver) as total,
        DATE_FORMAT(created_date,"%Y-%m-%d") AS day_total,dlr,sender 
        FROM sent_sms GROUP BY day_total,dlr,sender ORDER BY day_total DESC';

        return Myhelper::getAll($query);
    }

    public function getMonthlySentSms(){
        //COALESCE(SUM(CEIL(CHARACTER_LENGTH(message)/160)),0) AS total
        $query = 'SELECT COUNT(receiver) as total,
        DATE_FORMAT(created_date,"%Y-%m") AS month_total,dlr,sender 
        FROM sent_sms GROUP BY month_total,dlr,sender ORDER BY month_total DESC';

        return Myhelper::getAll($query);
    }
    public function getPlayers(){
        $query ="SELECT distinct(receiver) as phone_number from sent_sms";
        return Myhelper::getAll($query);
    }
    public static function blacklisted()
    {
        $data=SentSms::find()->select('receiver')->where(["dlr"=>"SenderName Blacklisted"])->distinct()->all();
        foreach($data as $row)
        {
            $model=Contact::findOne(['msisdn'=>$row->receiver]);
            if($model)
            {
                $model->delete(false);
            }
        }
    }
}
