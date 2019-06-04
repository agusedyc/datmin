<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "testing".
 *
 * @property int $id
 * @property string $data_testing
 */
class Testing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_testing'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data_testing' => Yii::t('app', 'Data Testing'),
        ];
    }
}
