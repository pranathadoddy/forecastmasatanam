<style>
* {box-sizing: border-box;}
ul {list-style-type: none;}
body {font-family: Verdana, sans-serif;}

.month {
    padding: 10px 25px;
    width: 100%;
    background: #1abc9c;
    text-align: center;
}

.month ul {
    margin: 0;
    padding: 0;
}

.month ul li {
    color: white;
    font-size: 20px;
    text-transform: uppercase;
    letter-spacing: 3px;
}

.month .prev {
    float: left;
    padding-top: 10px;
}

.month .next {
    float: right;
    padding-top: 10px;
}

.weekdays {
    margin: 0;
    padding: 10px 0;
    background-color: #ddd;
}

.weekdays li {
    display: inline-block;
    width: 15.6%;
    color: #666;
    text-align: center;
}

.days {
    padding: 10px 0;
    background: #eee;
    margin: 0;
}

.days li {
    list-style-type: none;
    display: inline-block;
    width: 15.6%;
    text-align: center;
    margin-bottom: 5px;
    font-size:12px;
    color: #777;
}

.days li .active {
    padding: 5px;
    background: #1abc9c;
    color: white !important
}

/* Add media queries for smaller screens */
@media screen and (max-width:720px) {
    .weekdays li, .days li {width: 15.1%;}
}

@media screen and (max-width: 420px) {
    .weekdays li, .days li {width: 12.5%;}
    .days li .active {padding: 2px;}
}

@media screen and (max-width: 290px) {
    .weekdays li, .days li {width: 12.2%;}
}
</style>
<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Kalender Masa Tanam Tahun <?php echo $tahun?></h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-12" id="body-event">
			<div class="panel panel-red">
				
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="col-lg-12">
						
						<div class="month">      
						  <ul>
						    <li>
						      <?php echo $desa?><br>
						      <span style="font-size:18px"> <?php echo $tahun?></span>
						    </li>
						  </ul>
						</div>

						<ul class="weekdays">
						<?php for($i=0;$i<6;$i++){
						?>
							<li><?php echo $result[$i]['Bulan']?></li>
						<?php
						}?>
						</ul>

						<ul class="days">  
						  <?php for($i=0;$i<6;$i++){
						  		$icon=$result[$i]['Status']=='Layak'?'<i class="fa fa-check fa-fw"></i>':'<i class="fa fa-close fa-fw"></i>';
						  		$contenttooltip="<p>Prakiraan Curah Hujan: ".$result[$i]['CurahHujan']." mm</p>";
						  		$contenttooltip.="<p>Prakiraan Suhu: ".$result[$i]['Suhu']." &ordm;C</p>";
							?>
							<li><a href="#" data-toggle="tooltip" data-html="true" title="<?php echo $contenttooltip?>"><?php echo $icon ?></a></li>
							<?php
							}?>
						</ul>
						<ul class="weekdays">
						<?php for($i=6;$i<12;$i++){
						?>
							<li><?php echo $result[$i]['Bulan']?></li>
						<?php
						}?>
						</ul>

						<ul class="days">  
						  <?php for($i=6;$i<12;$i++){
						  	$icon=$result[$i]['Status']=='Layak'?'<i class="fa fa-check fa-fw"></i>':'<i class="fa fa-close fa-fw"></i>';

						  	$contenttooltip="<p>Prakiraan Curah Hujan: ".$result[$i]['CurahHujan']." mm</p>";
						  	$contenttooltip.="<p>Prakiraan Suhu: ".$result[$i]['Suhu']." &ordm;C</p>";

							?>
							<li><a href="#" data-toggle="tooltip" data-html="true" title="<?php echo $contenttooltip?>"><?php echo $icon ?></a></li>
							<?php
							}?>
						</ul>
						<p>&nbsp;</p>
						<p><i class="fa fa-check fa-fw"></i>:Layak Terjadi Penanaman</p>
						<p><i class="fa fa-close fa-fw"></i>:Tidak Layak Terjadi Penanaman</p>
					</div>

				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>