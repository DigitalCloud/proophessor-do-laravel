<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/20/19
 * Time: 2:58 PM
 */

namespace App\ProophessorDo\Model\Quotation;

use App\ProophessorDo\Model\BaseEntity;
use App\ProophessorDo\Model\Quotation\Event\QuotationWasPosted;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Quotation\QuotationId;
use Prooph\ProophessorDo\Model\User\UserId;

class Quotation extends BaseEntity
{
    public static function post(QuotationId $quotationId,InvoiceId $invoiceId,UserId $customerId,InvoiceTotal $total)
    {
        $self = new self();

        $self->recordThat(QuotationWasPosted::forCustomer($quotationId, $invoiceId, $customerId, $total));

        return $self;
    }

    public function whenQuotationWasPosted(QuotationWasPosted $event)
    {

    }
}
