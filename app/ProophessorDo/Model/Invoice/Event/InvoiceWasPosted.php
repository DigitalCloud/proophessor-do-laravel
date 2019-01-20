<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Model\Invoice\Event;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\ProophessorDo\Model\Invoice\CustomerName;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoStatus;
use Prooph\ProophessorDo\Model\Todo\TodoText;
use Prooph\ProophessorDo\Model\User\UserId;

final class InvoiceWasPosted extends AggregateChanged
{
    /**
     * @var UserId
     */
    private $customerId;

    /**
     * @var InvoiceId
     */
    private $invoiceId;

    /**
     * @var CustomerName
     */
    private $customerName;

    /**
     * @var InvoiceTotal
     */
    private $invoiceTotal;

    public static function forCustomer(CustomerName $customerName, UserId $customerId, InvoiceId $invoiceId, InvoiceTotal $total): InvoiceWasPosted
    {
        /** @var self $event */
        $event = self::occur($invoiceId->toString(), [
            'customer_id' => $customerId->toString(),
            'customer_name' => $customerName->toString(),
            'total' => $total->total(),
        ]);

        $event->invoiceId = $invoiceId;
        $event->customerId = $customerId;
        $event->customerName = $customerName;
        $event->invoiceTotal = $total;

        return $event;
    }

    public function invoiceId(): InvoiceId
    {
        if (null === $this->invoiceId) {
            $this->invoiceId = InvoiceId::fromString($this->aggregateId());
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

    public function customerName(): CustomerName
    {
        return CustomerName::fromString($this->payload['customer_name']);
    }

    public function total(): InvoiceTotal
    {
        return InvoiceTotal::fromDouble($this->payload['total']);
    }


}
