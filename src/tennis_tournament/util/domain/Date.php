<?php declare(strict_types=1);

namespace tennis_tournament\util\domain;
use tennis_tournament\util\domain\InputFormatException;
use DateTime;

final class Date implements \JsonSerializable
{

    private string $value;
    private const FORMAT = 'Y-m-d';

    public function __construct(string $value)
    {
        if (!$this->validate($value)) {
            throw new InputFormatException("$value is not a valid date");
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validate($value) : bool
    {
        $d = DateTime::createFromFormat(self::FORMAT, $value); 
        return $d && $d->format(self::FORMAT) === $value; 
    }

    public function addDays(int $days) : bool
    {
        $date = new DateTime($this->value);
        $date->modify("+$days days");
        $this->value = $date->format(self::FORMAT);
        return true;
    }

    public function jsonSerialize() : array
    {
        return [$this->value];
    }
}
