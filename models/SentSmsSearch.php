<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SentSms;

/**
 * SentSmsSearch represents the model behind the search form of `app\models\SentSms`.
 */
class SentSmsSearch extends SentSms
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','user_id'], 'integer'],
            [['receiver', 'sender', 'message','dlr', 'created_date','category'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$category, $daily = false, $monthly = false, $from = null, $to = null)

    {
        $query = SentSms::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_date' => $this->created_date,
            //'category' => $this->category,
        ]);

        $query->andFilterWhere(['like', 'receiver', $this->receiver])
        //->andFilterWhere(['like', 'sender',"JAMBOBET"])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'created_date', $this->created_date])
            ->andFilterWhere(['like', 'dlr', $this->dlr]);
            $today     = date( 'Y-m-d' );
        $yesterday = date( 'Y-m-d', strtotime( '-1 day' ) );
        if ( $daily ) {
                $query->andWhere( "DATE(created_date)>= DATE('" . $yesterday . "')" );
                $query->andWhere( "DATE(created_date)<= DATE('" . $today . "')" );
        }
        if ( $monthly ) {
                $query->andWhere( "MONTH(created_date)= MONTH(CURDATE())" );
                $query->andWhere( "YEAR(created_date)= YEAR(CURDATE())" );
        }
        if ( $from != null && $to != null ) {
               # $query->andWhere( "DATE(created_date)>= DATE('" . $from . "')" );
               # $query->andWhere( "DATE(created_date)<= DATE('" . $to . "')" );
               $query->andWhere( "created_date >= '$from'" );
               $query->andWhere( "created_date <= '$to'" );
        }
            if($category=="notbulk")
            {
                $query->andWhere('sender in ("JAMBOBET")');
            }
           if($category=="bulk")
            {
            $query->andWhere('sender in ("JambobetInf","PIGA-KAZI","JAMBOSPIN","PIGA JEKI")');
            }
            $query->orderBy('id DESC');    
        return $dataProvider;
    }
}
