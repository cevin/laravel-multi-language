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


        foreach ($reflector->getParameters() as $key => $parameter) {
            if (array_key_exists($parameter->getName(), $parameters)) {
                $arrangedParameters[$parameter->getName()] = $parameters[$parameter->getName()];
            }
        }

        return $arrangedParameters;
    }
}
