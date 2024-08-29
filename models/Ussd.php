<?php

namespace app\models;

use Yii;
use yii\db\IntegrityException;

/**
 * This is the model class for table "ussd".
 *
 * @property int $id
 * @property string|null $msisdn
 * @property string $created_at
 * @property string|null $message
 * @property string|null $transaction_id
 */
class Ussd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ussd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['msisdn'], 'string', 'max' => 250],
            [['message', 'transaction_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msisdn' => 'Msisdn',
            'created_at' => 'Created At',
            'message' => 'Message',
            'transaction_id' => 'Transaction ID',
        ];
    }
    public static function saveSession($msisdn,$message)
    {
        $model=Ussd::findOne($msisdn);
        $input='';
        if($model!=NULL)
        {
            $arr=explode("*",$message);
            if(in_array($message,[USSD_CODE,"continue"]))
            {
                $input=USSD_CODE;
            }
            else if(count($arr) > 1)
            {
                if($arr[0]=="continue")
                {
                    $arr[0]=USSD_CODE;
                    $input=implode("*",$arr);
                }
                else
                {
                    $input=$message;
                }
                
            }
            else
            {
                $input=$model->message."*".$message;
            }
            $model->message=$input;
            $model->save(false);
        }
        else{
            try
            {
                $arr=explode("*",$message);
                if(in_array($message,[USSD_CODE,"continue"]))
                {
                    $input=USSD_CODE;
                }
                else if(count($arr) > 1)
                {
                    if($arr[0]=="continue")
                    {
                        $arr[0]=USSD_CODE;
                        $input=implode("*",$arr);
                    }
                    else
                    {
                        $input=$message;
                    }
                    
                    
                }
                else
                    {
                        $input=$message;
                    }
                $model=new Ussd();
                $model->msisdn=$msisdn;
                $model->message=$input;
                $model->save(false);
            }
            catch(IntegrityException $e)
            {
                //do nothing
                var_dump($e);
            }
        }

        return $model;
    }    
}
