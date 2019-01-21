<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/20/19
 * Time: 2:58 PM
 */

namespace App\ProophessorDo\Model;

use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\ProophessorDo\Model\Entity;
use Prooph\ProophessorDo\Model\EntityUuid;
use ReflectionClass;

class BaseEntity extends AggregateRoot implements Entity
{
    /* @var EntityUuid $uuid */
    protected $uuid;

    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }

    public function sameIdentityAs(Entity $other): bool
    {
        return get_class($this) === get_class($other) && $this->uuid->sameValueAs($other->uuid);
    }

    public function __get($name)
    {
        if(property_exists($this,$name)){
            return $this->$name;
        }

        $reflect = new ReflectionClass($this);
        $shortName = $reflect->getShortName();
        if($name == strtolower($shortName)."Id"){
            return $this->uuid;
        }

        throw new \Exception("field $name not supported");
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);

        if (! method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }

        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        return 'when' . implode(array_slice(explode('\\', get_class($e)), -1));
    }
}
