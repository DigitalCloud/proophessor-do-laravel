<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/20/19
 * Time: 2:58 PM
 */

namespace App\ProophessorDo\Model\Customer;

use App\ProophessorDo\Model\BaseEntity;
use App\ProophessorDo\Model\Customer\Event\CustomerCreated;
use App\ProophessorDo\Model\Customer\Event\CustomerEmailChanged;
use App\ProophessorDo\Model\Customer\Exception\EmailNotChanged;
use App\ProophessorDo\Model\Quotation\Event\QuotationWasPosted;
use Prooph\ProophessorDo\Model\Customer\CustomerEmail;
use Prooph\ProophessorDo\Model\Customer\CustomerId;
use Prooph\ProophessorDo\Model\Customer\CustomerName;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Quotation\QuotationId;
use Prooph\ProophessorDo\Model\User\UserId;

class Customer extends BaseEntity
{
    /* @var CustomerName $customerName */
    protected $customerName;

    /* @var CustomerEmail $customerEmail */
    protected $customerEmail;

    public static function create(CustomerId $customerId, CustomerName $customerName, CustomerEmail $customerEmail)
    {
        $self = new self();

        $self->recordThat(CustomerCreated::create($customerId, $customerName, $customerEmail));

        return $self;
    }

    public function whenCustomerCreated(CustomerCreated $event)
    {
        $this->uuid = $event->customerId();
        $this->customerName = $event->customerName();
        $this->customerEmail = $event->customerEmail();
    }

    public function changeEmail(CustomerEmail $customerEmail)
    {
        if($customerEmail->sameValueAs($this->customerEmail)){
            throw EmailNotChanged::forCustomer($this);
        }

        $customerId = CustomerId::fromString($this->aggregateId());

        $this->recordThat(
            CustomerEmailChanged::for($customerId, $customerEmail)
        );
    }

    public function whenCustomerEmailChanged(CustomerEmailChanged $event)
    {
        $this->customerEmail = $event->customerEmail();
    }
}
