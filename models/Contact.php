<?php

namespace app\models;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property int|null $country_code
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            [['country_code'], 'integer'],
            [['name', 'phone'], 'string', 'max' => 255],
            ['country_code', 'validateCountryCode'],
        ];
    }

    /**
     * Проверка кода страны на существование
     */
    function validateCountryCode() {
        $json = file_get_contents('https://restcountries.eu/rest/v2/all');
        $countries = json_decode($json);

        foreach ($countries as $country) {
            if ($country->numericCode == $this->country_code) return;
        }

        $this->addError('country_code', 'Неверный код страны');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'country_code' => 'Код страны',
        ];
    }
}
