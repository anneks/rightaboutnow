<?php

class RouteSetter
{
	/**
	 * @var Slim\Slim
	 */
	private $app;
	/**
	 * @var ReflectionHelper
	 */
	private $reflectionHelper;
	/**
	 * @var AutoContainer
	 */
	private $container;
	/**
	 * @var FileSystem
	 */
	private $fileSystem;

	public function __construct(
		\Slim\Slim $app
		, ReflectionHelper $reflectionHelper
		, AutoContainer $container
		, FileSystem $fileSystem
	)
	{
		$this->app = $app;
		$this->reflectionHelper = $reflectionHelper;
		$this->container = $container;
		$this->fileSystem = $fileSystem;
	}

	public function addRoutes($controllerDirectory)
	{
		$controllers = $this->getControllers($controllerDirectory);

		foreach ($controllers as $controllerClassName)
		{
			$this->addRouteForController($controllerClassName);
		}
	}

	private function getControllers($controllerDirectory)
	{
		$result = array();

		/**
		 * @var $file SplFileInfo
		 */
		foreach ($this->fileSystem->getFilesRecursively($controllerDirectory) as $file)
		{
			if (preg_match('/([a-z0-9]+Controller).class.php/i', $file->getFilename(), $matches))
			{
				$result[] = $matches[1];
			}
		}

		return $result;
	}

	private function addRouteForController($controllerClass)
	{
		$ref = new ReflectionClass($controllerClass);
		$annotations = $this->reflectionHelper->getAnnotations($ref->getDocComment());

		// these are used by the generated code
		/** @noinspection PhpUnusedLocalVariableInspection */
		$container = $this->container;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$app = $this->app;

		$middlewareAnnotations = $annotations->getWithName('middleware');


		foreach ($annotations->getWithName('route') as $ano)
		{
			$builder = new RouteBuilder();
			$values = $ano->getValues();
			$builder->setMethod(strtolower($values[0]));
			$builder->setControllerName($controllerClass);
			$builder->setRoute($values[1]);

			preg_match_all('/\/:([a-z0-9]+)/i', $values[1], $matches);
			foreach ($matches[1] as $match)
			{
				$builder->addParam($match);
			}

			foreach ($middlewareAnnotations as $midAno)
			{
				$midValues = $midAno->getValues();
				$builder->addMiddleware($midValues[0]);
			}

			eval($builder->render());
		}
	}
}
