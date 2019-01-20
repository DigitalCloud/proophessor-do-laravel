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

namespace Prooph\ProophessorDo\Projection\Invoice;


use Camuthig\EventStore\Package\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;
use Prooph\ProophessorDo\Model\Invoice\Event\InvoiceWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsDone;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasMarkedAsExpired;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasPosted;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasReopened;
use Prooph\ProophessorDo\Model\Todo\Event\TodoWasUnmarkedAsExpired;
use Prooph\ProophessorDo\Model\User\Event\UserWasRegistered;

/**
 * Class InvoiceProjection
 * @package Prooph\ProophessorDo\Projection\Ivoice
 */
final class InvoiceProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
                InvoiceWasPosted::class => function ($state, InvoiceWasPosted $event) {
                    /** @var InvoiceReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => $event->invoiceId()->toString(),
                        'customer_id' => $event->customerId()->toString(),
                        'customer_name' => $event->customerName()->toString(),
                        'total' => $event->total()->total(),
                    ]);
                }
            ]);

        return $projector;
    }
}
