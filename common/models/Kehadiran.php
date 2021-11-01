<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%kehadiran}}".
 *
 * @property int $kehadiran_id
 * @property string|null $nomor_anggota
 * @property int|null $created_by
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $createdBy
 * @property Anggota $nomorAnggota
 */
class Kehadiran extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kehadiran}}';
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
            [['nomor_anggota'], 'required'],
            [['created_by'], 'integer'],
            [['nomor_anggota'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'string', 'max' => 25],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'user_id']],
            [['nomor_anggota'], 'exist', 'skipOnError' => true, 'targetClass' => Anggota::className(), 'targetAttribute' => ['nomor_anggota' => 'nomor_anggota']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kehadiran_id' => 'Kehadiran ID',
            'nomor_anggota' => 'Nomor Anggota',
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
     * Gets query for [[NomorAnggota]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\AnggotaQuery
     */
    public function getNomorAnggota()
    {
        return $this->hasOne(Anggota::className(), ['nomor_anggota' => 'nomor_anggota']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\KehadiranQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\KehadiranQuery(get_called_class());
    }
}
