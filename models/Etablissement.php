<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ETABLISSEMENT".
 *
 * @property string $CODEETS
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 * @property EMPLOYE[] $eMPLOYEs0
 */
class Etablissement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'etablissement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODEETS'], 'required'],
            [['CODEETS'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODEETS'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODEETS' => 'Codeets',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODEETS' => 'CODEETS']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs0()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODEETS_EMB' => 'CODEETS']);
    }
}
