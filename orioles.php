#!/usr/bin/php -q
<?php

//
// Array Tutorial in PHP
// Copyright (C) 2019, Douglas Winslow <winslowdoug@gmail.com>
//
// This was written to run on the command line via php-cli:
//	sudo apt install php-cli
//	php orioles.php
//
// If you want to try this on a web server, load this page and use your
// web browser's View Source command to view the output.
//
// It was always fun to read easy programming examples in magazines in
// the 1980s.  To recreate the learning potential, how about demos?
// Start with this tutorial that shows how to set and recall variables,
// and also arrays.
//
// This demo shows how to set up an old-style data array. (I think this
// is more convenient than the nested array() statements that PHP can
// support.)  There are more complicated ways to do most of this, but
// try to grasp the basics before you move on to more difficult tasks.
// You will find that PHP has many ways to do one thing, so make a
// list of the functions you want to use, and try to keep focused on
// editing one line at a time.
//

// The goal is to list each player with their position and number.

// Define the team
$year = 1983;
$city = "Baltimore";
$team = "Orioles";
$roster = array(

	-1, "pitcher",		///
	52, "Mike Boddicker",
	34, "Storm Davis",
	46, "Mike Flanagan",
	30, "Dennis Martinez",
	23, "Tippy Martinez",
	16, "Scott McGregor",
	39, "Paul Mirabella",
	21, "Dan Morogiello",
	22, "Jim Palmer",
	36, "Allan Ramirez",
	53, "Sammy Stewart",
	49, "Tim Stoddard",
	32, "Bill Swaggerty",
	51, "Don Welchel",

	-1, "catcher",		///
	24, "Rick Dempsey",
	18, "Dave Huppert",
	17, "Joe Nolan",
	9, "John Stefero",

	-1, "infielder",	///
	2, "Bobby Bonner",
	10, "Todd Cruz",
	25, "Rich Dauer",
	11, "Glenn Gulliver",
	3, "Leo Hernandez",
	33, "Eddie Murray",
	8, "Cal Ripken, Junior",
	6, "Aurelio Rodriguez",
	12, "Lenn Sakata",

	-1, "outfielder",	///
	27, "Benny Ayala",
	1, "Al Bumbry",
	28, "Jim Dwyer",
	15, "Dan Ford",
	39, "Tito Landrum",
	38, "John Lowenstein",
	35, "Gary Roenicke",
	37, "John Shelby",
	43, "Mike Young",

	-1, "batter",		///
	29, "Ken Singleton",

	-1, "manager",		///
	26, "Joe Altobelli",

	-1, "coach",		///
	44, "Elrod Hendricks",
	31, "Ray Miller",
	47, "Cal Ripken, Senior",
	54, "Ralph Rowe",
	40, "Jimmy Williams",

	-1, "bench warmer",	///
	100, "The Oriole Bird"
);

// uncomment the next line to see the flat sequential data of the roster.
//print_r($roster); exit;

// Below is a loader for the above roster array.
// A loop prepares the player list for the announcer.
//
// The -1s above set this up to store a header for the players that follow.
// Upon the loader encountering a -1, it stores the next array element as
// a header, so it can set that as each following player's position.

// Load the roster
$c = 0;	// initialize our counter.
while (isset($roster[$c]))	// while we have roster data at the counter..
{
	if ($roster[$c] < 0)	// is the number a header? (-1)
	{
		//			// if so, don't store the number
		$c++;			// increment, to get the name of the position after the -1.
		$heading = $roster[$c];	// store the text at the counter's location into $heading
		$c++;			// increment, to set up for the next loop.
	}
	else			// it must be a player number
	{
		$number = $roster[$c];		// store the number
		$c++;				// increment, to get the name.
		$name[$number] = $roster[$c];	// $name[#] = their name.
		$position[$number] = $heading;	// $position[#] = the $heading we stored when we found -1.
		$c++;				// increment, to set up for the next loop.
	}
}	// loop.
// at this point, when the loop completes, we have read the entire array.

// uncomment the next line to see what the above loader set up for use: two separate arrays based on the roster.
//print_r($position); print_r($name); exit;

// Announce the players
print "\n";
print "And now, please welcome to the screen, ";
print "your ".$year." ".strtoupper($city." ".$team)."!\n\n";
for ($n=1; $n<=100; $n++)
{
	if (isset($name[$n]))
	{
		if ($n == 100) print "And, last, but not yet least.. ";
		print "#".($n%100).", ".$position[$n]." ".strtoupper($name[$n]).".\n";

//		usleep(3 * 1000000);	// pause for applause
//		if ($n == 8) sleep(5);	// cal ripken is popular, so here, please notice that the software assumes cal junior is also.
	}
	else if (!isset($y) and rand(0,1000) < 10)
	{
		if ($n != 4 and $n != 5 and $n != 20) $y = $n;	// exempt retired player numbers circa 1983
	}
}
print "\n";

// Offer sports commentary
if ($year." ".$city." ".$team == "1983 Baltimore Orioles")
{
	print "This team would go on to win the world series.\n";
	print "The Baltimore Orioles: A Professional Corporation.\n";
}

if (isset($y)) print "\n(You have been offered honorary uniform number ".$y.".)\n";

print "\n";

?>
