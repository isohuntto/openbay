<?php

namespace frontend\modules\search\validators;

use yii\validators\Validator;

/**
 * Validates sphinx extended syntax
 */
class SphinxSyntaxValidator extends Validator
{

    public function validateAttribute($object, $attribute) {
        $value = trim($object->$attribute);
        if (empty($value)) {
            return;
        }

        // Check validation for "|"
        if (substr_count($value, '|') > 0) {
            $parts = explode('|', $value);
            $p = trim($parts[0]);
            if (!$p || in_array($p, array(
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
            if (!trim(preg_replace('#\s*(![^ !]+)\s*#mui', '', $value))) {
                $this->addError($object, $attribute, 'Wrong query syntax: operator NOT can not be use without simple tokens');
                return;
            }

            $parts = explode('!', $value);
            if (count($parts) > 0 && !trim($parts[count($parts) - 1])) {
                $this->addError($object, $attribute, 'Wrong query syntax: after operator NOT must be follow lexem');
                return;
            }
        }
    }

}
