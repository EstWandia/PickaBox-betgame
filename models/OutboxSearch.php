<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Outbox;

/**
 * OutboxSearch represents the model behind the search form of `app\models\Outbox`.
 */
class OutboxSearch extends Outbox
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'receiver', 'message', 'created_at', 'category', 'sender'], 'safe'],
            [['status'], 'integer'],
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
        $query = Outbox::find();

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
            'created_at' => $this->created_at,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'receiver', $this->receiver])
            ->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'sender', $this->sender]);

        return $dataProvider;
    }
}
