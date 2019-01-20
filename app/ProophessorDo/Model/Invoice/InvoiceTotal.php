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

use Prooph\ProophessorDo\Model\ValueObject;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class InvoiceTotal implements ValueObject
{
    private $total;

    public static function fromDouble(float $total): InvoiceTotal
    {
        return new self($total);
    }

    private function __construct(float $total)
    {
        $this->total = $total;
    }

    public function toString(): string
    {
        return (string)$this->total;
    }

    public function total(): float
    {
        return $this->total;
    }

    public function sameValueAs(ValueObject $other): bool
    {
        return get_class($this) === get_class($other) && $this->total->equals($other->total);
    }
}
