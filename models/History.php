<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cnt_history".
 *
 * @property int $id_history
 * @property int $id_link
 * @property int $ip
 * @property int $date
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cnt_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_link', 'ip', 'date'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_history' => 'Id History',
            'id_link' => 'Id Link',
            'ip' => 'Ip',
            'date' => 'Date',
        ];
    }
}
