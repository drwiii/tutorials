<?php

//
// Modulo Tutorial in PHP
// Copyright (C) 2019, Douglas Winslow <winslowdoug@gmail.com>
//
// This nested loop shows the modulo operator in action.
// (Don't think of the percent symbol as being a percentage.)
// I made this so you'd understand the % in orioles.php.
//
// The first number is your input.
// The second number limits the input.
//
// Hint: Look at the results starting at the top.
//

$TALL = 9;
$WIDE = 8;

// when doing a chart, start with the vertical loop. (tall)
for ($b=0; $b<=$TALL; $b++)
{
	// nest the horizontal loops inside the vertical loop. (wide)

	for ($a=1; $a<=$WIDE; $a++) print str_repeat("-", 7) . ($a%$WIDE==0?"\n":" ");		// draw dashes to separate the cells of the chart
	for ($a=1; $a<=$WIDE; $a++) print "$a%$b=".($b%$a) . ($a%$WIDE==0?"\n":"\t");		// print modulo formula
	for ($a=1; $a<=$WIDE; $a++) print str_repeat($b%$a, $b%$a) . ($a%$WIDE==0?"\n":"\t");	// show how large a result
}

// Did you notice I have modulo deciding whether to print a newline or a tab?
// Bonus: Comment out the first two inner for() statements for a surprise.

print "\n";	// newline

?>
