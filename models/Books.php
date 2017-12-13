<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $book_date
 *
 * @property Reviews[] $reviews
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * @var
     */
    public $male_avg_age;

    /**
     * @var
     */
    public $female_avg_age;

    /**
     * @var
     */
    public $compatibility;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'book_date'], 'required'],
            [['name'], 'string', 'max' => 56],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Book',
            'book_date' => 'Book Date'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::className(), ['book_id' => 'id']);
    }


}
