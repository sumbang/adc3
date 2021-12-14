<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employe;

/**
 * EmployeSearch represents the model behind the search form of `app\models\Employe`.
 */
class EmployeSearch extends Employe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MATRICULE', 'CODECAT', 'CODEECH', 'CODEEMP', 'CODEETS', 'CODECIV', 'CODECONT', 'CODEETS_EMB', 'NOM', 'PRENOM', 'DATEEMBAUCHE', 'DATECALCUL','STATUT','SERVICE','DIRECTION'], 'safe'],
            [['SOLDECREDIT', 'SOLDEAVANCE','CODEDPT'], 'number'],
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
        $query = Employe::find();

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
            'DATEEMBAUCHE' => $this->DATEEMBAUCHE,
            'SOLDECREDIT' => $this->SOLDECREDIT,
            'SOLDEAVANCE' => $this->SOLDEAVANCE,
            'CODEDPT' => $this->CODEDPT,
            'STATUT' => $this->STATUT,
        ]);

        $query->andFilterWhere(['like', 'MATRICULE', $this->MATRICULE])
            ->andFilterWhere(['like', 'CODECAT', $this->CODECAT])
            ->andFilterWhere(['like', 'CODEECH', $this->CODEECH])
            ->andFilterWhere(['like', 'CODEEMP', $this->CODEEMP])
            ->andFilterWhere(['like', 'CODEETS', $this->CODEETS])
            ->andFilterWhere(['like', 'CODECIV', $this->CODECIV])
            ->andFilterWhere(['like', 'CODECONT', $this->CODECONT])
            ->andFilterWhere(['like', 'CODEETS_EMB', $this->CODEETS_EMB])
            ->andFilterWhere(['like', 'NOM', $this->NOM])
           // ->andFilterWhere(['like','DATECALCUL',$this->DATECALCUL])
            ->andFilterWhere(['like', 'SERVICE', $this->SERVICE])
            ->andFilterWhere(['like', 'DIRECTION', $this->DIRECTION])
            ->andFilterWhere(['like', 'PRENOM', $this->PRENOM]);

        if(isset($this->DATECALCUL) && !empty($this->DATECALCUL)) {

            list($start_date, $end_date) = explode(' - ', $this->DATECALCUL);

            $query->andWhere(['>=', 'DATECALCUL', $start_date])->andWhere(['<=', 'DATECALCUL', $end_date]);

        }

        return $dataProvider;
    }
}
