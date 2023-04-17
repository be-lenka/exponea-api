<?php

namespace belenka\ExponeaApi\Interfaces;

/**
 * Interface describing create catalog for which action should be made
 * @package belenka\ExponeaApi\Interfaces
 */
interface CreateCatalogInterface
{
    /**
     * Get catalog Name
     * @return string|null
     */
    public function getName();
    
    /**
     * Is product catalog 
     * @return boolean|null
     */
    public function isProductCatalog();

    /**
     * Get catalog fields
     * @return array|null
     */
    public function getFields();
    
}
