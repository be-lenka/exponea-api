<?php

namespace belenka\ExponeaApi\Events;

use belenka\ExponeaApi\Events\Traits\CategoryAndActionTrait;
use belenka\ExponeaApi\Events\Traits\CustomerIdTrait;
use belenka\ExponeaApi\Events\Traits\TimestampTrait;
use belenka\ExponeaApi\Events\Traits\ValidUntilTrait;
use belenka\ExponeaApi\Interfaces\CustomerIdInterface;
use belenka\ExponeaApi\Interfaces\EventInterface;

/**
 * Consent (agreement) change event
 * @package belenka\ExponeaApi\Events
 */
class Consent implements EventInterface
{
    const CATEGORY_NEWSLETTER = 'newsletter';
    const CATEGORY_SMS = 'sms';

    const ACTION_REVOKE = 'reject';
    const ACTION_GRANT = 'accept';

    use CustomerIdTrait;
    use TimestampTrait;
    use CategoryAndActionTrait;
    use ValidUntilTrait;

    public function __construct(CustomerIdInterface $customerIds, string $category, string $action)
    {
        $this->setCustomerIds($customerIds);
        $this->setCategory($category);
        $this->setAction($action);
        $this->setTimestamp(microtime(true));
    }

    /** @return array{action: string, category: string, timestamp: float, valid_until: string|float} */
    public function getProperties()
    {
        return [
            'action' => $this->getAction(),
            'category' => $this->getCategory(),
            'timestamp' => $this->getTimestamp(),
            'valid_until' => $this->getValidUntil() ?? 'unlimited',
        ];
    }

    public function getEventType(): string
    {
        return 'consent';
    }
}
