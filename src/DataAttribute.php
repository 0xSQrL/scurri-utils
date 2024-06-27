<?php
namespace Scurriio\Utils;

use ReflectionAttribute;

class AttributeNotAssignedException extends \Exception{
    public function __construct(public \ReflectionClass | \ReflectionProperty | \ReflectionMethod $effects, public string $attributeClass)
    {
        $propName = $effects->getName();
        parent::__construct("Programmatic entity \"$propName\" has no attribute \"$attributeClass\"");
    }
}

trait DataAttribute
{
    public \ReflectionClass | \ReflectionProperty | \ReflectionMethod $effects;

    /**
     * Returns the first attribute of this type on the class/property/method
     * @throws AttributeNotAssignedException
     * @return static
     */
    public static function getAttr(\ReflectionClass | \ReflectionProperty | \ReflectionMethod $property)
    {

        $attribute = static::tryGetAttr($property);
        if (!isset($attribute)) {
            throw new AttributeNotAssignedException($property, static::class);
        }
        return $attribute;
    }

    /**
     * Returns the first attribute of this type on the class/property/method
     * @return static|null
     */
    public static function tryGetAttr(\ReflectionClass | \ReflectionProperty | \ReflectionMethod $property): ?self
    {
        $attributes = $property->getAttributes(static::class);
        if (count($attributes) == 0) {
            return null;
        }
        $attribute = $attributes[0]->newInstance();
        static::initializeFor($attribute, $property);
        return $attribute;
    }

    /**
     * Returns all attributes of this type on the class/property/method
     * @return static[]
     */
    public static function getMany(\ReflectionClass | \ReflectionProperty | \ReflectionMethod $property): array{
        return array_map(function(ReflectionAttribute $attr) use ($property){
            $attribute = $attr->newInstance();
            static::initializeFor($attribute, $property);
        }, $property->getAttributes(static::class));
    }

    public static function initializeFor($attr, \ReflectionClass | \ReflectionProperty | \ReflectionMethod $property){
        $attr->effects = $property;
        $attr->initialize();
    }

    /**
     * A constructor after `$this->effects` has been set
     */
    protected abstract function initialize();
}
