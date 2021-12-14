<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Menus".
 *
 * @property string $CODE
 * @property string $LIBELLE
 * @property string $CODETABLE
 */
class Menus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'MENUS';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODE', 'LIBELLE', 'CODETABLE'], 'required'],
            [['CODE', 'CODETABLE'], 'string', 'max' => 5],
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
            'LIBELLE' => 'Libelle',
            'CODETABLE' => 'Codetable',
        ];
    }
}
