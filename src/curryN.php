<?php

namespace Dash;

/**
 * Creates a new function that returns the result of `$callable` if the required number of parameters are supplied;
 * otherwise, it returns a function that accepts the remaining number of required parameters.
 *
 * Use `Dash\_` as a placeholder to replace with arguments from subsequent calls.
 *
 * @see curry()
 *
 * @param callable $callable
 * @param integer $numRequiredArgs The number of parameters to require before calling `$callable`
 * @codingStandardsIgnoreLine
 * @param mixed ...$args (optional, variadic) arguments to pass to `$callable`
 * @return function|mixed
 *
 * @example
	$greet = function ($greeting, $salutation, $name, $punctuation = '!') {
		return "$greeting, $salutation $name$punctuation";
	};

	$goodMorning = Dash\curryN($greet, 3, 'Good morning');
	$goodMorning('Ms.', 'Mary');
	// === 'Good morning, Ms. Mary!'

	$goodMorning = Dash\curryN($greet, 3, 'Good morning');
	$goodMorningSir = $goodMorning('Sir');
	$goodMorningSir('Peter');
	// === 'Good morning, Sir Peter!'

 * @example With placeholders
	$greet = function ($greeting, $salutation, $name, $punctuation = '!') {
		return "$greeting, $salutation $name$punctuation";
	};

	$greetSir = Dash\curryN($greet, 3, Dash\_, 'Sir');
	$goodMorningSir = $greetSir('Good morning');
	$goodMorningSir('Peter');
	// === 'Good morning, Sir Peter!'

	$greetMary = Dash\curryN($greet, 3, Dash\_, Dash\_, 'Mary');
	$greetMsMary = $greetMary(Dash\_, 'Ms.');
	$greetMsMary('Good morning');
	// === 'Good morning, Ms. Mary!'
 */
function curryN(callable $callable, $numRequiredArgs /*, ...args */)
{
	$args = func_get_args();
	array_shift($args);  // Removes $callable
	array_shift($args);  // Removes $numRequiredArgs

	$numNonPlaceholderArgs = chain($args)
		->reject(function ($arg) { return $arg === _; })
		->count()
		->value();

	if ($numNonPlaceholderArgs >= $numRequiredArgs) {
		$callableArgs = [];

		// Replaces placeholders with arguments from the end, in order
		$deferredArgs = array_slice($args, $numRequiredArgs);
		while ($args) {
			$arg = array_shift($args);
			$callableArgs[] = ($arg === _) ? array_shift($deferredArgs) : $arg;
		}

		$callableArgs = array_slice($callableArgs, 0, $numRequiredArgs);
		return call_user_func_array($callable, $callableArgs);
	}

	$curried = function () use ($callable, $numRequiredArgs, $args) {
		$nextArgs = func_get_args();
		$curryArgs = [$callable, $numRequiredArgs];

		// Replaces placeholders from previous argument list with any available arguments
		while ($args || $nextArgs) {
			if ($args) {
				$arg = array_shift($args);
				$curryArgs[] = ($arg === _ && $nextArgs) ? array_shift($nextArgs) : $arg;
			}
			elseif ($nextArgs) {
				$curryArgs[] = array_shift($nextArgs);
			}
		}

		return call_user_func_array('Dash\curryN', $curryArgs);
	};

	return $curried;
}
