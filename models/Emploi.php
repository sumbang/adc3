<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EMPLOI".
 *
 * @property int $CODEEMP
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 */
class Emploi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EMPLOI';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODEEMP'], 'required'],
            [['CODEEMP'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODEEMP'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODEEMP' => 'Codeemp',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODEEMP' => 'CODEEMP']);
    }
}
