<?php

namespace MrEvrey\Unit;

class ValidatorChain
{
    /**
     * @var ValidatorInterface[]|iterable
     */
    public $validators = [];

    /**
     * @param ValidatorInterface $validator
     */
    public function addValidator(ValidatorInterface $validator): void
    {
        $this->validators[$validator->getAlias()] = $validator;
    }

    /**
     * @param string $alias
     * @return ValidatorInterface
     * @throws ValidatorNotFoundException
     */
    public function getValidator(string $alias): ValidatorInterface
    {
        if (array_key_exists($alias, $this->validators)) {
            return $this->validators[$alias];
        }

        throw new ValidatorNotFoundException('Validator with alias "' . $alias . '" not found!');
    }

    /**
     * @return iterable
     */
    public function getValidators(): iterable
    {
        return $this->validators;
    }
}
