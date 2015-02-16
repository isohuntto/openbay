<?php

namespace frontend\modules\search\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{

    // Form type constants
    const ADVANCED_FORM = 'advanced';
    const SIMPLE_FORM = 'simple';

    public $age;
    public $tags;
    public $popular;
    public $status;
    public $category;
    // Count of items to be found, if > 0 - pagination shouldn't be used and Sphinx is limited to this number of records
    public $latest = 0;
    // Simple form fields
    // With public getter and setter method
    protected $words;
    protected static $filesRegex = '#\s*\*\s*(?P<filesPattern>[^\*]*)\*\s*#u';

    public function rules() {
        return [
            // Simple form
            [['age', 'popular', 'status'], 'safe', 'on' => 'simple'],
            [['words'], 'string', 'min' => 2, 'max' => 255, 'on' => 'simple'],
            [['words'], 'frontend\modules\search\validators\SphinxSyntaxValidator', 'on' => 'simple'],
        ];
    }

    public function attributeLabels() {
        return [
            'words' => Yii::t('app', 'Keywords'),
        ];
    }

    public function setWords($words) {
        if (is_string($words)) {
            // Convert words to lower case
            $words = mb_strtolower(trim($words), Yii::$app->charset);
        }

        $this->words = $words;
    }

    public function getWords() {
        return $this->words;
    }

}
