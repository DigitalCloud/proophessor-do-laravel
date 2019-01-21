<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/21/19
 * Time: 12:12 AM
 */

namespace App\ProophessorDo\Model\Customer\Event;

use App\ProophessorDo\Model\AggregateChanged;
use Prooph\ProophessorDo\Model\Customer\CustomerEmail;
use Prooph\ProophessorDo\Model\Customer\CustomerId;
use Prooph\ProophessorDo\Model\Customer\CustomerName;

final class CustomerCreated extends AggregateChanged
{
    /**
     * @var CustomerId
     */
    protected $customerId;
    /**
     * @var CustomerName
     */
    protected $customerName;
    /**
     * @var CustomerEmail
     */
    protected $customerEmail;

    public function customerId(): CustomerId
    {
        if (null === $this->customerId) {
            $this->customerId = CustomerId::fromString($this->aggregateId());
        }

        return $this->customerId;
    }

    public function customerName(): CustomerName
    {
        return $this->customerName;
    }

    public function customerEmail(): CustomerEmail
    {
        return CustomerEmail::fromString($this->payload['customer_email']);
    }

    public static function create(CustomerId $customerId, CustomerName $customerName, CustomerEmail $customerEmail)
    {
        /** @var self $event */
        $event = self::occur($customerId->toString(), [
            'customer_name' => $customerName->toString(),
            'customer_email' => $customerEmail->toString(),
        ]);

        $event->customerId = $customerId;
        $event->customerName = $customerName;
        $event->customerEmail = $customerEmail;

        return $event;
    }

}
