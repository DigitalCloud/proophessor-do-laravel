<?php

namespace Tests\Unit;

use App\ProophessorDo\Model\Quotation\Event\QuotationWasPosted;
use App\ProophessorDo\Model\Quotation\Quotation;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Quotation\QuotationId;
use Prooph\ProophessorDo\Model\User\UserId;
use Tests\ProophTestCase;

/**
 * @property InvoiceId invoiceId
 * @property UserId customerId
 */
class QuotationTest extends ProophTestCase
{

    protected function setUp()
    {
        $this->invoiceId = InvoiceId::generate();
        $this->customerId = UserId::generate();
    }

    /**
     * @test
     */
    public function it_can_be_posted()
    {
        $quotation = Quotation::post(
            $quotationId = QuotationId::generate(),
            $this->invoiceId,
            $this->customerId,
            $total = InvoiceTotal::fromDouble(50.50)
        );

        $this->assertCount(1, $events = $this->popRecordedEvents($quotation));

        /** @var QuotationWasPosted $event */
        $this->assertInstanceOf(QuotationWasPosted::class, $event = $events->first());

        $this->assertTrue($quotationId->sameValueAs($event->quotationId()));
        $this->assertTrue($this->invoiceId->sameValueAs($event->invoiceId()));
        $this->assertTrue($this->customerId->sameValueAs($event->customerId()));
        $this->assertTrue($total->sameValueAs($event->total()));
    }
}
