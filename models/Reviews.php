<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property integer $book_id
 * @property integer $age
 * @property string $sex
 *
 * @property Books $book
 */
class Reviews extends \yii\db\ActiveRecord
{
    const SEX_MALE = 'm';
    const SEX_FEMALE = 'f';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id', 'age', 'sex'], 'required'],
            [['book_id', 'age'], 'integer'],
            [['sex'], 'string'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'age' => 'Age',
            'sex' => 'Sex',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }
}
