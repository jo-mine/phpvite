<?php

namespace App\libs\validator;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidateViolationList
{
    /** @var \Symfony\Component\Validator\ConstraintViolationListInterface $violationList */
    protected $violationList;
    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;
    }

    public function add(ConstraintViolationInterface $violation)
    {
        $this->violationList->add($violation);
    }

    public function addAll(ConstraintViolationListInterface $otherList)
    {
        $this->violationList = $otherList;
    }

    public function get(int $offset): ConstraintViolationInterface
    {
        return $this->violationList->get($offset);
    }

    public function getMessageHash(): array
    {
        $result = [];
        foreach ($this->violationList as $violation) {
            $paths = $this->parsePropertyPath($violation->getPropertyPath());
            $arr = $this->_mapViolation($paths, $violation);
            array_merge($result, $arr);
            $result = array_merge($result, $arr);
        }
        return $result;
    }

    protected function _mapViolation(array $paths, \Symfony\Component\Validator\ConstraintViolation $violation)
    {
        $arr = [];
        if (empty($paths)) {
            $arr[] = $violation->getMessage();
            return $arr;
        }
        $arr[array_shift($paths)] = $this->_mapViolation($paths, $violation);
        return $arr;
    }

    protected function parsePropertyPath(string $propertyPath): array
    {
        $pattern = '/\[(.+?)\]/';
        preg_match_all($pattern, $propertyPath, $resultList);
        if (empty($resultList)) {
            return [];
        }
        return $resultList[1];
    }

    public function has(int $offset): bool
    {
        return $this->violationList->has($offset);
    }

    public function set(int $offset, ConstraintViolationInterface $violation)
    {
        $this->violationList->set($offset, $violation);
    }

    public function remove(int $offset)
    {
        $this->violationList->remove($offset);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->violationList->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->violationList->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->violationList->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->violationList->offsetUnset($offset);
    }

    public function count(): int
    {
        return $this->violationList->count();
    }
}
