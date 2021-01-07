<?php
namespace App\Http\Traits;

trait Helpers {

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

    /**
     * Search in multi demision array
     *
     * @param string $searchKey The key to search
     * @param string $searchValue The value to search
     * @param array $array The array to be search on
     * @return string|int|null
     */
    public function searchMultiDimensionArray($searchKey, $searchValue, $array) {
        foreach ($array as $key => $val) {
            if (is_array($val) && $val[$searchKey] === $searchValue) {
                return $val;
            }
        }
        return null;
    }


}