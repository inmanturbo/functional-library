<?php

namespace Inmanturbo\FunctionalLibrary;

trait HasFunctionalLibrary
{
    /**
     * @return mixed[]
     */
    public static function options(array $options): array
    {
        $closures = static::closures();
        $result = [];

        foreach ($options as $key => $value) {
            if ($value && isset($closures[$key])) {
                $result[$key] = $closures[$key];
            }
        }

        return $result;
    }

    abstract public static function closures();

    abstract public static function library();

    public static function getLibrary(...$args)
    {
        $reflection = new \ReflectionMethod(self::class, 'library');
        $parameters = $reflection->getParameters();
        $args = func_get_args();
        $options = [];

        foreach ($parameters as $index => $param) {
            match (true) {
                isset($args[$index]) => $options[$param->getName()] = $args[$index],
                default => $options[$param->getName()] = $param->isDefaultValueAvailable()
                    ? $param->getDefaultValue()
                    : null,
            };
        }

        if (count(array_filter($options)) == 0 || $args === []) {
            return array_values(self::closures());
        }

        $result = self::options($options);

        if (count($result) === 1) {
            return reset($result);
        }

        return array_values($result);
    }
}
