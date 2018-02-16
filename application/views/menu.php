<?php
	if ($isi=="Home") {
		$this->load->view('home');
	}
	elseif ($isi=="Desa") {
		$this->load->view('Desa/listdesa');
	}
	elseif ($isi=="CurahHujan") {
		$this->load->view('CurahHujan/listcurahhujan');
	}
	elseif ($isi=="Forecast") {
		$this->load->view('Forecast/peramalan');
	}
	elseif ($isi=="ForecastUser") {
		$this->load->view('Forecast/viewperamalan');
	}
	elseif ($isi=="ForecastDetail") {
		$this->load->view('Forecast/viewdetail');
	}
?>