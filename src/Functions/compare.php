<?php

namespace Dash\Functions;

function compare($a, $b)
{
	if ($a == $b) {
		return 0;
	}
	elseif ($a > $b) {
		return +1;
	}
	else {
		return -1;
	}
}