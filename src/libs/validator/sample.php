<?php

namespace App\libs;

require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Validator\Constraints as Assert;
use App\libs\validator\Constrains as AppAssert;
use App\libs\validator\ValidateViolationList;
use App\libs\validator\Constrains\ListUnique;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validation;

function validate(mixed $value, Constraint|array $constraints)
{
    $list = Validation::createValidator()->validate($value, $constraints);
    echo "↓=====↓\n";
    foreach ($list as $violation) {
        /** @var \Symfony\Component\Validator\ConstraintViolation $violation */
        echo $violation . "\n";
        printf("\tgetPropertyPath:%s\n", $violation->getPropertyPath());
        if ($violation->getConstraint()->payload) {
            printf("\tprefix:%s\n", $violation->getConstraint()->payload['prefix'] ?? '--');
        }
        echo "↑=====↑\n";
    }
}
function collectionToList(Collection $c, Constraint ...$listConstraints)
{
    return [new Assert\All($c), ...$listConstraints];
}
$collection = new Assert\Collection([
    'type' => [
        new Assert\Type('string'),
        new Assert\Choice(choices: ['A', 'B'])
    ],
]);
$listConstraints = collectionToList(
    $collection,
    new Assert\Type('array', payload: ['prefix' => 'リスト']),
    new Assert\NotBlank(payload: ['prefix' => 'リスト']),
    new AppAssert\ListUnique(['type'], payload: ['prefix' => 'リスト'])
);
$input = [];
validate($input, $listConstraints);
$input = [
    ['type' => 'A'],
    ['type' => 'B'],
    ['type' => 'C'],
    ['type' => 'C'],
];
validate($input, $listConstraints);
$collection = new Assert\Collection([
    'type' => [
        new Assert\Type('string'),
        new Assert\Choice(choices: ['A', 'B'])
    ],
    'list' => $listConstraints,
]);
$input = [
    'type' => 'C',
    'list' => $input,
];
validate($input, $collection);
