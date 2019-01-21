<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/21/19
 * Time: 2:15 AM
 */

namespace App\ProophessorDo\Model\Customer\Exception;

use App\ProophessorDo\Model\Customer\Customer;

class EmailNotChanged extends \RuntimeException
{
    public static function forCustomer(Customer $customer): EmailNotChanged
    {
        return new self(sprintf(
            'Tried to change email of Customer %s. But no new email entered!',
            $customer->customerId->toString()
        ));
    }
}
