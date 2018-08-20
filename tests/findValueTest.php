<?php

/**
 * @covers Dash\findValue
 * @covers Dash\Curry\findValue
 */
class findValueTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @dataProvider cases
	 */
	public function test($iterable, $predicate, $expected)
	{
		$this->assertEquals($expected, Dash\findValue($iterable, $predicate));
	}

	/**
	 * @dataProvider cases
	 */
	public function testCurried($iterable, $predicate, $expected)
	{
		$findValue = Dash\Curry\findValue($predicate);
		$this->assertEquals($expected, $findValue($iterable));
	}

	public function cases()
	{
		return [
			'With null' => [
				'iterable' => null,
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an empty array' => [
				'iterable' => [],
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],

			/*
				With indexed array
			 */

			'With an indexed array with no elements that satisfy the predicate' => [
				'iterable' => [2, 4, 6, 8],
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an indexed array with one element that satisfies the predicate' => [
				'iterable' => [2, 4, 5, 6],
				'predicate' => 'Dash\isOdd',
				'expected' => 5,
			],
			'With an indexed array with several elements that satisfy the predicate' => [
				'iterable' => [2, 3, 4, 7],
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an indexed array with all elements that satisfy the predicate' => [
				'iterable' => [1, 3, 5, 7],
				'predicate' => 'Dash\isOdd',
				'expected' => 1,
			],
			'With an indexed array and matchesProperty($field) shorthand' => [
				'iterable' => [
					['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => 'active',
				'expected' => ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
			],
			'With an indexed array and matchesProperty($field, $value) shorthand' => [
				'iterable' => [
					['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => ['active', false],
				'expected' => ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
			],

			/*
				With associative array
			 */

			'With an associative array with no elements that satisfy the predicate' => [
				'iterable' => ['a' => 2, 'b' => 4, 'c' => 6, 'd' => 8],
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an associative array with one element that satisfies the predicate' => [
				'iterable' => ['a' => 2, 'b' => 4, 'c' => 5, 'd' => 6],
				'predicate' => 'Dash\isOdd',
				'expected' => 5,
			],
			'With an associative array with several elements that satisfy the predicate' => [
				'iterable' => ['a' => 2, 'b' => 3, 'c' => 4, 'd' => 7],
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an associative array with all elements that satisfy the predicate' => [
				'iterable' => ['a' => 1, 'b' => 3, 'c' => 5, 'd' => 7],
				'predicate' => 'Dash\isOdd',
				'expected' => 1,
			],
			'With an associative array and matchesProperty($field) shorthand' => [
				'iterable' => [
					'a' => ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					'b' => ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					'c' => ['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					'd' => ['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => 'active',
				'expected' => ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
			],
			'With an associative array and matchesProperty($field, $value) shorthand' => [
				'iterable' => [
					'a' => ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					'b' => ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					'c' => ['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					'd' => ['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => ['active', false],
				'expected' => ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
			],

			/*
				With stdClass
			 */

			'With an empty stdClass' => [
				'iterable' => (object) [],
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an stdClass with no elements that satisfy the predicate' => [
				'iterable' => (object) ['a' => 2, 'b' => 4, 'c' => 6],
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an stdClass with one element that satisfies the predicate' => [
				'iterable' => (object) ['a' => 2, 'b' => 3, 'c' => 6],
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an stdClass with several elements that satisfy the predicate' => [
				'iterable' => (object) ['a' => 2, 'b' => 3, 'c' => 4, 'd' => 7],
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an stdClass with all elements that satisfy the predicate' => [
				'iterable' => (object) ['a' => 1, 'b' => 3, 'c' => 5],
				'predicate' => 'Dash\isOdd',
				'expected' => 1,
			],
			'With an stdClass and matchesProperty($field) shorthand' => [
				'iterable' => (object) [
					'a' => (object) ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					'b' => (object) ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					'c' => (object) ['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					'd' => (object) ['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => 'active',
				'expected' => (object) ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
			],
			'With an stdClass and matchesProperty($field, $value) shorthand' => [
				'iterable' => (object) [
					'a' => (object) ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
					'b' => (object) ['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true],
					'c' => (object) ['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false],
					'd' => (object) ['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true],
				],
				'predicate' => ['active', false],
				'expected' => (object) ['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false],
			],

			/*
				With ArrayObject
			 */

			'With an empty ArrayObject' => [
				'iterable' => new ArrayObject([]),
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an ArrayObject with no elements that satisfy the predicate' => [
				'iterable' => new ArrayObject(['a' => 2, 'b' => 4, 'c' => 6]),
				'predicate' => 'Dash\isOdd',
				'expected' => null,
			],
			'With an ArrayObject with one element that satisfies the predicate' => [
				'iterable' => new ArrayObject(['a' => 2, 'b' => 3, 'c' => 6]),
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an ArrayObject with several elements that satisfy the predicate' => [
				'iterable' => new ArrayObject(['a' => 2, 'b' => 3, 'c' => 4, 'd' => 7]),
				'predicate' => 'Dash\isOdd',
				'expected' => 3,
			],
			'With an ArrayObject with all elements that satisfy the predicate' => [
				'iterable' => new ArrayObject(['a' => 1, 'b' => 3, 'c' => 5]),
				'predicate' => 'Dash\isOdd',
				'expected' => 1,
			],
			'With an ArrayObject and matchesProperty($field) shorthand' => [
				'iterable' => new ArrayObject([
					'a' => new ArrayObject(['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false]),
					'b' => new ArrayObject(['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true]),
					'c' => new ArrayObject(['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false]),
					'd' => new ArrayObject(['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true]),
				]),
				'predicate' => 'active',
				'expected' => new ArrayObject(['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true]),
			],
			'With an ArrayObject and matchesProperty($field, $value) shorthand' => [
				'iterable' => new ArrayObject([
					'a' => new ArrayObject(['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false]),
					'b' => new ArrayObject(['name' => 'Jane', 'age' => 27, 'gender' => 'female', 'active' => true]),
					'c' => new ArrayObject(['name' => 'Kane', 'age' => 33, 'gender' => 'male', 'active' => false]),
					'd' => new ArrayObject(['name' => 'Pete', 'age' => 35, 'gender' => 'male', 'active' => true]),
				]),
				'predicate' => ['active', false],
				'expected' => new ArrayObject(['name' => 'John', 'age' => 30, 'gender' => 'male', 'active' => false]),
			],
		];
	}

	public function testPredicateArgs()
	{
		$iterable = ['a' => 2, 'b' => 4, 'c' => 7];
		$iterated = [];

		$predicate = function ($value, $key, $passedIterable) use (&$iterated, $iterable) {
			$iterated[$key] = $value;
			$this->assertSame($iterable, $passedIterable);
			return $value % 2 !== 0;
		};

		$result = Dash\findValue($iterable, $predicate);

		$this->assertSame(7, $result);
		$this->assertSame($iterable, $iterated);
	}

	public function testShortCircuiting()
	{
		$iterated = [];
		$predicate = function ($value, $key) use (&$iterated) {
			$iterated[$key] = $value;
			return $value % 2 !== 0;
		};

		$iterable = ['a' => 2, 'b' => 3, 'c' => 4];
		$result = Dash\findValue($iterable, $predicate);

		$this->assertSame(3, $result);
		$this->assertSame(['a' => 2, 'b' => 3], $iterated);
	}

	/**
	 * @dataProvider casesDefaultPredicate
	 */
	public function testDefaultPredicate($iterable, $expected)
	{
		$this->assertSame($expected, Dash\findValue($iterable));
	}

	public function casesDefaultPredicate()
	{
		return [
			'With an empty array' => [
				'iterable' => [],
				'expected' => null,
			],
			'With an array of truthy values' => [
				'iterable' => ['a', true, 1],
				'expected' => 'a'
			],
			'With an array of falsey values' => [
				'iterable' => [0, false, ''],
				'expected' => null,
			],
			'With an array of values with mixed truthiness' => [
				'iterable' => [0, false, true],
				'expected' => true,
			],
		];
	}

	/**
	 * @dataProvider casesTypeAssertions
	 * @expectedException InvalidArgumentException
	 */
	public function testTypeAssertions($iterable, $type)
	{
		try {
			Dash\findValue($iterable);
		}
		catch (Exception $e) {
			$this->assertSame(
				"Dash\\findValue expects iterable or stdClass or null but was given $type",
				$e->getMessage()
			);
			throw $e;
		}
	}

	public function casesTypeAssertions()
	{
		return [
			'With an empty string' => [
				'iterable' => '',
				'type' => 'string',
			],
			'With a string' => [
				'iterable' => 'hello',
				'type' => 'string',
			],
			'With a zero number' => [
				'iterable' => 0,
				'type' => 'integer',
			],
			'With a number' => [
				'iterable' => 3.14,
				'type' => 'double',
			],
			'With a DateTime' => [
				'iterable' => new DateTime(),
				'type' => 'DateTime',
			],
		];
	}

	public function testExamples()
	{
		$this->assertSame(
			2,
			Dash\findValue(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], 'Dash\isEven')
		);
		$this->assertSame(
			3,
			Dash\findValue(
				['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4],
				function ($value, $key) { return $value > 1 && $key !== 'b'; }
			)
		);
		$this->assertSame(
			'a',
			Dash\findValue([0, null, false, 'a', true])
		);

		$data = [
			['name' => 'John', 'active' => false],
			['name' => 'Mary', 'active' => true],
			['name' => 'Pete', 'active' => true],
			['name' => 'Jane', 'active' => false],
		];
		$this->assertSame(
			['name' => 'Mary', 'active' => true],
			Dash\findValue($data, 'active')
		);
		$this->assertSame(
			['name' => 'John', 'active' => false],
			Dash\findValue($data, ['active', false])
		);
	}
}