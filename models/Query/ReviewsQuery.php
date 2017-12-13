<?php

namespace app\models\Query;

use yii\db\Expression;
use yii\db\Query;

/**
 * This is the ActiveQuery class for [[Reviews]].
 *
 * @see Reviews
 */
class ReviewsQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $sexShort
     * @param $asFieldName
     */
    public function getSexAvgQuery(string $sexShort, string $asFieldName)
    {
        $this->addSelect([
            "book_id",
            sprintf("AVG(CASE WHEN sex = '%s' THEN age end) as '%s'", $sexShort, $asFieldName)
        ]);
        $this->innerJoin('books', 'books.id = reviews.book_id');
        $this->groupBy(['book_id']);
    }

    /**
     * @inheritdoc
     * @return Books[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Books|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
