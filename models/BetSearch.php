<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bet;

/**
 * BetSearch represents the model behind the search form of `app\models\Bet`.
 */
class BetSearch extends Bet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'choice', 'band_id', 'msisdn', 'created_at'], 'safe'],
            [['stake', 'net_stake', 'net_win', 'win_tax', 'stake_tax', 'rtp'], 'number'],
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
        $query = Bet::find()->orderBy(['created_at' => SORT_DESC]);

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
            'stake' => $this->stake,
            'net_stake' => $this->net_stake,
            'net_win' => $this->net_win,
            'win_tax' => $this->win_tax,
            'stake_tax' => $this->stake_tax,
            'rtp' => $this->rtp,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'choice', $this->choice])
            ->andFilterWhere(['like', 'band_id', $this->band_id])
            ->andFilterWhere(['like', 'msisdn', $this->msisdn]);

        return $dataProvider;
    }
}
