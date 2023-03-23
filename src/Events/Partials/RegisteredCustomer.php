<?php

namespace belenka\ExponeaApi\Events\Partials;

use belenka\ExponeaApi\Interfaces\CustomerIdInterface;

/**
 * Identification of registered customer ID (e-mail in real usage)
 * @package belenka\ExponeaApi\Events\Partials
 */
class RegisteredCustomer implements CustomerIdInterface
{
    /**
     * @var string
     */
    protected $email;
    /**
     * @var array<string,string>|null
     */
    protected $softIDs = null;
    /**
     * @var string
     */
    protected $registeredKey = 'registered';
    
    /** @param array<string,string>|null $softIDs */
    public function __construct(string $email, array $softIDs = null)
    {
        $this->setEmail($email);
        $this->setSoftIDs($softIDs);
    }
    
    public function getRegisteredKey()
    {
        return $this->registeredKey;
    }
    
    public function setRegisteredKey(string $key): void
    {
        $this->registeredKey = $key;
    }
            
    public function getRegistered()
    {
        return $this->getEmail();
    }

    public function getCookie()
    {
        return null;
    }

    /**
     * @param string $email
     */
    protected function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param array<string,string>|null $softIDs
     */
    protected function setSoftIDs(?array $softIDs = null): void
    {
        $this->softIDs = $softIDs;
    }

    /** @return array<string,string>|null */
    public function getSoftIDs(): ?array
    {
        return $this->softIDs;
    }
}
