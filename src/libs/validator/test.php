<?php

namespace App\libs;

require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Validator\Constraints as Assert;
use App\libs\validator\Constrains as AppAssert;
use App\libs\validator\ValidateViolationList;
use App\libs\validator\Constrains\UniqueFields;
use Symfony\Component\Validator\Validation;

function validate($input)
{
    $validator = Validation::createValidator();
    $groups = new Assert\GroupSequence(['Default', 'custom']);
    $constraint = new Assert\Collection([
        'name' => new Assert\Collection([
            'first_name' => new Assert\Length(['min' => 101]),
            'last_name' => new Assert\Length(['min' => 1]),
        ]),
        'email' => new Assert\Email(),
        'simple' => new Assert\Length(['min' => 102]),
        'eye_color' => new Assert\Choice([3, 4]),
        'file' => new Assert\File(),
        'password' => new Assert\Length(['min' => 60]),
        'tags' => new Assert\Optional([
            new Assert\Type('array'),
            new Assert\Count(['min' => 1]),
            new AppAssert\UniqueFields(['key']),
            new Assert\All([
                new Assert\Collection([
                    'key' => [
                        new Assert\NotBlank(),
                        new Assert\Type(['type' => 'string']),
                    ],
                    'label' => [
                        new Assert\NotBlank(),
                    ],
                ]),
            ]),
        ]),
        'remarks' => [
            new Assert\Optional([
                new Assert\Type('string')
            ]),
        ],
        'setting_json' => [
            new Assert\NotBlank(),
            new Assert\Type('string'),
        ]
    ]);
    // print_r($constraint->fields);
    print_r($constraint->getNestedConstraints());
    $violations = $validator->validate($input, $constraint, $groups);
    return $violations;
}


$input = [
    'name' => [
        'first_name' => 'Fabien',
        'last_name' => 'Potencier',
    ],
    'email' => 'test@email.tld',
    'simple' => 'hello',
    'eye_color' => 3,
    'file' => null,
    'password' => 'test',
    'setting_json' => null,
    'tags' => [
        ['key' => 'key', 'label' => 'this is label'],
        ['key' => 'key', 'label' => 'this is label2'],
    ],
];

$violationList = new ValidateViolationList(validate($input));
// print_r($violationList->getMessageHash());
