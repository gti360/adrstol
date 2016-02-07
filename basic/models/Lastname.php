<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lastname".
 *
 * @property integer $id_lastname
 * @property string $lastname
 */
class Lastname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lastname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_lastname'], 'required'],
            [['id_lastname'], 'integer'],
            [['lastname'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_lastname' => 'Id Lastname',
            'lastname' => 'Lastname',
        ];
    }
}
