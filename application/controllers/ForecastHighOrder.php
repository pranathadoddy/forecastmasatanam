<?php

class ForecastHighOrder extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdesa');
		$this->load->model('MCurahHujan');
	}


	function index($iddesa){
		$result=array(
			array('Bulan'=>'Januari', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Pebruari', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Maret', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'April', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Mei', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Juni', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Juli', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Agustus', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'September', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Oktober', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'November', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
			array('Bulan'=>'Desember', 'CurahHujan'=>0, 'Suhu'=>0, 'ETP'=>0, 'Status'=>''),
		);

		$result=$this->forecastrainfall($iddesa, $result);
		$result=$this->forecasttemperature($iddesa, $result);
		//echo json_encode($result);
		$result=$this->countetp($result);

		echo json_encode($result);
		
	}

	private function forecastrainfall($iddesa, $result){
		$curahhujansortresult=$this->MCurahHujan->listcurahhujandesasort($iddesa);
		$curahhujansortarray=$curahhujansortresult->result_array();
		$allcurahhujansort=array_column($curahhujansortarray, 'CurahHujan');

		$box_plot=$this->box_plot_values($allcurahhujansort);

		$curahhujanresult=$this->MCurahHujan->listcurahhujandesawithrange($iddesa,$box_plot['min'],$box_plot['max']);
		$curahhujanarray=$curahhujanresult->result_array();


		$allcurahhujan=array_column($curahhujanarray, 'CurahHujan');

		$range=55;
		$mincurahhujanvalue=$this->getminvalue($allcurahhujan);
		$maxcurahhujanvalue=$this->getmaxvalue($allcurahhujan, $range);
		
		$universeofdiscourse=$this->getuniverseofdiscourse($mincurahhujanvalue, $maxcurahhujanvalue, $range);
		$enrollment=$this->getenrollment($allcurahhujan, $universeofdiscourse);

		$flr=$this->getlogicalrelationship($enrollment);

		$countdata=count($allcurahhujan);
		$actualdata1=$allcurahhujan[$countdata-2];
		$actualdata2=$allcurahhujan[$countdata-1];

		$keys = array_keys($result);

		for($i = 0; $i < count($result); $i++) {
			$forecast=0;
		 	if($result[$i]['Bulan']=='Januari'){
		 		$forecast=$this->getforecastresult($flr, $actualdata1, $actualdata2, $universeofdiscourse);
		 	}
		 	elseif ($result[$i]['Bulan']=='Pebruari') {
		 		$forecast=$this->getforecastresult($flr, $actualdata2, $result[$i-1]['CurahHujan'], $universeofdiscourse);
		 	}
		 	else{
		 		$forecast=$this->getforecastresult($flr, $result[$i-2]['CurahHujan'], $result[$i-1]['CurahHujan'], $universeofdiscourse);
		 	}
		 	$result[$i]['CurahHujan']=$forecast;
		 	
		}

		return $result;
		//
		//echo json_encode($forecast);
	}

	private function forecasttemperature($iddesa, $result){
		$suhuresult=$this->MCurahHujan->listcurahhujandesa($iddesa);
		$suhuarray=$suhuresult->result_array();

		$allsuhu=array_column($suhuarray, 'Suhu');


		$box_plot=$this->box_plot_values($allsuhu);

		$suhuresult=$this->MCurahHujan->listsuhudesawithrange($iddesa,$box_plot['min'],$box_plot['max'] );
		$suhuarray=$suhuresult->result_array();

		$allsuhu=array_column($suhuarray, 'Suhu');

		$range=0.3;
		$minsuhuvalue=$this->getminvalue($allsuhu);
		$maxsuhuvalue=$this->getmaxvalue($allsuhu, $range);

		//echo $minsuhuvalue." ".$maxsuhuvalue;

		$universeofdiscourse=$this->getuniverseofdiscourse($minsuhuvalue, $maxsuhuvalue, $range);
		$enrollment=$this->getenrollment($allsuhu, $universeofdiscourse);

		$flr=$this->getlogicalrelationship($enrollment);

		$countdata=count($allsuhu);
		$actualdata1=$allsuhu[$countdata-2];
		$actualdata2=$allsuhu[$countdata-1];

		$keys = array_keys($result);

		for($i = 0; $i < count($result); $i++) {
			$forecast=0;
		 	if($result[$i]['Bulan']=='Januari'){
		 		$forecast=$this->getforecastresult($flr, $actualdata1, $actualdata2, $universeofdiscourse);
		 	}
		 	elseif ($result[$i]['Bulan']=='Pebruari') {
		 		$forecast=$this->getforecastresult($flr, $actualdata2, $result[$i-1]['Suhu'], $universeofdiscourse);
		 	}
		 	else{
		 		$forecast=$this->getforecastresult($flr, $result[$i-2]['Suhu'], $result[$i-1]['Suhu'], $universeofdiscourse);
		 	}
		 	$result[$i]['Suhu']=$forecast;
		 	
		}
		

		return $result;
		//echo json_encode($logicalrelationship);

	}
	
	function box_plot_values($array)
	{
	    $return = array(
	        'lower_outlier'  => 0,
	        'min'            => 0,
	        'q1'             => 0,
	        'median'         => 0,
	        'q3'             => 0,
	        'max'            => 0,
	        'higher_outlier' => 0,
	        'iqr'			 => 0
	    );

	    $array_count = count($array);
	    sort($array, SORT_NUMERIC);

	    $return['min']            = $array[0];
	    $return['lower_outlier']  = $return['min'];
	    $return['max']            = $array[$array_count - 1];
	    $return['higher_outlier'] = $return['max'];
	    $middle_index             = floor($array_count / 2);
	    $return['median']         = $array[$middle_index]; // Assume an odd # of items
	    $lower_values             = array();
	    $higher_values            = array();



	    // If we have an even number of values, we need some special rules
	    if ($array_count % 2 == 0)
	    {
	        // Handle the even case by averaging the middle 2 items
	        $return['median'] = round(($return['median'] + $array[$middle_index - 1]) / 2);

	        foreach ($array as $idx => $value)
	        {
	            if ($idx < ($middle_index - 1)) $lower_values[]  = $value; // We need to remove both of the values we used for the median from the lower values
	            elseif ($idx > $middle_index)   $higher_values[] = $value;
	        }
	    }
	    else
	    {
	        foreach ($array as $idx => $value)
	        {
	            if ($idx < $middle_index)     $lower_values[]  = $value;
	            elseif ($idx > $middle_index) $higher_values[] = $value;
	        }
	    }

	    $lower_values_count = count($lower_values);
	    $lower_middle_index = floor($lower_values_count / 2);
	    $return['q1']       = $lower_values[$lower_middle_index];
	    if ($lower_values_count % 2 == 0)
	        $return['q1'] = round(($return['q1'] + $lower_values[$lower_middle_index - 1]) / 2);

	    $higher_values_count = count($higher_values);
	    $higher_middle_index = floor($higher_values_count / 2);
	    $return['q3']        = $higher_values[$higher_middle_index];
	    if ($higher_values_count % 2 == 0)
	        $return['q3'] = round(($return['q3'] + $higher_values[$higher_middle_index - 1]) / 2);

	    // Check if min and max should be capped
	    $iqr = $return['q3'] - $return['q1']; // Calculate the Inner Quartile Range (iqr)
	    $return['min'] = $return['q1'] - (1.5*$iqr);
	    $return['max'] = $return['q3'] + (1.5*$iqr);

	    $return['iqr']=$iqr;
	    return $return;
	}

	private function getminvalue($arr){
		return min($arr);
	}

	private function getmaxvalue($arr, $range){
		$temp_maxvalue=max($arr);
		$minvalue=min($arr);
		$maxvalue=0;
		while($maxvalue<$temp_maxvalue){
			$maxvalue=$minvalue+$range;
			$minvalue=$maxvalue;
		}

		return $maxvalue;
	}

	private function getuniverseofdiscourse($minvalue, $maxvalue, $range){
		$temp_maxvalue=$minvalue;
		$temp_minvalue=$minvalue;

		$result=array();
		$count=1;
		while($temp_maxvalue!=$maxvalue){
			$temp_minvalue=$temp_maxvalue;
			$temp_maxvalue=$temp_maxvalue+$range;
			$average=($temp_minvalue+$temp_maxvalue)/2;
			$universeofdiscourse=array("Universe"=>"A".$count, "Min"=>$temp_minvalue, "Max"=>$temp_maxvalue, "Average"=>$average);
			array_push($result, $universeofdiscourse);
			
			$count++;
		}

		return $result;
	}

	private function getenrollment($arr, $universeofdiscourse){
		$result=array();
		$fuzifiedenrollment="";
		foreach ($arr as $value) {
			foreach ($universeofdiscourse as $row) {
				if(($value>=$row["Min"]) && ($value<$row["Max"])){
					$fuzifiedenrollment=$row["Universe"];
					break;
				}
			}

			$enrollment = array('Actual Enrollment' => $value, 'Fuzified Enrollment'=> $fuzifiedenrollment );

			array_push($result, $enrollment);
		}

		return $result;
	}

	private function getlogicalrelationship($enrollment){
		$count=count($enrollment);
		$fuzifiedenrollment=array_column($enrollment, "Fuzified Enrollment");
		$result=array(array($fuzifiedenrollment[0], $fuzifiedenrollment[1], array($fuzifiedenrollment[2])));
		for($i=1; $i<$count; $i++){
			if(($i+2)<$count){
				$isinflr=$this->isinflr($fuzifiedenrollment[$i], $fuzifiedenrollment[$i+1], $result);
				if($isinflr==false){
					$flr = array($fuzifiedenrollment[$i],  $fuzifiedenrollment[$i+1],array($fuzifiedenrollment[$i+2]));
					array_push($result, $flr);
				}
				else{
					$index=$isinflr;
					array_push($result[$index][2], $fuzifiedenrollment[$i+2]);
				}
			}
		}

		return $result;

	}

	private function isinflr($enrollment1, $enrollment2, $group){
		for($i=0; $i<count($group); $i++){
			if(($enrollment1==$group[$i][0]) && ($enrollment2==$group[$i][1])){
				return $i;
			}
		}

		return false;
	}

	private function getforecastresult($flr, $actualdata1, $actualdata2, $universeofdiscourse){
		$result=0;
		$find=false;
		$enrollment1="";
		$enrollment2="";

		
		$enrollment1=$this->getcurrentenrollment($actualdata1, $universeofdiscourse);
		$enrollment2=$this->getcurrentenrollment($actualdata2, $universeofdiscourse);
		

		$isInFlr=$this->isinflr($enrollment1, $enrollment2, $flr);

		if($isInFlr!=false){
			$index=$isInFlr;
			$subgroup=$flr[$index][2];
			$result=$this->getforecastinflr($subgroup, $universeofdiscourse);
			
			return $result;
		}
		
		$average1=$this->getaverageenrollment($enrollment1, $universeofdiscourse);
		$average2=$this->getaverageenrollment($enrollment2, $universeofdiscourse);

		$result=($average1+$average2)/2;

		return $result;
	}

	private function getforecastinflr($subgroup, $universeofdiscourse){
		$jumlahAverageEnrollment=0;
		$jumlahEnrollment=0;
		foreach ($subgroup as $row) {
			$jumlahrow=$this->getenrollmentcount($subgroup, $row);
			
			$average=$this->getaverageenrollment($row, $universeofdiscourse);

			$jumlahEnrollment+=$jumlahrow;

			$jumlahAverageEnrollment+=($jumlahrow*$average);
		}


		$result=$jumlahAverageEnrollment/$jumlahEnrollment;

		return $result;
	}

	private function getenrollmentcount($subgroup, $enrollment){
		$jumlah=0;
		foreach ($subgroup as $row) {
			if($enrollment==$row){
				$jumlah+=1;
			}
		}

		return $jumlah;
	}

	private function getaverageenrollment($enrollment, $universeofdiscourse){
		foreach ($universeofdiscourse as $row) {
			if($enrollment==$row["Universe"]){
				return $row["Average"];
			}
		}

		return false;
	}

	private function getcurrentenrollment($currentdata, $universeofdiscourse){
		foreach ($universeofdiscourse as $row) {
			if(($currentdata>=$row["Min"]) && ($currentdata<$row["Max"])){
				return $row["Universe"];
			} 
		}
		return false;
	}

	private function countetp($result){
		$allsuhu=array_column($result, 'Suhu');
		$count=count($allsuhu);
		$i=0;
		foreach ($allsuhu as $key => $value) {
			$i+=pow(($value/5), 1.514);
		}

		$ipowthree=pow($i, 3);
		$ipowtwo=pow($i,2);

		$a=(0.000000675 * $ipowthree)-(0.0000771 * $ipowtwo)+(0.01792*$i)+0.49239;
		$a= number_format($a, 2, '.', '');

		foreach ($allsuhu as $key => $value) {
			$etp=0;
			if($value<26.5){
				$ipert=10*($value/$i);
				$etp=1.6*(pow($ipert, $a));
			}else{
				$tpow2=pow($value, 2);
				$etp=(-0.0433*$tpow2)+(3.2244*$value)-41.545;
			}
			$etp=$etp*10;
			$etp=number_format($etp, 2, '.', '');
			$result[$key]['ETP']=$etp;

			$result[$key]['Status']=$result[$key]['CurahHujan']>$etp?'Layak':'Tidak Layak';
		}
		
		return $result;
	}

}
?>