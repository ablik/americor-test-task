<?php

namespace App\Domain\Customer\ValueObject;

class FICO
{
    private int $score;

    private const MIN_FICO_SCORE = 300;
    private const MAX_FICO_SCORE = 850;

    public function __construct(int $score)
    {
        if ($score < self::MIN_FICO_SCORE || $score > self::MAX_FICO_SCORE) {
            throw new \InvalidArgumentException("Invalid FICO score.");
        }
        $this->score = $score;
    }

    public function getScore(): int
    {
        return $this->score;
    }

}