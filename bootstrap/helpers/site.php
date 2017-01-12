<?php


/**
 * Create and run __invoke on a given command.
 * The parameters should be in the same
 * order as they appear in the
 * command's constructor.
 *
 * @param string $class
 * @param array  ...$parameters
 *
 * @return mixed
 */
function command($class, ...$parameters)
{
    // Reflect the called class and get the constructor parameters.
    $reflector            = new ReflectionClass($class);
    $dependencies         = $reflector->getConstructor()->getParameters();
    $allArgumentsProvided = count($dependencies) === count($parameters);
    $arguments            = [];

    foreach ($dependencies as $dependency) {
        // If the dependency is type hinted, the container will resolve it for us.
        if (! is_null($dependency->getClass()) && ! $allArgumentsProvided) {
            continue;
        }

        // Otherwise, grab the first item passed and set it to the dependency name
        // then remove it from the parameter list.
        $arguments[$dependency->name] = head($parameters);
        array_shift($parameters);
    }

    // Invoke the command.
    $command = app($class, $arguments);

    return $command();
}

function displayFlag($flag, $positiveMessage = 'Yes', $negativeMessage = 'No')
{
    if ($flag) {
        return $positiveMessage;
    }

    return $negativeMessage;
}

function displayIcon($flag, $colorize = true, $positiveIcon = 'check-circle', $negativeIcon = 'times-circle')
{
    if ($flag) {
        $color = $colorize ? 'text-green' : '';

        return '<i class="fa fa-fw fa-' . $positiveIcon . ' ' . $color . '"></i>';
    }

    $color = $colorize ? 'text-red' : '';

    return '<i class="fa fa-fw fa-' . $negativeIcon . ' ' . $color . '"></i>';
}
