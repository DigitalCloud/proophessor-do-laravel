<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/20/19
 * Time: 3:01 PM
 */

namespace App\ProophessorDo\Model\Quotation\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Quotation\QuotationId;
use Prooph\ProophessorDo\Model\User\UserId;

final class QuotationWasPosted extends AggregateChanged
{

    /**
     * @var QuotationId
     */
    private $quotationId;

    /**
     * @var UserId
     */
    private $customerId;

    /**
     * @var InvoiceId
     */
    private $invoiceId;

    /**
     * @var InvoiceTotal
     */
    private $total;


    public static function forCustomer(QuotationId $quotationId, InvoiceId $invoiceId,UserId $customerId,InvoiceTotal $total)
    {
        /** @var self $event */
        $event = self::occur($quotationId->toString(), [
            'invoice_id' => $invoiceId->toString(),
            'customer_id' => $customerId->toString(),
            'total' => $total->total(),
        ]);

        $event->quotationId = $quotationId;
        $event->customerId = $customerId;
        $event->invoiceId = $invoiceId;
        $event->total = $total;

        return $event;
    }

    public function quotationId(): QuotationId
    {
        if (null === $this->quotationId) {
            $this->quotationId = QuotationId::fromString($this->aggregateId());
        }

        return $this->quotationId;
    }

    public function invoiceId(): InvoiceId
    {
        if (null === $this->invoiceId) {
            $this->invoiceId = InvoiceId::fromString($this->payload['invoice_id']);
        }

        return $this->invoiceId;
    }

    public function customerId(): UserId
    {
        if (null === $this->customerId) {
            $this->customerId = UserId::fromString($this->payload['customer_id']);
        }

        return $this->customerId;
    }

    public function total(): InvoiceTotal
    {
        return InvoiceTotal::fromDouble($this->payload['total']);
    }
}
