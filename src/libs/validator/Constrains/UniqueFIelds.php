<?php
namespace App\libs\validator\Constrains;

use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

class UniqueFields extends Unique {

    public function __construct(
        array $fieldKeys,
        array $options = null,
        string $message = null,
        array $groups = null,
        mixed $payload = null
    ) {
        if (empty($fieldKeys)) {
            throw new InvalidArgumentException('parameter "fieldKeys" should be not empty.');
        }
        $normalizer = function($v) use($fieldKeys) {
            return array_intersect_key($v, array_flip($fieldKeys));
        };
        parent::__construct(
            $options,
            $message,
            $normalizer,
            $groups,
            $payload);
    }
}