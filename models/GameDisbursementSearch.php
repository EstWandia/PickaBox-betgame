<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GameDisbursement;

/**
 * GameDisbursementSearch represents the model behind the search form of `app\models\GameDisbursement`.
 */
class GameDisbursementSearch extends GameDisbursement
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bet_id', 'msisdn', 'transaction_id', 'created_at'], 'safe'],
            [['amount'], 'number'],
            [['state'], 'integer'],
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
    public function search($params)
    {
        $query = GameDisbursement::find();

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
            'amount' => $this->amount,
            'state' => $this->state,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'bet_id', $this->bet_id])
            ->andFilterWhere(['like', 'msisdn', $this->msisdn])
            ->andFilterWhere(['like', 'transaction_id', $this->transaction_id]);

        return $dataProvider;
    }
}
