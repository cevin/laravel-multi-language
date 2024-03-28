<?php

namespace Cevin\LaravelMultiLanguage\Route;

use Illuminate\Routing\ControllerDispatcher;
use ReflectionFunctionAbstract;

class Dispatcher extends ControllerDispatcher
{
    /**
     * Refactor for resolveMethodDependencies
     * Resolve the given method's type-hinted dependencies.
     *
     * @param array $parameters
     * @param ReflectionFunctionAbstract $reflector
     * @return array
     */
    public function resolveMethodDependencies(array $parameters, ReflectionFunctionAbstract $reflector)
    {
        $arrangedParameters = [];

        $skippableValue = new \stdClass;

        foreach ($reflector->getParameters() as $key => $parameter) {
            $instance = $this->transformDependency($parameter, $parameters, $skippableValue);

            if ($instance !== $skippableValue) {
                $arrangedParameters[$parameter->getName()] = $instance;
            } else {
                $arrangedParameters[$parameter->getName()] = array_key_exists($parameter->getName(), $parameters) ? $parameters[$parameter->getName()] : ($parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null);
            }
        }

        return $arrangedParameters;
    }
}
