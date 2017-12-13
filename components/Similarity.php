<?php

namespace app\components;

use yii\base\Component;

class Similarity extends Component
{
    /**
     * @param string $str1
     * @param string $str2
     * @return float
     */
    public static function getSimilarity(string $str1, string $str2)
    {
        similar_text(strtolower($str1), strtolower($str2), $percent);

        return $percent;
    }
}
