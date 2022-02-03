<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CATEGORIE".
 *
 * @property string $CODECAT
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 */
class Categorie extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorie';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODECAT'], 'required'],
            [['CODECAT'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODECAT'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODECAT' => 'Codecat',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODECAT' => 'CODECAT']);
    }
}
