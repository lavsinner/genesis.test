<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $path
 * @property string $name
 * @property integer $type
 * @property integer $created_at
 * @property integer $uploaded_by
 *
 * @property User $uploadedBy
 */
class Image extends ActiveRecord
{
    public $avatar;

    const TYPE_AVATAR = 1;
    const TYPE_MEDIA = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'name', 'type'], 'required'],
            [['type', 'created_at', 'uploaded_by'], 'integer'],
            [['path', 'name'], 'string', 'max' => 255],
            [['uploaded_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uploaded_by' => 'id']],
            [['avatar'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
            'type' => 'Type',
            'created_at' => 'Created At',
            'uploaded_by' => 'Uploaded By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUploadedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'uploaded_by']);
    }

    /**
     * Can't user TimestampBehavior here, so we save create_at field before saving the model
     *
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->created_at = time();
        return parent::beforeSave($insert);
    }

    /**
     * Handling upload for avatar
     *
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777);
            }
            $this->avatar->saveAs('uploads/' . $this->avatar->baseName . '.' . $this->avatar->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * If there is no avatar for user show default
     *
     * @param $path
     * @return string
     */
    public static function getAvatar($path)
    {
        if(!$path) {
            return 'defaults/default_avatar.jpg';
        }

        return $path;
    }
}
