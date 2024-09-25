<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Band;

/**
 * BandSearch represents the model behind the search form of `app\models\Band`.
 */
class BandSearch extends Band
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'updated_at'], 'safe'],
            [['band_amount', 'possible_win', 'rtp', 'retainer', 'retainer_percentage', 'rtp_percentage', 'stake_tax', 'win_tax'], 'number'],
            [['position', 'correct_position'], 'integer'],
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
        $query = Band::find()->orderBy(['band_amount' => SORT_ASC]);

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
            'band_amount' => $this->band_amount,
            'possible_win' => $this->possible_win,
            'rtp' => $this->rtp,
            'retainer' => $this->retainer,
            'position' => $this->position,
            'correct_position' => $this->correct_position,
            'retainer_percentage' => $this->retainer_percentage,
            'rtp_percentage' => $this->rtp_percentage,
            'stake_tax' => $this->stake_tax,
            'win_tax' => $this->win_tax,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id]);

        return $dataProvider;
    }
}
