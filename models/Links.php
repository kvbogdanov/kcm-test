<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cnt_links".
 *
 * @property int $id_link
 * @property int $creator_ip
 * @property string $url
 * @property string $link
 * @property int $date_create
 * @property int $date_delete
 * @property string $date_to
 */
class Links extends \yii\db\ActiveRecord
{
    public $date_to;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cnt_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_ip', 'date_create', 'date_delete'], 'integer'],
            ['url', 'required'],
            [['url', 'link'], 'string', 'max' => 255],
            [['date_to'], 'date', 'format' => 'yyyy-MM-dd', 'timestampAttribute' => 'date_delete'],
            ['url', 'url'],
            ['link', 'unique', 'skipOnEmpty' => true]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_link' => 'Id Link',
            'creator_ip' => 'Creator Ip',
            'url' => 'Url',
            'link' => \Yii::t('app', 'Link'),
            'date_create' => \Yii::t('app','Date Create'),
            'date_delete' => \Yii::t('app','Date Delete'),
        ];
    }

    public function getRedirects()
    {
        return $this->hasMany(History::className(), ['id_link' => 'id_link'])->orderBy('date DESC');
    }
}
