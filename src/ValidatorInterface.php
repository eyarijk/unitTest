<?php

namespace MrEvrey\Unit;

interface ValidatorInterface
{
    /**
     * @param mixed $argument
     * @return bool
     * @throws ValidatorInvalidArgumentException
     */
    public function validate($argument): bool;

    /**
     * @return string
     */
    public function getAlias(): string;
}
