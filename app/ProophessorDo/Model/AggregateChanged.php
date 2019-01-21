<?php
/**
 * Created by PhpStorm.
 * User: devmsh
 * Date: 1/21/19
 * Time: 12:45 AM
 */

namespace App\ProophessorDo\Model;

use Prooph\EventSourcing\AggregateChanged as BaseAggregateChanged;

class AggregateChanged extends BaseAggregateChanged
{
//    public function __get($name)
//    {
//        if(property_exists($this,$name)){
//            $class = new \ReflectionClass($this);
//            $prop = $class->getProperty($name);
//            dd($prop);
//            $prop = get_class($this->$name);
//            $value = call_user_func($prop."::fromPayload",$this->payload[snake_case($name)]);
//            return $value;
//        }
//
//        throw new \Exception("field $name not supported");
//    }
}
