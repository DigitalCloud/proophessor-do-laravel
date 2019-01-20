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

namespace Prooph\ProophessorDo\Model\Invoice;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\ProophessorDo\Model\Entity;
use Prooph\ProophessorDo\Model\Invoice\Event\InvoiceWasPosted;
use Prooph\ProophessorDo\Model\User\UserId;

final class Invoice extends AggregateRoot implements Entity
{
    /**
     * @var InvoiceId
     */
    private $invoiceId;

    /**
     * @var UserId
     */
    private $customerId;

    /**
     * @var CustomerName
     */
    private $customerName;

    /**
     * @var null|InvoiceDueDate
     */
    private $dueDate;

    /**
     * @var InvoiceTotal
     */
    private $total;

    public static function post(CustomerName $customerName, UserId $customerId, InvoiceId $invoiceId, InvoiceTotal $total): Invoice
    {
        $self = new self();
        $self->recordThat(InvoiceWasPosted::forCustomer($customerName, $customerId, $invoiceId, $total));

        return $self;
    }

    public function dueDate(): ?InvoiceDueDate
    {
        return $this->dueDate;
    }

    public function invoiceId(): InvoiceId
    {
        return $this->invoiceId;
    }

    public function customerName(): CustomerName
    {
        return $this->customerName;
    }

    public function customerId(): UserId
    {
        return $this->customerId;
    }

    public function total(): InvoiceTotal
    {
        return $this->total;
    }

    protected function whenInvoiceWasPosted(InvoiceWasPosted $event): void
    {
        $this->invoiceId = $event->invoiceId();
        $this->customerId = $event->customerId();
        $this->customerName = $event->customerName();
        $this->total = $event->total();
    }

    protected function aggregateId(): string
    {
        return $this->invoiceId->toString();
    }

    public function sameIdentityAs(Entity $other): bool
    {
        return get_class($this) === get_class($other) && $this->invoiceId->sameValueAs($other->invoiceId);
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
