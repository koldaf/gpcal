<?php
header('Content-type:application/JSON');
if(isset($_GET)){
$max = $_GET['max'];
//print_r($_GET);
$inputs = array_slice($_GET,1);
$totpoint = 0;
$totunit = 0;
$final = array('output' => 'failed','reasons'=>'none','gp' => 0,'cod' => 0);
if(array_search('',$inputs)){
	//echo 1;
	$final['output'] = 'failed';
	$final['reasons'] = 'Complete All Fields';
	$final['gp'] = 0;
	$final['cod'] = 'none';
	echo json_encode($final);
}
else{
	//print_r($inputs);
	for($i=1; $i<=$max; $i++){
		$score = $_GET['score'.$i];
		$unit = $_GET['unit'.$i];
		if($score > 100 || !is_numeric($score) || empty($score) || $score == "")
		{
			//echo 2;
			$final['output'] = 'failed';
			$final['reasons'] = 'Enter a Valid Score';
			$final['gp'] = 0;
			$final['cod'] = 'none';
			echo json_encode($final);
			exit;	
		}
		else
		{
			$totpoint += (do_point($score) * $unit);
			$totunit += $unit;
		}
	}
		$gp = $totpoint/$totunit;
		//echo number_format($gp,2).'<br/>'.print_r($final);
		$final['output'] = 'Sucess';
		$final['reasons'] = 'Your GP was Computed';
		$final['gp'] = number_format($gp,2);
		$final['cod'] = cod($gp);
		echo json_encode($final);
	}
}
function do_point($score){
	if($score > 69){ $point = 5;}
	else if($score > 59 && $score < 70) {$point = 4;}
	else if($score > 49 && $score < 60) {$point = 3;}
	else if($score > 44 && $score < 50) {$point = 2;}
	else if($score > 39 && $score < 45) {$point = 1;}
	else{$point = 0;} 
	return $point;
}
function cod($gp){
	if ($gp >= 4.50)
	{
		$class = "<span> First Class  </span>";
	}
	else if (($gp < 4.50) && ($gp >= 3.50))
	{
		$class = "<span> Second Class Upper (2.1) </span>";
	}
	else if (($gp < 3.50) && ($gp >=2.40))
	{
		$class = "<span> Second Class Lower Division (2.2)</span>";
	}
	else if (($gp < 2.40) && ($gp >=1.50))
	{
		$class = "<span> Third Class  </span>";
	}
	else if (($gp < 1.50) && ($gp >= 1.00))
	{
		$class = "<span>  Pass  </span>";
	}
	else
	{
		$class = "<span> Failed </span>";
	}
	return $class;
}
?>