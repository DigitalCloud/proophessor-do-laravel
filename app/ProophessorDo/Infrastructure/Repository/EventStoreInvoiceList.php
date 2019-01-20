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

namespace Prooph\ProophessorDo\Infrastructure\Repository;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\ProophessorDo\Model\Invoice\Invoice;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceList;
use Prooph\ProophessorDo\Model\Todo\Todo;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoList;

final class EventStoreInvoiceList extends AggregateRepository implements InvoiceList
{
    public function save(Invoice $invoice): void
    {
        $this->saveAggregateRoot($invoice);
    }

    public function get(InvoiceId $invoiceId): ?Invoice
    {
        $this->getAggregateRoot($invoiceId->toString());
    }
}
