<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SITMAT".
 *
 * @property string $CODESIT
 * @property string $LIBELLE
 */
class Sitmat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sitmat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODESIT', 'LIBELLE'], 'required'],
            [['CODESIT'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 100],
            [['CODESIT'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CODESIT' => 'Codesit',
            'LIBELLE' => 'Libelle',
        ];
    }
}
