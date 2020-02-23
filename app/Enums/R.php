<?php


namespace App\Enums;

/**
 * Class RulePresets
 *
 * @package App\Enums
 */
class R
{
    const TEXT = 'string|max:30000';
    const TEXT_OPTIONAL = self::TEXT."|nullable";
    const REQUIRED = 'required';
    const BOOLEAN = 'boolean';
    const DATE = 'date';
    const MONEY_SIMPLE = 'numeric|min:0|regex:/^\d{1,8}(\.\d{1,2})?$/'; // TODO: add regex for digits after dot
    const MONEY = 'numeric|min:0|regex:/^\d{1,13}(\.\d{1,5})?$/'; // TODO: add regex for digits after dot
    const COORDS = 'numeric|regex:/^-?\d{1,10}(\.\d{1,6})?$/'; // TODO: add regex for digits after dot
    const TIME = 'date_format:H:i';
    const CHILDREN_COUNT = 'integer|required|min:0|max:20';
    const DAY = 'integer|in:1,2,3,4,5,6,7';

    public static function build(array $rules): string
    {
        return join($rules, '|');
    }
}
