<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parametre;

/**
 * ParametreSearch represents the model behind the search form of `app\models\Parametre`.
 */
class ParametreSearch extends Parametre
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NUMERO', 'SUFFIXEREF'], 'safe'],
            [['DELAIEMISSION', 'DUREECONGES', 'DUREESERVICE'], 'integer'],
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
        $query = Parametre::find();

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
            'DELAIEMISSION' => $this->DELAIEMISSION,
            'DUREECONGES' => $this->DUREECONGES,
            'DUREESERVICE' => $this->DUREESERVICE,
        ]);

        $query->andFilterWhere(['like', 'NUMERO', $this->NUMERO])
            ->andFilterWhere(['like', 'SUFFIXEREF', $this->SUFFIXEREF]);

        return $dataProvider;
    }
}
