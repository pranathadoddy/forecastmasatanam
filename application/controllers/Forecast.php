<?php
class Forecast extends CI_Controller{
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

		$result=$this->forecastcurrentdata($currendata, $logicalrelationship, $universeofdiscourse);

		echo json_encode($logicalrelationship);

		return $result;

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

		$result=$this->forecastcurrentdata($currendata, $logicalrelationship, $universeofdiscourse);

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
		$result=array(array($fuzifiedenrollment[0],   array($fuzifiedenrollment[1])));
		
		for($i=1;$i<$count; $i++){
			if(($i+1)!=$count){
				if($this->isinflr($fuzifiedenrollment[$i], $result)==false){
					$flr =  array($fuzifiedenrollment[$i] ,array($fuzifiedenrollment[$i+1]));
					array_push($result, $flr);
				}
				else{
					$index=$this->isinflr($fuzifiedenrollment[$i], $result);
					if($this->isingroup($fuzifiedenrollment[$i+1], $result[$index][1])==false){
						array_push($result[$index][1], $fuzifiedenrollment[$i+1]);
					}
				}
			}			
		}
		
		return $result;

	}

	private function isinflr($enrollment, $group){
		for($j=0;$j<count($group);$j++){
			if($enrollment==$group[$j][0]){
				return $j;
			}
		}
		return false;
	}

	private function isingroup($enrollment, $subgroup){
		for($i=0;$i<count($subgroup);$i++){
			if($enrollment==$subgroup[$i]){
				return true;
			}
		}
		return false;
	}

	private function forecastcurrentdata($currentdata, $flr, $universeofdiscourse){
		$result=0;
		$find=false;
		$enrollment="";
		foreach ($universeofdiscourse as $row) {
			if(($currentdata>=$row["Min"]) && ($currentdata<$row["Max"])){
				$enrollment="A".$row["Universe"];
				if($this->isinflr($enrollment, $flr)!=false){
					$index=$this->isinflr($enrollment, $flr);
					$result=$this->getforecastinflr($flr[$index][1], $universeofdiscourse);
					$find=true;
				}
			}
		}

		if($find==false){
			$index=preg_replace("/[^0-9,.]/", "", $enrollment);
			foreach ($universeofdiscourse as $row) {
				if($index==$row["Universe"]){
					$result=$row["Average"];
					break;
				}
			}
		}

		return $result;
	}

	private function getforecastinflr($subgroup, $universeofdiscourse){
		$forecast=0;
		for($i=0;$i<count($subgroup); $i++){
			$index=preg_replace("/[^0-9,.]/", "", $subgroup[$i]);
			foreach ($universeofdiscourse as $row) {
				if($index==$row["Universe"]){

					$forecast=$forecast+$row["Average"];
					break;
				}
			}
		}
		
		$count=count($subgroup);
		$forecast=$forecast/$count;

		return $forecast;
	}
}
?>