#!/usr/bin/php

<?php
	$i = 0;
	$e = 0;
	$path = array("./wardrobe/tops.csv", "./wardrobe/bottoms.csv",
		"./wardrobe/coats.csv", "./wardrobe/dresses.csv", "./wardrobe/hair.csv",
		"./wardrobe/hosiery.csv", "./wardrobe/makeup.csv",
		"./wardrobe/shoes.csv");
	// $path = array("./wardrobe/bottoms.csv");
	foreach($path as $elem){
		$fd = fopen($elem, "r");
		while($clothes[$e][$i] = fgetcsv($fd, 0, ","))
		{
			if (preg_match('/^[A-aZ-z|\s]+/',$clothes[$e][$i][2]) == TRUE)
			{
				if($clothes[$e][$i][3] != NULL)
					$i++;
			}
		}
		$i = 0;
		$e++;
	}

	function atopts($case)
	{
		if ($case == "SS")
			return(6);
		else if ($case == "S")
			return(5);
		else if ($case == "A")
			return(4);
		else if ($case == "B")
			return(3);
		else if ($case == "C")
			return(2);
		else if ($case == "D")
			return(1);
		else
			return(0);
	}

	function ttomult($tiers, $i)
	{
		if ($tiers[$i] == 3)
			return(2.0);
		else if ($tiers[$i] == 2)
			return(1.5);
		else if ($tiers[$i] == 1)
			return(1.0);
		else
			return(0);
	}

	function calc_val($clothes, $tiers, $tags)
	{
		$j = 0;
		foreach($clothes as $elem)
		{
			for($i = 3; $i < 13; $i++)
			{
				$tl = ttomult($tiers, $i - 3);
				$res[$j] = $res[$j] + atopts(strtoupper($elem[$i])) * $tl;
				if (strtoupper($elem[14]) == $tags || strtoupper($elem[15]) == $tags)
					$res[$j] += 3;
			}
			$j++;
		}
		print_r($res);
		$r = max($res);
		$ar = array_keys($res, $r);
		return($ar[0]);
	}

	$tl = array(0,1,0,2,0,0,3,2,0,3);
	foreach($clothes as $elem)
		$v[] = calc_val($elem, $tl, "Denim");
	$h = 0;
	foreach($v as $value)
	{
		echo ($clothes[$h][$value][2])."\n";
		$h++;
	}
?>
