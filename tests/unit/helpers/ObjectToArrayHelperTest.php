<?php

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class ObjectToArrayHelperTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var ObjectToArrayHelper
	 */
	private $testMe;

	/**
	 * @var ReflectionHelper
	 */
	private $reflectionHelper;

	public function setup()
	{
		$this->reflectionHelper = new ReflectionHelper();
		$this->testMe = new ObjectToArrayHelper($this->reflectionHelper);
	}

	public function test_simple_noChildren()
	{
		$actual = $this->testMe->toArray(new SimpleNoChildren());
		$this->assertArrayHasKey('string', $actual);
		$this->assertEquals('string', $actual['string']);

		$this->assertArrayHasKey('int', $actual);
		$this->assertEquals(3, $actual['int']);

		$this->assertArrayHasKey('float', $actual);
		$this->assertEquals(3.3, $actual['float']);

		$this->assertArrayHasKey('boolTrue', $actual);
		$this->assertEquals(true, $actual['boolTrue']);

		$this->assertArrayHasKey('boolFalse', $actual);
		$this->assertEquals(false, $actual['boolFalse']);

		$this->assertArrayNotHasKey('ignored', $actual);
	}

	public function test_simple_oneChild()
	{
		$actual = $this->testMe->toArray(new SimpleWithChild());

		$this->assertArrayHasKey('inParent', $actual);
		$this->assertEquals('oh yes indeed', $actual['inParent']);

		$child = SimpleNoChildren::toArray();

		$this->assertArrayHasKey('child', $actual);
		$this->assertEquals($child, $actual['child']);
	}

	public function test_withList()
	{
		$actual = $this->testMe->toArray(new WithList());

		$list = array(
			array(
				'inParent' => 'oh yes indeed'
			, 'child' => SimpleNoChildren::toArray()
			)
		);

		$this->assertArrayHasKey('list', $actual);
		$this->assertEquals($list, $actual['list']);
	}
}


/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class SimpleNoChildren
{
	private $string = "string";
	protected $int = 3;
	public $float = 3.3;
	protected $boolTrue = true;
	protected $boolFalse = FALSE;

	/**
	 * @jsonIgnore
	 */
	private $ignored = "ignore me";

	public static function toArray()
	{
		return array(
			'string' => 'string'
		, 'int' => 3
		, 'float' => 3.3
		, 'boolTrue' => true
		, 'boolFalse' => false
		);
	}
}

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class SimpleWithChild
{
	private $inParent = "oh yes indeed";
	private $child;

	public function __construct()
	{
		$this->child = new SimpleNoChildren();
	}
}

/** @noinspection PhpMultipleClassesDeclarationsInOneFile */
class WithList
{
	private $list;

	public function __construct()
	{
		$this->list = array(new SimpleWithChild());
	}
}