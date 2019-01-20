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

final class InvoiceDueDate implements ValueObject
{
    /**
     * @var \DateTimeImmutable
     */
    private $dueDate;

    /**
     * @var \DateTimeImmutable
     */
    private $createdOn;

    public static function fromString(string $due_date): InvoiceDueDate
    {
        return new self($due_date);
    }

    private function __construct(string $due_date)
    {
        $this->dueDate = new \DateTimeImmutable($due_date, new \DateTimeZone('UTC'));
        $this->createdOn = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function isInThePast(): bool
    {
        return $this->dueDate < $this->createdOn;
    }

    public function toString(): string
    {
        return $this->dueDate->format(\DateTime::ATOM);
    }

    public function createdOn(): string
    {
        return $this->createdOn->format(\DateTime::ATOM);
    }

    public function isMet(): bool
    {
        return $this->dueDate > new \DateTimeImmutable();
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return get_class($this) === get_class($object)
            && $this->dueDate->format('U.u') === $object->dueDate->format('U.u')
            && $this->createdOn->format('U.u') === $object->createdOn->format('U.u');
    }
}
