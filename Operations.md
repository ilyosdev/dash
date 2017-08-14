Table of contents
===
### Collection
- [all](#all)
- [each](#each)
- [get](#get)
- [map](#map)
- [mapValues](#mapvalues)
- [pluck](#pluck)
- [property](#property)

### Other
- [any](#any)
- [assertType](#asserttype)
- [at](#at)
- [average](#average)
- [chain](#chain)
- [compare](#compare)
- [contains](#contains)
- [deltas](#deltas)
- [difference](#difference)
- [display](#display)
- [dropWhile](#dropwhile)
- [equal](#equal)
- [every](#every)
- [filter](#filter)
- [find](#find)
- [findKey](#findkey)
- [findLast](#findlast)
- [findValue](#findvalue)
- [first](#first)
- [groupBy](#groupby)
- [identical](#identical)
- [identity](#identity)
- [indexBy](#indexby)
- [intersection](#intersection)
- [isEmpty](#isempty)
- [isEven](#iseven)
- [isOdd](#isodd)
- [join](#join)
- [keyBy](#keyby)
- [keys](#keys)
- [last](#last)
- [matches](#matches)
- [matchesProperty](#matchesproperty)
- [max](#max)
- [median](#median)
- [min](#min)
- [negate](#negate)
- [partial](#partial)
- [partialRight](#partialright)
- [pick](#pick)
- [reduce](#reduce)
- [reject](#reject)
- [reverse](#reverse)
- [set](#set)
- [size](#size)
- [sort](#sort)
- [sum](#sum)
- [take](#take)
- [takeRight](#takeright)
- [takeWhile](#takewhile)
- [tap](#tap)
- [thru](#thru)
- [toArray](#toarray)
- [union](#union)
- [values](#values)
- [where](#where)
- [without](#without)


Collection
===

all
---
```php
all($input, $predicate)
```
Checks whether $predicate returns truthy for every item in $input.
$predicate will be called with ($value, $key).


Name | Type | Description
--- | --- | ---
`$input` | `mixed` | Any iterable
`$predicate` | `callable` | 


**Example:** 
```php
all([1, 2, 3], function($n) { return $n < 3; });  // === false
all([1, 2, 3], function($n) { return $n < 4; });  // === true

all([1, 2, 3], 'Dash\isOdd');  // === false
all([1, 3, 5], 'Dash\isOdd');  // === true
```
each
---
```php
each($collection, $iteratee)
```
Iterates over a collection and calls an iteratee function for each element.

Any changes to the value, key, or collection from within the iteratee
function are not persisted. If the original collection needs to be mutated,
use a native `foreach` loop instead.


Name | Type | Description
--- | --- | ---
`$collection` | `array\|object` | 
`$iteratee` | `Callable` | Function called with (element, key, collection)


**Example:** 
```php
Dash\each(
	array(1, 2, 3),
	function($n) { echo $n; }
);  // Prints "123"
```
get
---
```php
get($collection, $path, $default)
```
Gets the value at a path on a collection.


Name | Type | Description
--- | --- | ---
`$collection` | `array\|object` | 
`$path` | `string` | Path of the property to retrieve; can be nested by delimiting each sub-property or array index with a period
`$default` | `mixed` | Default value to return if nothing exists at $path


**Example:** 
```php
$collection = array(
	'a' => array(
		'b' => 'value'
	)
);
Dash\get($collection, 'a.b') == 'value';

```

**Example:** Array elements can be referenced by index
```php
$collection = array(
	'people' => array(
		array('name' => 'Pete'),
		array('name' => 'John'),
		array('name' => 'Paul'),
	)
);
Dash\get($collection, 'people.1.name') == 'John';

```

**Example:** Keys with the same name as the full path can be used
```php
$collection = array('a.b.c' => 'value');
Dash\get($collection, 'a.b.c') == 'value';
```
map
---
```php
map($collection, $iteratee)
```
Creates a new indexed array of values by running each element in a
collection through an iteratee function.

Keys in the original collection are _not_ preserved; a freshly indexed array
is returned.


Name | Type | Description
--- | --- | ---
`$collection` | `array\|object` | 
`$iteratee` | `Callable\|string` | Function called with (element, key, collection)


**Example:** 
```php
Dash\map(
	array(1, 2, 3),
	function($n) {
		return $n * 2;
	}
) == array(2, 4, 6);

```

**Example:** 
```php
Dash\map(
	array('roses' => 'red', 'violets' => 'blue'),
	function($color, $flower) {
		return $flower . ' are ' . $color;
	}
) == array('roses are red', 'violets are blue');

```

**Example:** With $iteratee as a path
```php
Dash\map(
	array('color' => 'red', 'color' => 'blue'),
	'color'
) == array('red', 'blue');
```
mapValues
---
```php
mapValues($collection, $iteratee)
```
Creates a new array of values by running each element in a collection
through an iteratee function.

Keys in the original collection _are_ preserved.


Name | Type | Description
--- | --- | ---
`$collection` | `array\|object` | 
`$iteratee` | `Callable` | Function called with (element, key, collection)


**Example:** 
```php
Dash\map(
	array(1, 2, 3),
	function($n) { return $n * 2; }
) == array(2, 4, 6);

```

**Example:** 
```php
Dash\map(
	array('roses' => 'red', 'violets' => 'blue'),
	function($color, $flower) { return $flower . ' are ' . $color; }
) == array('roses' => 'roses are red', 'violets' => 'violets are blue');
```
pluck
---
```php
pluck($collection, $path)
```
Gets the value at a path for all elements in a collection.


Name | Type | Description
--- | --- | ---
`$collection` | `array\|object` | 
`$path` | `string` | Path of the property to retrieve; can be nested by delimiting each sub-property or array index with a period


**Example:** 
```php
Dash\pluck(
	array(
		array('a' => array('b' => 1)),
		array('a' => 'missing'),
		array('a' => array('b' => 3)),
		array('a' => array('b' => 4)),
	),
	'a.b',
	'default'
) == array(1, 'default', 3, 4);
```
property
---
```php
property($path, $default)
```
Creates a function that returns the value at a path on a collection.


Name | Type | Description
--- | --- | ---
`$path` | `string\|function` | Path of the property to retrieve; can be nested by delimiting each sub-property or array index with a period. If it is a function, the same function is returned.
`$default` | `mixed` | Default value to return if nothing exists at $path


**Example:** 
```php
$getter = Dash\property('a.b');
$collection = array(
	'a' => array(
		'b' => 'value'
	)
);
$getter($collection) == 'value';

```

**Example:** Array elements can be referenced by index
```php
$getter = Dash\property('people.1.name');
$collection = array(
	'people' => array(
		array('name' => 'Pete'),
		array('name' => 'John'),
		array('name' => 'Paul'),
	)
);
$getter($collection) == 'John';

```

**Example:** Keys with the same name as the full path can be used
```php
$getter = Dash\property('a.b.c');
$collection = array('a.b.c' => 'value');
$getter($collection) == 'value';
```

Other
===

any
---
```php
any()
```


Name | Type | Description
--- | --- | ---



assertType
---
```php
assertType()
```


Name | Type | Description
--- | --- | ---



at
---
```php
at()
```


Name | Type | Description
--- | --- | ---



average
---
```php
average()
```


Name | Type | Description
--- | --- | ---



chain
---
```php
chain()
```


Name | Type | Description
--- | --- | ---



compare
---
```php
compare()
```


Name | Type | Description
--- | --- | ---



contains
---
```php
contains()
```


Name | Type | Description
--- | --- | ---



deltas
---
```php
deltas()
```


Name | Type | Description
--- | --- | ---



difference
---
```php
difference()
```


Name | Type | Description
--- | --- | ---



display
---
```php
display()
```


Name | Type | Description
--- | --- | ---



dropWhile
---
```php
dropWhile()
```


Name | Type | Description
--- | --- | ---



equal
---
```php
equal()
```


Name | Type | Description
--- | --- | ---



every
---
```php
every()
```


Name | Type | Description
--- | --- | ---



filter
---
```php
filter()
```


Name | Type | Description
--- | --- | ---



find
---
```php
find()
```


Name | Type | Description
--- | --- | ---



findKey
---
```php
findKey()
```


Name | Type | Description
--- | --- | ---



findLast
---
```php
findLast()
```


Name | Type | Description
--- | --- | ---



findValue
---
```php
findValue()
```


Name | Type | Description
--- | --- | ---



first
---
```php
first()
```


Name | Type | Description
--- | --- | ---



groupBy
---
```php
groupBy()
```


Name | Type | Description
--- | --- | ---



identical
---
```php
identical()
```


Name | Type | Description
--- | --- | ---



identity
---
```php
identity()
```


Name | Type | Description
--- | --- | ---



indexBy
---
```php
indexBy()
```


Name | Type | Description
--- | --- | ---



intersection
---
```php
intersection()
```


Name | Type | Description
--- | --- | ---



isEmpty
---
```php
isEmpty()
```


Name | Type | Description
--- | --- | ---



isEven
---
```php
isEven()
```


Name | Type | Description
--- | --- | ---



isOdd
---
```php
isOdd()
```


Name | Type | Description
--- | --- | ---



join
---
```php
join()
```


Name | Type | Description
--- | --- | ---



keyBy
---
```php
keyBy()
```


Name | Type | Description
--- | --- | ---



keys
---
```php
keys()
```


Name | Type | Description
--- | --- | ---



last
---
```php
last()
```


Name | Type | Description
--- | --- | ---



matches
---
```php
matches()
```


Name | Type | Description
--- | --- | ---



matchesProperty
---
```php
matchesProperty()
```


Name | Type | Description
--- | --- | ---



max
---
```php
max()
```


Name | Type | Description
--- | --- | ---



median
---
```php
median()
```


Name | Type | Description
--- | --- | ---



min
---
```php
min()
```


Name | Type | Description
--- | --- | ---



negate
---
```php
negate()
```


Name | Type | Description
--- | --- | ---



partial
---
```php
partial()
```


Name | Type | Description
--- | --- | ---



partialRight
---
```php
partialRight()
```


Name | Type | Description
--- | --- | ---



pick
---
```php
pick()
```


Name | Type | Description
--- | --- | ---



reduce
---
```php
reduce()
```


Name | Type | Description
--- | --- | ---



reject
---
```php
reject()
```


Name | Type | Description
--- | --- | ---



reverse
---
```php
reverse()
```


Name | Type | Description
--- | --- | ---



set
---
```php
set()
```


Name | Type | Description
--- | --- | ---



size
---
```php
size()
```


Name | Type | Description
--- | --- | ---



sort
---
```php
sort()
```


Name | Type | Description
--- | --- | ---



sum
---
```php
sum()
```


Name | Type | Description
--- | --- | ---



take
---
```php
take()
```


Name | Type | Description
--- | --- | ---



takeRight
---
```php
takeRight()
```


Name | Type | Description
--- | --- | ---



takeWhile
---
```php
takeWhile()
```


Name | Type | Description
--- | --- | ---



tap
---
```php
tap()
```


Name | Type | Description
--- | --- | ---



thru
---
```php
thru()
```


Name | Type | Description
--- | --- | ---



toArray
---
```php
toArray()
```


Name | Type | Description
--- | --- | ---



union
---
```php
union()
```


Name | Type | Description
--- | --- | ---



values
---
```php
values()
```


Name | Type | Description
--- | --- | ---



where
---
```php
where()
```


Name | Type | Description
--- | --- | ---



without
---
```php
without()
```


Name | Type | Description
--- | --- | ---


