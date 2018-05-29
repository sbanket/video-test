<?php

namespace App\Hydrator;

use App\Exception\HydratorException;

/**
 * Class ClassMethodHydrator
 *
 * @package App\Hydrator
 */
class ClassMethodHydrator
{
    /**
     * @param array $data
     * @param mixed $object
     *
     * @return mixed
     * @throws HydratorException
     */
    public function hydrate(array $data, $object)
    {
        if (!is_object($object)) {
            throw new HydratorException(
                sprintf(
                    '%s expects the provided $object to be a PHP object)',
                    __METHOD__
                )
            );
        }

        $objectClass = get_class($object);

        foreach ($data as $property => $value) {
            $setterName = 'set' . ucfirst($property);
            if (method_exists($objectClass, $setterName)) {
                $object->$setterName($value);
            }
        }

        return $object;
    }
}