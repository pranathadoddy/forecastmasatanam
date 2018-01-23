<?php
class ForecastHighOrder extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdesa');
		$this->load->model('MCurahHujan');
	}


	function index($iddesa){
		echo $this->forecastrainfall($iddesa);

	}

	private function forecastrainfall($iddesa){
		$curahhujanresult=$this->MCurahHujan->listcurahhujandesa($iddesa);
		$curahhujanarray=$curahhujanresult->result_array();

		$allcurahhujan=array_column($curahhujanarray, 'CurahHujan');

		$range=40;
		$mincurahhujanvalue=$this->getminvalue($allcurahhujan);
		$maxcurahhujanvalue=$this->getmaxvalue($allcurahhujan, $range);

		$universeofdiscourse=$this->getuniverseofdiscourse($mincurahhujanvalue, $maxcurahhujanvalue, $range);
		$enrollment=$this->getenrollment($allcurahhujan, $universeofdiscourse);

		$logicalrelationship=$this->getlogicalrelationship($enrollment);

		$currendata=$this->MCurahHujan->getlastrow()->CurahHujan;

		echo json_encode($logicalrelationship);

	}

	private function forecasttemperature($iddesa){
		$suhuresult=$this->MCurahHujan->listsuhudesa($iddesa);
		$suhuarray=$suhuresult->result_array();

		$allsuhu=array_column($suhuarray, 'Suhu');

		$range=40;
		$minsuhuvalue=$this->getminvalue($allsuhu);
		$maxsuhuvalue=$this->getmaxvalue($allsuhu, $range);

		$universeofdiscourse=$this->getuniverseofdiscourse($minsuhuvalue, $maxsuhuvalue, $range);
		$enrollment=$this->getenrollment($allsuhu, $universeofdiscourse);

		$logicalrelationship=$this->getlogicalrelationship($enrollment);

		$currendata=$this->MCurahHujan->getlastrow()->suhu;

		return $result;

	}

	private function getminvalue($arr){
		return min($arr);
	}

	private function getmaxvalue($arr, $range){
		$maxvalue=max($arr);
		while(($maxvalue%$range)!=0){
			$maxvalue=$maxvalue+1;
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
			$universeofdiscourse=array("Universe"=>$count, "Min"=>$temp_minvalue, "Max"=>$temp_maxvalue, "Average"=>$average);
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
					$fuzifiedenrollment="A".$row["Universe"];
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

		foreach ($universeofdiscourse as $row) {
			$enrollment1=getenrollment($actualdata1, $row);
			$enrollment2=getenrollment($actualdata2, $row);
		}

		$isInFlr;=this->isinflr($enrollment1, $enrollment2, $flr);

		if($isInFlr!=false){
			$index=$isInFlr;
			
		}


	}

	private function getenrollment($data, $row){
		if(($currentdata>=$row["Min"]) && ($currentdata<$row["Max"])){
			return "A".$row["Universe"];
		} 

		return false;
	}	
}
?>