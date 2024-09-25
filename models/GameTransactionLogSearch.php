<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\GameTransactionLog;

/**
 * GameTransactionLogSearch represents the model behind the search form of `app\models\GameTransactionLog`.
 */
class GameTransactionLogSearch extends GameTransactionLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'json_data', 'date', 'api_type', 'transID', 'CheckoutRequestID'], 'safe'],
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
        $query = GameTransactionLog::find()->orderBy(["date"=>SORT_DESC]);

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
            'date' => $this->date,
            'state' => $this->state,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'json_data', $this->json_data])
            ->andFilterWhere(['like', 'api_type', $this->api_type])
            ->andFilterWhere(['like', 'CheckoutRequestID', $this->CheckoutRequestID]);

        return $dataProvider;
    }
}
