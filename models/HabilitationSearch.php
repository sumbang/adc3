<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Habilitation;

/**
 * HabilitationSearch represents the model behind the search form of `app\models\Habilitation`.
 */
class HabilitationSearch extends Habilitation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'ACREATE', 'AREAD', 'AUPDATE', 'ADELETE'], 'integer'],
            [['CODEMENU', 'CODEROLE'], 'safe'],
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
        $query = Habilitation::find();

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
            'ID' => $this->ID,
            'ACREATE' => $this->ACREATE,
            'AREAD' => $this->AREAD,
            'AUPDATE' => $this->AUPDATE,
            'ADELETE' => $this->ADELETE,
        ]);

        $query->andFilterWhere(['like', 'CODEMENU', $this->CODEMENU])
            ->andFilterWhere(['like', 'CODEROLE', $this->CODEROLE]);

        return $dataProvider;
    }
}
