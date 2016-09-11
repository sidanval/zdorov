<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\History;

/**
 * HistorySearch represents the model behind the search form about `backend\models\History`.
 */
class HistorySearch extends History
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['user_id', 'purchase_id'], 'safe']
        ];
    }

    /**
     * @inheritdoc
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
        $query = History::find()->joinWith('user')->joinWith('purchase');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
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
            //'user.username' => $this->user_id,
            #'purchase_id' => $this->purchase_id,
        ]);

        $query->andFilterWhere(['like', 'lower({{%user}}.username)', mb_strtolower($this->user_id, 'UTF-8')]);
        $query->andFilterWhere(['like', 'lower({{%purchase}}.name)', mb_strtolower($this->purchase_id, 'UTF-8')]);

        return $dataProvider;
    }
}
