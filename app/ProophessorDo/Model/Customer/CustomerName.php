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

namespace Prooph\ProophessorDo\Model\Customer;


use Prooph\ProophessorDo\Model\ValueObject;

/**
 * @property string name
 */
final class CustomerName implements ValueObject
{
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromString($name) : CustomerName
    {
        return new self($name);
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return $this->name == $object->name;
    }

    public function toString()
    {
        return $this->name;
    }

    public static function fromPayload($payload)
    {
        return self::fromString($payload);
    }
}
