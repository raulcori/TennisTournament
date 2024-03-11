<?php declare(strict_types=1);

namespace tennis_tournament\util\domain;
use tennis_tournament\util\domain\InputFormatException;

final class PercentageInteger implements \JsonSerializable
{
    private int $value;

    public function __construct(int $value)
    {
        if (0 <= $value && $value <= 100) {
            $this->value = $value;
        } else {
            throw new InputFormatException("$value is out of percentage range.");
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function jsonSerialize() : array
    {
        return [$this->value];
    }
}