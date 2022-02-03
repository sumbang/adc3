<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ECHELLON".
 *
 * @property string $CODEECH
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 */
class Echellon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'echellon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODEECH'], 'required'],
            [['CODEECH'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODEECH'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODEECH' => 'Codeech',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODEECH' => 'CODEECH']);
    }
}
