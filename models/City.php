<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $id
 * @property integer $country_id
 * @property integer $region_id
 * @property string $name
 *
 * @property Country $country
 * @property Region $region
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->updateCountry();
            return true;
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updateCountry();
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id', 'name'], 'required'],
            [['country_id', 'region_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['region_id', 'name'], 'unique', 'targetAttribute' => ['region_id', 'name'], 'message' => 'The combination of Region ID and Name has already been taken.'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('model/region', 'ID'),
            'country_id' => Yii::t('model/region', 'Country'),
            'region_id' => Yii::t('model/region', 'Region'),
            'name' => Yii::t('model/region', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    private function updateCountry()
    {
        if ($this->region_id && $this->country_id != $this->region->country_id) {
            $this->country_id = $this->region->country_id;
        }
    }
}
