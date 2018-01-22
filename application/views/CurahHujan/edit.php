<form id="curahHujanMaintenance" role="form">
	<div class="panel panel-red">
		<div class="panel-heading">
			Detail Curah Hujan
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
					<input type="hidden" name="idcurah" value="<?php echo $curahhujan->Id?>">
						<label>Tahun</label>
						<select name="tahun" id="tahun" class="form-control">
							<option selected="selected">Tahun</option>
							<?php
							for($i=date('Y'); $i>=date('Y')-32; $i-=1){
								if($curahhujan->Tahun==$i){
									echo"<option value='$i' selected > $i </option>";
								}
								else{
									echo"<option value='$i'> $i </option>";
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Bulan</label>
						<select name="bulan" id="bulan" class="form-control">
							<option selected="selected">Bulan</option>
							<?php
							$bln=array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
							for($bulan=1; $bulan<=12; $bulan++){
								if($curahhujan->Bulan==$bulan){  echo "<option value='$bulan' selected>$bln[$bulan]</option>"; }
								else { echo "<option value='$bulan'>$bln[$bulan]</option>"; }
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Desa</label>
						<select name="iddesa" id="iddesa" class="form-control">
							<?php
								foreach ($listdesa->result() as $row) {
									if($row->IdDesa==$curahhujan->IdDesa){
							?>
									<option value='<?php echo $row->Id?>' selected><?php echo $row->NamaDesa?></option>
							<?php
									}
									else{
							?>
									<option value='<?php echo $row->Id?>'><?php echo $row->NamaDesa?></option>
							<?php
									}
							?>
								
							<?php
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Curah Hujan</label>
						<input class="form-control" name="curahhujan" id="curahhujan" value="<?php echo $curahhujan->CurahHujan?>">
					</div>
					<div class="form-group">
						<label>Suhu</label>
						<input class="form-control" name="suhu" id="suhu"  value="<?php echo $curahhujan->Suhu?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button type="submit" id="btn-submit" class="btn btn-red">Simpan</button>
					<button type="reset" class="btn btn-default" onclick="closeMaintenanceWindow()">Kembali</button>
				</div>
			</div>
		</div>

	</div>

</form>

<script type="text/javascript">
	$("#curahHujanMaintenance").submit(function(e){
		e.preventDefault();
		var form=$("#curahHujanMaintenance")[0];
		var formData=new FormData(form);
		waitingDialog.show();
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>/index.php/CurahHujan/update",
			data:formData,
			contentType: false,
			processData: false,
			success:function(data){
				waitingDialog.hide();
				location.reload();
			},
			error: function(xhr, status, error) {
				waitingDialog.hide();
				alert("error"+xhr.responseText);
			}
		});

	});

	function closeMaintenanceWindow(){
		$("#maintenance-pane").empty();
	}

</script>