<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "midname".
 *
 * @property integer $id_midname
 * @property string $midname
 */
class Midname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'midname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_midname'], 'required'],
            [['id_midname'], 'integer'],
            [['midname'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_midname' => 'Id Midname',
            'midname' => 'Midname',
        ];
    }
}
