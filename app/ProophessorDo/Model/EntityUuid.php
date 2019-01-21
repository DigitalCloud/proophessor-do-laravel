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

namespace Prooph\ProophessorDo\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class EntityUuid implements ValueObject
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate()
    {
        return new static(Uuid::uuid4());
    }

    public static function fromString(string $uuid)
    {
        return new static(Uuid::fromString($uuid));
    }

    public static function fromPayload( $uuid)
    {
        return self::fromString($uuid);
    }



    protected function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(ValueObject $other): bool
    {
        /* @var self $other */
        return get_class($this) === get_class($other) && $this->uuid->equals($other->uuid);
    }
}
