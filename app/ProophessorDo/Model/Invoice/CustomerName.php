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

use Assert\Assertion;
use Prooph\ProophessorDo\Model\ValueObject;

final class CustomerName implements ValueObject
{
    /**
     * @var string
     */
    private $name;

    public static function fromString(string $text): self
    {
        return new self($text);
    }

    private function __construct(string $text)
    {
        try {
            Assertion::minLength($text, 3);
        } catch (\Exception $e) {
            throw Exception\InvalidText::reason($e->getMessage());
        }

        $this->name = $text;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function sameValueAs(ValueObject $object): bool
    {
        return get_class($this) === get_class($object) && $this->name === $object->text;
    }
}
