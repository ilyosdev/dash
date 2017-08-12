<?php

use Dash\Collections;
use Dash\Container;

class averageTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider casesForAverage
	 */
	public function testStandaloneAverage($collection, $expected)
	{
		$actual = Collections\average($collection);
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @dataProvider casesForAverage
	 */
	public function testChainedAverage($collection, $expected)
	{
		$container = new Container($collection);
		$actual = $container->average()->value();
		$this->assertEquals($expected, $actual);
	}

	public function casesForAverage()
	{
		return array(

			/*
				With array
			 */

			'should return zero for an empty array' => array(
				array(),
				0
			),
			'should return the average of the values of an array' => array(
				array(2, 3, 5, 8),
				4.5
			),

			/*
				With stdClass
			 */

			'should return zero for an empty stdClass' => array(
				(object) array(),
				0
			),
			'should return the average of the values of an stdClass' => array(
				(object) array(2, 3, 5, 8),
				4.5
			),

			/*
				With ArrayObject
			 */

			'should return zero for an empty ArrayObject' => array(
				new ArrayObject(array()),
				0
			),
			'should return the average of the values of an ArrayObject' => array(
				new ArrayObject(array(2, 3, 5, 8)),
				4.5
			),
		);
	}
}