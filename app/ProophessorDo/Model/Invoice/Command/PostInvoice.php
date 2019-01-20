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

namespace Prooph\ProophessorDo\Model\Invoice\Command;

use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\ProophessorDo\Model\Invoice\CustomerName;
use Prooph\ProophessorDo\Model\Invoice\InvoiceId;
use Prooph\ProophessorDo\Model\Invoice\InvoiceTotal;
use Prooph\ProophessorDo\Model\Todo\TodoId;
use Prooph\ProophessorDo\Model\Todo\TodoText;
use Prooph\ProophessorDo\Model\User\UserId;

final class PostInvoice extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function forCustomer(string $customerName, string $customerId, string $invoiceId, float $total): PostInvoice
    {
        return new self([
            'customer_name' => $customerName,
            'customer_id' => $customerId,
            'invoice_id' => $invoiceId,
            'total' => $total,
        ]);
    }

    public function invoiceId(): InvoiceId
    {
        return InvoiceId::fromString($this->payload['invoice_id']);
    }

    public function customerId(): UserId
    {
        return UserId::fromString($this->payload['customer_id']);
    }

    public function customerName(): CustomerName
    {
        return CustomerName::fromString($this->payload['customer_name']);
    }

    public function total(): InvoiceTotal
    {
        return InvoiceTotal::fromDouble($this->payload['total']);
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'customer_id');
        Assertion::uuid($payload['customer_id']);
        Assertion::keyExists($payload, 'invoice_id');
        Assertion::uuid($payload['invoice_id']);
        Assertion::keyExists($payload, 'customer_name');
        Assertion::string($payload['customer_name']);
        Assertion::keyExists($payload, 'total');
        Assertion::float($payload['total']);

        $this->payload = $payload;
    }
}
