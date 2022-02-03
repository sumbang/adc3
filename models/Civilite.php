<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CIVILITE".
 *
 * @property string $CODECIV
 * @property string $LIBELLE
 *
 * @property EMPLOYE[] $eMPLOYEs
 */
class Civilite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'civilite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODECIV'], 'required'],
            [['CODECIV'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 50],
            [['CODECIV'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODECIV' => 'Codeciv',
            'LIBELLE' => 'Libelle',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEMPLOYEs()
    {
        return $this->hasMany(EMPLOYE::className(), ['CODECIV' => 'CODECIV']);
    }
}
