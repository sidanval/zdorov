<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Purchase;

/**
 * PurchaseSearch represents the model behind the search form about `common\models\Purchase`.
 */
class PurchaseSearch extends Purchase
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'clientName', 'product_id'], 'safe'],
            [['cost'], 'number'],
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
        $query = Purchase::find()->joinWith('product');

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
            '{{%purchase}}.cost' => $this->cost,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'lower({{%purchase}}.name)', mb_strtolower($this->name, 'UTF-8')])
            ->andFilterWhere(['like', 'lower({{%purchase}}.{{clientName}})', mb_strtolower($this->clientName, 'UTF-8')])
            ->andFilterWhere(['like', 'lower({{%product}}.name)', mb_strtolower($this->product_id, 'UTF-8')]);

        return $dataProvider;
    }
}
