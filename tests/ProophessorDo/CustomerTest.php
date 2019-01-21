<?php

namespace Tests\Unit;

use App\ProophessorDo\Model\AggregateChanged;
use App\ProophessorDo\Model\Customer\Customer;
use App\ProophessorDo\Model\Customer\Event\CustomerCreated;
use App\ProophessorDo\Model\Customer\Event\CustomerEmailChanged;
use App\ProophessorDo\Model\Customer\Exception\EmailNotChanged;
use Prooph\ProophessorDo\Model\Customer\CustomerEmail;
use Prooph\ProophessorDo\Model\Customer\CustomerId;
use Prooph\ProophessorDo\Model\Customer\CustomerName;
use Tests\ProophTestCase;

class CustomerTest extends ProophTestCase
{
    private $customerId;

    protected function setUp()
    {
        parent::setUp();

        $this->customerId = CustomerId::generate();
    }

    public function test_it_has_uuid()
    {
        $customerId = CustomerId::generate();

        $this->assertInstanceOf(CustomerId::class, $customerId);
    }

    public function test_it_has_name()
    {
        $customerName = CustomerName::fromString("Mohammed");

        $this->assertInstanceOf(CustomerName::class, $customerName);
    }

    public function test_it_has_email()
    {
        $customerEmail = CustomerEmail::fromString("dev@asd.com");

        $this->assertInstanceOf(CustomerEmail::class, $customerEmail);
    }

    public function test_customer_can_be_created()
    {
        $customer = Customer::create(
            CustomerId::generate(),
            CustomerName::fromString("Mohammed"),
            CustomerEmail::fromString("devmsh@test.com")
        );

        $this->assertCount(1, $events = $this->popRecordedEvents($customer));

        /** @var CustomerCreated $event */
        $this->assertInstanceOf(CustomerCreated::class, $event = $events->first());

        // whenCustomerCreated + CustomerCreated payload
        $this->assertTrue($customer->uuid->sameValueAs($event->customerId()));
        $this->assertTrue($customer->customerId->sameValueAs($event->customerId()));
        $this->assertTrue($customer->customerName->sameValueAs($event->customerName()));
        $this->assertTrue($customer->customerEmail->sameValueAs($event->customerEmail()));
    }

    public function test_customer_email_can_be_changed()
    {
        $customer = $this->reconstituteCustomer(
            $this->customerCreated()
        );

        $customer->changeEmail(CustomerEmail::fromString("qw1e@asd.com"));

        $events = $this->popRecordedEvents($customer);

        $this->assertCount(1, $events);

        /** @var CustomerEmailChanged $event */
        $this->assertInstanceOf(CustomerEmailChanged::class, $event = $events->first());

        $this->assertTrue($customer->customerEmail->sameValueAs($event->customerEmail()));
    }

    public function test_customer_email_must_be_changed_to_different_email()
    {
        $this->expectException(EmailNotChanged::class);

        $customer = $this->reconstituteCustomer(
            $this->customerCreated()
        );

        $customer->changeEmail($customer->customerEmail);
    }

    private function reconstituteCustomer(AggregateChanged ...$events): Customer
    {
        return $this->reconstituteAggregateFromHistory(
            Customer::class,
            $events
        );
    }

    private function customerCreated(): CustomerCreated
    {
        return CustomerCreated::create(
            $this->customerId,
            CustomerName::fromString("Mohammed"),
            CustomerEmail::fromString("dev@asd.com")
        );
    }

}
