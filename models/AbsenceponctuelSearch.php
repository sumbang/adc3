<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Absenceponctuel;

/**
 * AbsenceponctuelSearch represents the model behind the search form of `app\models\Absenceponctuel`.
 */
class AbsenceponctuelSearch extends Absenceponctuel
{
    public $direction;
    public $service;
    public $departement;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID_ABSENCE', 'ANNEEEXIGIBLE','TYPE_DEMANDE'], 'integer'],
            [['CODEABS', 'MATICULE', 'DATEDEBUT', 'DATEFIN', 'STATUT', 'IMPUTERCONGES', 'DATEEMIS', 'DATEVAL', 'DATEANN','departement','direction','service'], 'safe'],
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
        if(Yii::$app->user->identity->ROLE == "R1" || Yii::$app->user->identity->ROLE == "R2")   $query = Absenceponctuel::find();

        else $query = Absenceponctuel::find(['IDUSER'=>Yii::$app->user->identity->IDUSER]);

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
            'ID_ABSENCE' => $this->ID_ABSENCE,
            'ANNEEEXIGIBLE' => $this->ANNEEEXIGIBLE,
            'DATEDEBUT' => $this->DATEDEBUT,
            'DATEFIN' => $this->DATEFIN,
            'DATEEMIS' => $this->DATEEMIS,
            'DATEVAL' => $this->DATEVAL,
            'DATEANN' => $this->DATEANN,
            'TYPE_DEMANDE' => $this->TYPE_DEMANDE
        ]);

        $query->andFilterWhere(['like', 'CODEABS', $this->CODEABS])
            ->andFilterWhere(['like', 'MATICULE', $this->MATICULE])
            ->andFilterWhere(['like', 'STATUT', $this->STATUT])
            ->andFilterWhere(['like', 'IMPUTERCONGES', $this->IMPUTERCONGES]);

        if(isset($direction)) {

            $tab = array();
            $emps = Employe::find()->where(["LIKE","DIRECTION",$direction])->all();
            foreach($emps as $emp) $tab[] = $emp->MATRICULE;

            $query->andFilterWhere(["IN","MATICULE",$tab]);

        }

        if(isset($service)) {

            $tab = array();
            $emps = Employe::find()->where(["LIKE","SERVICE",$service])->all();
            foreach($emps as $emp) $tab[] = $emp->MATRICULE;

            $query->andFilterWhere(["IN","MATICULE",$tab]);
        }

        if(isset($departement)) {

            $tab = array();
            $emps = Employe::find()->where(["CODEDPT"=>$departement])->all();
            foreach($emps as $emp) $tab[] = $emp->MATRICULE;

            $query->andFilterWhere(["IN","MATICULE",$tab]);
        }

        return $dataProvider;
    }
}
