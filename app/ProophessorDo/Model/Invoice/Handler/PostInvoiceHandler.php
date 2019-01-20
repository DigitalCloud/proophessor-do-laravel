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

namespace Prooph\ProophessorDo\Model\Invoice\Handler;

use Prooph\ProophessorDo\Model\Invoice\Command\PostInvoice;
use Prooph\ProophessorDo\Model\Invoice\Invoice;
use Prooph\ProophessorDo\Model\Invoice\InvoiceList;
use Prooph\ProophessorDo\Model\User\Exception\UserNotFound;

class PostInvoiceHandler
{
    /**
     * @var InvoiceList
     */
    private $invoiceList;


    public function __construct(InvoiceList $invoiceList)
    {
        $this->invoiceList = $invoiceList;
    }

    /**
     * @throws UserNotFound
     */
    public function __invoke(PostInvoice $command): void
    {
        $invoice = Invoice::post($command->customerName(),$command->customerId(),$command->invoiceId(),$command->total());

        $this->invoiceList->save($invoice);
    }
}
