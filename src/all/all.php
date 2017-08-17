<?php

namespace Dash;

/**
 * Checks whether $predicate returns truthy for every item in $iterable.
 *
 * @category Iterable
 * @param mixed $iterable
 * @param callable $predicate A callable invoked with ($value, $key) that returns a boolean
 * @return bool true if $predicate returns truthy for every item in $iterable
 *
 * @example
	all([1, 2, 3], function($n) { return $n > 5; });  // === false
	all([1, 3, 5], 'Dash\isOdd');  // === true
 */
function all($iterable, $predicate)
{
	return every($iterable, $predicate);
}
