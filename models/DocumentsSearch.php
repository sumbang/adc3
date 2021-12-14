<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Documents;

/**
 * DocumentsSearch represents the model behind the search form of `app\models\Documents`.
 */
class DocumentsSearch extends Documents
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'NATURE', 'IDUSER'], 'integer'],
            [['LIBELLE', 'DOCUMENT', 'DATECREATION'], 'safe'],
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
        if(Yii::$app->user->identity->ROLE == "R1" || Yii::$app->user->identity->ROLE == "R2") $query = Documents::find();

        else $query = Documents::find(['IDUSER'=>Yii::$app->user->identity->IDUSER]);

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
            'NATURE' => $this->NATURE,
            'DATECREATION' => $this->DATECREATION,
            'IDUSER' => $this->IDUSER,
        ]);

        $query->andFilterWhere(['like', 'LIBELLE', $this->LIBELLE])
            ->andFilterWhere(['like', 'DOCUMENT', $this->DOCUMENT]);

        return $dataProvider;
    }
}
