<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IDUSER','DIRECTION','DEPARTEMENT','SERVICE'], 'integer'],
            [['EMAIL', 'PASSWORD', 'DATECREATION', 'TOKEN', 'AUTHKEY', 'NOM', 'ROLE','INITIAL','NIVEAU'], 'safe'],
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
        $query = User::find();

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
            'IDUSER' => $this->IDUSER,
            'NIVEAU' => $this->NIVEAU,
            'DIRECTION' => $this->DIRECTION,
            'DEPARTEMENT' => $this->DEPARTEMENT,
            'SERVICE' => $this->SERVICE,
            'DATECREATION' => $this->DATECREATION,
        ]);

        $query->andFilterWhere(['like', 'EMAIL', $this->EMAIL])
            ->andFilterWhere(['like', 'PASSWORD', $this->PASSWORD])
            ->andFilterWhere(['like', 'TOKEN', $this->TOKEN])
            ->andFilterWhere(['like', 'AUTHKEY', $this->AUTHKEY])
            ->andFilterWhere(['like', 'NOM', $this->NOM])
            ->andFilterWhere(['like', 'ROLE', $this->ROLE]);

        return $dataProvider;
    }
}
