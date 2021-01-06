<?php
namespace App\Services;

class HelperService
{

    /**
     * Resolve and return the collection resource instance
     *
     * @param string $className The resource collection class name
     * @return string
     */
    public function resolveCollectionResource(string $className)
    {
        if (!class_exists($className)) {
            abort(500, 'Resource collection not found');
        }
        return $className;
    }

    /**
     * Resolve and return the single resource instance
     *
     * @param string $className The resource collection class name
     * @return string
     */
    public function resolveSingleResource(string $className)
    {
        // remove the Collection string from the resourceCollectionClass
        $singleResource = str_replace('Collection', '', $className);
        if (!class_exists($singleResource)) {
            abort(500, 'Resource not found');
        }
        return $singleResource;
    }

}