<?php

namespace belenka\ExponeaApi\Interfaces;

/**
 * Interface describing catalog item for which action should be made
 * @package belenka\ExponeaApi\Interfaces
 */
interface CatalogItemInterface
{
    /**
     * Get catalog Item ID  
     * @return string|null
     */
    public function getID();
    
    /**
     * Get catalog ID 
     * @return integer|null
     */
    public function getCatalogID();

    /**
     * Get catalog item properties
     * @return array|null
     */
    public function getProperties();
    
}
