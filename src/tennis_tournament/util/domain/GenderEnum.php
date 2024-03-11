<?php declare(strict_types=1);

namespace tennis_tournament\util\domain;
use tennis_tournament\util\domain\InputFormatException;

enum GenderEnum: string
{
    case Male = 'M';
    case Female = 'F';

    public static function fromValue(string $value): ?GenderEnum
    {
        foreach (self::cases() as $gender) {
            if ($value === $gender->value) {
                return $gender;
            }
        }
        throw new InputFormatException("$value is not a valid gender");
    }

}
