#!/usr/bin/php -q
<?php

// Bases Loaded oriole [drw 08-Sep-2021]

$a = file_get_contents("Bases Loaded (U).nes");	// 327696 bytes

$m = "BASES LOADED";
if (substr($a, hexdec("2FFF4"), 12) != $m)
{
	$b = 4014954755;
	$c = crc32($a);

	if ($b != $c)
		print "check file. (expected ".$b.", found ".$c.")";
	else
		print "couldn't find magic phrase.";

	print "\n";
	exit;
}

print $m."\n\n";

// Define the Bases Loaded printable character table
$BLT=array();
for ($i=hexdec("1BD35"); $i<=hexdec("1BD4E"); $i++) $BLT[strtoupper(dechex(ord($a[$i])))] = chr(ord("A")+count($BLT));
$BLT[2] = " ";
$BLT['2C'] = ".";
//check($a, 0, strlen($a));

// CHECK()
//  it's a hexadecimal dumper, similar to hexdump -C, but for people who left
//  their expensive compilers at home.
//
// imported from fdsoriole
// this is a patched version to decode using the bases loaded character table
//
function check($data, $offset, $length, $cite=-1)
{
	global $BLT;

	$bytes = 0;
	$display = "";
	print "\n* check @ byte ".$offset." length ".$length." cite ".$cite."\n{\n        ";
	for ($i=0; $i<=(strlen($data)<16?strlen($data)-1:15); $i++) print " ".dechex($i)." ";
	if ($cite >= 0) print "  ".str_repeat(" ", $cite%16)."V";

	for ($i=0; $i<$length; $i++)
	{
		$byte = $offset + $i;
		if ($bytes%16 == 0)
		{
			print ($i ? " ".$display.( ($bytes-$cite >= 1 and $bytes-$cite <= 16) ?"<":""):"");
//			print "  ".($bytes-$cite);
			print "\n ".bend(dechex($byte),5).": ";
			$display = "";
		}
		$bytes++;
		if (isset($data[$byte]))
		{
			$a = bend(dechex(ord($data[$byte])),2);
//			$display .= ( (ord($data[$byte]) >= 32 and ord($data[$byte]) <= 126) ? chr(hexdec($a)) : "`");
			$O = strtoupper(dechex(ord($data[$byte])));
			if (isset($BLT[$O])) $display .= $BLT[$O]; else $display .= " ";
			print ($cite == $i?"'":" ").$a;
		}
		if ($bytes%8 == 0) print " ";
	}
	print " ".$display;
//	print "  ".($bytes-$cite);
	print "\n}\n";
}

// BEND()
//  bend hex output into an agreeable and harumph-compatible output.
//
function bend($input, $x=2)
{
	return(substr("00000000".strtoupper($input), -$x));
}

// dump the team list
for ($team=0; $team<=11; $team++)
{
	$leaguebase = hexdec("191D8");
	$teambase = hexdec("18E12");
	$teamnamebase = hexdec("18E4C");
//	$avgbase = hexdec("1E406");
//	$namebase = hexdec("11EF0");
	$namebase = hexdec("11EF0") + ($team * 180);
//	$avgbase = hexdec("1E406") - 80;	//1
//	$avgbase = hexdec("1E47E") - 80;	//2 (+120)
	$avgbase = hexdec("1E406") - 80 + ($team * 120);	//1

	$leagueid[$team] = $BLT[strtoupper(dechex(ord($a[$leaguebase+($team*2)+($team>5?2:0)])))];	// organize team in screen order

	$teamid[$team] = $BLT[strtoupper(dechex(ord($a[$teambase+$team])))];	// organize team in bin order

	$teamname[$team] = "";
	for ($i=0; $i<=5; $i++)	$teamname[$team] .= $BLT[strtoupper(dechex(ord($a[$teamnamebase+($team*6)+$i])))];

	print $teamname[$team]."\n";

	for ($player=0; $player<=29; $player++)
	{
//		check($a, $avgbase, 2);
//		print "@ ".dechex($namebase)." : ";
		print " ";
		$X = "";
		for ($i=0; $i<6; $i++)
		{
			$O = strtoupper(dechex(ord($a[$namebase+$i])));
			$X .= $BLT[$O];
		}
		print $X;
		$namebase += 6;
		if ($player < 8)
			print " ..HITTER";	// to do: get batting avg and home runs
		else if ($player >= 8 and $player <= (8+11))
		{
			print " ..PITCHER ";
			print dechex(ord($a[$avgbase])).".".bend(dechex(ord($a[$avgbase+1])), 2);
		}
		else if ($player > (8+11))
			print " ..PINCH";
		$avgbase += 10;
		print "\n";

//		if ($namebase >= hexdec("12760")) break;
	}

	print "\n";
}

?>
