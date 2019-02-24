<?php

namespace MrEvrey\Unit\Validators;

use MrEvrey\Unit\ValidatorInterface;
use MrEvrey\Unit\ValidatorInvalidArgumentException;

class UrlValidator implements ValidatorInterface
{
    public const ALIAS = 'urlValidator';

    /**
     * @param string $argument
     * @return bool
     */
    public function validate($argument): bool
    {
        if (!\is_string($argument)) {
            throw new ValidatorInvalidArgumentException('Argument must be of type string, ' . \gettype($argument) . ' given.');
        }

        return filter_var($argument, FILTER_VALIDATE_URL);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return static::ALIAS;
    }
}
