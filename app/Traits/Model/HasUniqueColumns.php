<?php

namespace App\Traits\Model;

use Illuminate\Support\Str;

trait HasUniqueColumns
{
    /**
     * Make sure that any unique column is given a unique string.
     */
    protected static function handleUniqueColumns()
    {
        // Get the class name.
        $class = get_called_class();

        if (self::testClassForUniqueId($class) == true) {
            $class::creating(function ($object) use ($class) {
                $object->{$object->primaryKey} = $class::findExistingReferences($class, $object->primaryKey);
            });
        }

        // If any fields are marked for unique strings, add them.
        if (isset($class::$uniqueStringColumns) && count($class::$uniqueStringColumns) > 0) {
            foreach ($class::$uniqueStringColumns as $field) {
                $class::creating(function ($object) use ($class, $field) {
                    $object->{$field} = $class::findExistingReferences($class, $field);
                });
            }
        }
    }

    /**
     * Make sure the uniqueId is always unique.
     *
     * @param string $model The model to search on.
     * @param        $field The field to search on.
     *
     * @return string
     */
    public static function findExistingReferences($model, $field)
    {
        $invalid      = true;
        $uniqueString = null;

        while ($invalid == true) {
            // Create a new random string.
            $uniqueString = Str::random($model::$uniqueStringLimit);

            // Look for any instances of that string on the model.
            $existingReferences = $model::where($field, $uniqueString)->count();

            // If none exist, this is a valid unique string.
            if ($existingReferences == 0) {
                $invalid = false;
            }
        }

        return $uniqueString;
    }

    /**
     * See if a given class uses uniqueId as the primary key.
     *
     * @param string $class The model to search for the uniqueId on.
     *
     * @return bool
     */
    public static function testClassForUniqueId($class)
    {
        $object = new $class;

        if (stripos($object->primaryKey, 'unique') !== false) {
            return true;
        }

        return false;
    }
}
