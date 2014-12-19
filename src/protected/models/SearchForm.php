<?php
class SphinxSyntaxValidator extends CValidator
{

    public function validateAttribute($object, $attribute)
    {
        $value = trim($object->$attribute);
        if (empty($value)) {
            return;
        }

        // Check validation for "|"
        if (substr_count($value, '|') > 0) {
            $parts = explode('|', $value);
            $p = trim($parts[0]);
            if (! $p || in_array($p, array(
                '$',
                '^'
            ))) {
                $this->addError($object, $attribute, 'Wrong query syntax: operator OR can not be first lexem or use before other operators in query');
                return;
            }
        }

        // Check validation for ^field-start field-end$ query
        if (count($value) > 0 && $value[0] == '$') {
            $this->addError($object, $attribute, 'Wrong query syntax: operator field-end$ can not be by first position in query');
            return;
        }

        // Check validation for NOT operator
        if (substr_count($value, '!') > 0) {
            if (! trim(preg_replace('#\s*(![^ !]+)\s*#mui', '', $value))) {
                $this->addError($object, $attribute, 'Wrong query syntax: operator NOT can not be use without simple tokens');
                return;
            }

            $parts = explode('!', $value);
            if (count($parts) > 0 && ! trim($parts[count($parts) - 1])) {
                $this->addError($object, $attribute, 'Wrong query syntax: after operator NOT must be follow lexem');
                return;
            }
        }
    }
}

class SearchForm extends CFormModel
{
    // Form type constants
    const ADVANCED_FORM = 'advanced';

    const SIMPLE_FORM = 'simple';

    // Encoding
    const ENCODING = 'UTF-8';

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

    public function rules()
    {
        return array(
            // Simple form
            array(
                'age, popular, status',
                'safe',
                'on' => 'simple'
            ),
            array(
                'words',
                'length',
                'min' => 2,
                'max' => 255,
                'on' => 'simple'
            ),
            array(
                'words',
                'sphinxSyntaxValidator',
                'on' => 'simple'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'words' => Yii::t('site_texts', 'Keywords')
        );
    }

    public function setWords($words)
    {
        if (is_string($words)) {
            // Convert words to lower case
            $words = mb_strtolower(trim($words), self::ENCODING);
        }

        $this->words = $words;
    }

    public function getWords()
    {
        return $this->words;
    }

}