<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "firstname".
 *
 * @property integer $id_firstname
 * @property string $firstname
 */
class Firstname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'firstname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_firstname'], 'required'],
            [['id_firstname'], 'integer'],
            [['firstname'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_firstname' => 'Id Firstname',
            'firstname' => 'Firstname',
        ];
    }
}
