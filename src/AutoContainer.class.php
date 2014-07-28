<?php

/*
 * This code was originally taken from
 * https://gist.github.com/Xeoncross/2990773#file-ioc-php
 */

abstract class AutoContainer
{
	function __call($name, $arguments)
	{
		// magic methods would be called something like
		// getMyClass, which should become a call like
		// ioc->make('MyClass')
		$className = substr($name, 3);

		return $this->make($className);
	}

	// if a hinted class name is matched here
	// use the associated value as the new class
	private $constraints = array();

	protected function forClass($originalHinted, $newClass)
	{
		if (!array_key_exists($originalHinted, $this->constraints))
		{
			$this->constraints[$originalHinted] = $newClass;
		}
	}

	protected function make($object)
	{
		// parameters for the construct of object
		$objectParameters = array();

		// all the arguments passed to make
		// can be of any type
		$args = func_get_args();

		// skip the object name for the other types of parameters
		array_shift($args);

		if (is_string($object) && class_exists($object))
		{
			// defining class for the object we try to make
			$ref = new ReflectionClass($object);

			// object constructor
			$constructor = $ref->getConstructor();

			if ($constructor)
			{
				// constructor parameters
				$constructorParameters = $constructor->getParameters();

				$otherTypeParameterCounter = 0; // incremented only when the type of the arg is not a class
				foreach ($constructorParameters as $parameter)
				{

					// the parameter should be an instance of the hinted class
					$hintedClass = $parameter->getClass();
					if ($hintedClass != NULL)
					{
						$hintedClassName = $hintedClass->getName();

						// overridden hinted class
						if (array_key_exists($hintedClassName, $this->constraints))
						{
							$hintedClassName = $this->constraints[$hintedClassName];
						}

						// instantiate the class and add it to the
						// parameters list
						if (class_exists($hintedClassName))
						{
							// the hinted class could have hinted class parameters and other types as well
							$methodName = 'get'.$this->getNamespacedClassName($hintedClassName);
							$objectParameters[] = call_user_func(array($this , $methodName));
						}

					}
					else
					{
						// other type of parameter
						// found in the args array
						// these parameters are passed to the make function after
						// the object to create
						$objectParameters[] = $args[$otherTypeParameterCounter];
						$otherTypeParameterCounter++;
					}

				}

			}
			if (empty($objectParameters))
			{
				return new $object;
			}
			else
			{
				return $ref->newInstanceArgs($objectParameters);
			}


		}
		else
		{
			die("Invalid use of IOC, $object is not a class.");
		}
	}

	protected function getNamespacedClassName($className)
	{
		return str_replace('\\', '', $className);
	}
}
