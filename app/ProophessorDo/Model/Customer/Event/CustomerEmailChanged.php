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

final class CustomerEmailChanged extends AggregateChanged
{
    /**
     * @var CustomerId
     */
    protected $customerId;

    /**
     * @var CustomerEmail
     */
    protected $customerEmail;

    public static function for(CustomerId $customerId, CustomerEmail $customerEmail)
    {
        /** @var self $event */
        $event = self::occur($customerId->toString(), [
            'customer_email' => $customerEmail->toString(),
        ]);

        $event->customerId = $customerId;
        $event->customerEmail = $customerEmail;

        return $event;
    }

    public function customerEmail(): CustomerEmail
    {
        return CustomerEmail::fromString($this->payload['customer_email']);
    }
}
