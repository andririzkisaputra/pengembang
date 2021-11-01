<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%anggota}}".
 *
 * @property int $anggota_id
 * @property string|null $nomor_anggota
 * @property string|null $nama_anggota
 * @property string|null $gambar
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $createdBy
 * @property Kehadiran[] $kehadirans
 */
class Anggota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%anggota}}';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
      return [
        TimestampBehavior::class,
        [
          'class' => BlameableBehavior::class,
          'updatedByAttribute' => false
        ]
      ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_anggota', 'nama_anggota'], 'required'],
            [['created_by'], 'integer'],
            [['nomor_anggota', 'gambar'], 'string', 'max' => 255],
            [['nama_anggota'], 'string', 'max' => 225],
            [['created_at', 'updated_at'], 'string', 'max' => 25],
            [['nomor_anggota'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            ['gambar', 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'anggota_id' => 'Anggota ID',
            'nomor_anggota' => 'Nomor Anggota',
            'nama_anggota' => 'Nama Anggota',
            'gambar' => 'Gambar',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['user_id' => 'created_by']);
    }

    /**
     * Gets query for [[Kehadirans]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\KehadiranQuery
     */
    public function getKehadirans()
    {
        return $this->hasMany(Kehadiran::className(), ['nomor_anggota' => 'nomor_anggota']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AnggotaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AnggotaQuery(get_called_class());
    }
}
