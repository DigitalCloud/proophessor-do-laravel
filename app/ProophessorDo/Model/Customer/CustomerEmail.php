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
 * @property string email
 */
final class CustomerEmail implements ValueObject
{
    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromString($email) : CustomerEmail
    {
        return new self($email);
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return $this->email == $object->email;
    }

    public function toString()
    {
        return $this->email;
    }

    public static function fromPayload($payload)
    {
        return self::fromString($payload);
    }
}
