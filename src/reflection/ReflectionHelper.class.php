<?php

class ReflectionHelper
{
	public function getAnnotations($docComment)
	{
		$result = new AnnotationCollection();

		if (preg_match_all('/@(.*?)\n/is', $docComment, $matches))
		{
			array_shift($matches);
			foreach ($matches[0] as $match)
			{
				$parts = explode(' ', $match);
				$x = new Annotation();
				$x->setName($parts[0]);

				if (count($parts) > 1)
				{
					for ($i = 1; $i!=count($parts); $i++)
					{
						$x->addValue($parts[$i]);
					}
				}

				$result->add($x);
			}
		}

		return $result;
	}

	public function hasAnnotation($docComment, $annotation)
	{
		return preg_match('/@'.$annotation.'\s?/', $docComment) == 1;
	}
}
