<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Roles".
 *
 * @property string $CODE
 * @property string $LIBELLE
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ROLES';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODE', 'LIBELLE'], 'required'],
            [['CODE'], 'string', 'max' => 5],
            [['LIBELLE'], 'string', 'max' => 100],
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
            'LIBELLE' => 'Libellé',
        ];
    }
}
