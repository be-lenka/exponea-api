<?php

namespace belenka\ExponeaApi\Interfaces;

/**
 * Interface describing contact for which action should be made
 * @package belenka\ExponeaApi\Interfaces
 */
interface CustomerIdInterface
{
    /**
     * Exponea API customer_ids.cookie field
     * @return string|null
     */
    public function getCookie();
    /**
     * Exponea API customer_ids.registered field (should contain customer e-mail address which is base identifier)
     * @return string|null
     */
    public function getRegistered();
    /**
     * Exponea customer Hard ID key name (eg. "email_id" otherwise "registered")
     * @return string
     */
    public function getRegisteredKey();
    /**
     * Get Soft IDs which should be exported to Exponea (f.x. card number)
     * @return array<string,string>|null
     */
    public function getSoftIDs();
}
