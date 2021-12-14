<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Tables".
 *
 * @property string $CODE
 * @property string $LIBELLE
 */
class Tables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'TABLES';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODE', 'LIBELLE'], 'required'],
            [['CODE'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 30],
            [['CODE'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'CODE' => 'Code',
            'LIBELLE' => 'Libelle',
        ];
    }
}
