<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DEPARTEMENTS".
 *
 * @property int $CODEDPT
 * @property string $LIBELLE
 */
class Departements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DEPARTEMENTS';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CODEDPT'], 'required'],
            [['CODEDPT'], 'integer', 'max' => 10],
            [['LIBELLE'], 'string', 'max' => 150],
            [['CODEDPT'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CODEDPT' => 'Code département',
            'LIBELLE' => 'Libellé',
        ];
    }
}
