<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property int $id
 * @property string $name
 * @property string $file
 * @property int $status
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['file'],'file','skipOnEmpty' => true],
            // [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'file' => Yii::t('app', 'File'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs(Yii::$app->basePath.'/uploads/datasets/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }

}
