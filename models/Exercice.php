<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EXERCICE".
 *
 * @property int $ANNEEEXIGIBLE
 * @property string $DATEBEDUT
 * @property string $DATEFIN
 * @property string $STATUT
 * @property string $DATEOUVERT
 * @property string $DATECLOTURE
 *
 * @property ABSENCEPONCTUEL[] $aBSENCEPONCTUELs
 * @property DECISIONCONGES[] $dECISIONCONGESs
 */
class Exercice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exercice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ANNEEEXIGIBLE','DATEBEDUT','DATEFIN','STATUT'], 'required'],
            [['ANNEEEXIGIBLE'], 'integer'],
            [['DATEBEDUT', 'DATEFIN', 'DATEOUVERT', 'DATECLOTURE'], 'safe'],
            [['STATUT'], 'string', 'max' => 5],
            [['ANNEEEXIGIBLE'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ANNEEEXIGIBLE' => 'Année Exigible',
            'DATEBEDUT' => 'Date de dedut',
            'DATEFIN' => 'Date de fin',
            'STATUT' => 'Statut',
            'DATEOUVERT' => 'Date d\'ouverture',
            'DATECLOTURE' => 'Date de cloture',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getABSENCEPONCTUELs()
    {
        return $this->hasMany(ABSENCEPONCTUEL::className(), ['ANNEEEXIGIBLE' => 'ANNEEEXIGIBLE']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDECISIONCONGESs()
    {
        return $this->hasMany(DECISIONCONGES::className(), ['ANNEEEXIGIBLE' => 'ANNEEEXIGIBLE']);
    }
}
