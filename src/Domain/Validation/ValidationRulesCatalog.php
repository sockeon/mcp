<?php

declare(strict_types=1);

namespace Sockeon\Mcp\Domain\Validation;

final class ValidationRulesCatalog
{
    /**
     * @return array<string, string>
     */
    public function all(): array
    {
        return [
            'Required' => 'Validates that a field is present and not empty',
            'StringRule' => 'Validates that a value is a string',
            'IntegerRule' => 'Validates that a value is an integer',
            'FloatRule' => 'Validates that a value is a float',
            'NumericRule' => 'Validates that a value is numeric',
            'BooleanRule' => 'Validates that a value is a boolean',
            'ArrayRule' => 'Validates that a value is an array',
            'EmailRule' => 'Validates that a value is a valid email address',
            'UrlRule' => 'Validates that a value is a valid URL',
            'AlphaRule' => 'Validates that a value contains only alphabetic characters',
            'AlphaNumericRule' => 'Validates that a value contains only alphanumeric characters',
            'MinRule' => 'Validates that a value meets a minimum requirement (length or value)',
            'MaxRule' => 'Validates that a value meets a maximum requirement (length or value)',
            'BetweenRule' => 'Validates that a value is between two values',
            'InRule' => 'Validates that a value is in a list of allowed values',
            'NotInRule' => 'Validates that a value is not in a list of disallowed values',
            'RegexRule' => 'Validates that a value matches a regular expression pattern',
            'JsonRule' => 'Validates that a value is valid JSON',
        ];
    }
}
