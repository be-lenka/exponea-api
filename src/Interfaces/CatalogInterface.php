<?php

namespace belenka\ExponeaApi\Interfaces;

/**
 * Interface describing catalog for which action should be made
 * @package belenka\ExponeaApi\Interfaces
 */
interface CatalogInterface
{
    /**
     * Get catalog ID  
     * @return string|null
     */
    public function getID();
    
    /**
     * Get catalog Item ID 
     * @return integer|null
     */
    public function getItemID();

    /**
     * Get catalog query parameters
     * @return array|null
     */
    public function getQueryParameters();
    
}
