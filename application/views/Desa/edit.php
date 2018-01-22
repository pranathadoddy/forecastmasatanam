<form id="desaMaintenance" role="form">
	<div class="panel panel-red">
		<div class="panel-heading">
			Detail Desa
		</div>
		<input type="hidden" name="iddesa" value="<?php echo $desa->Id?>">
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Nama Desa</label>
						<input class="form-control" name="namadesa" id="namadesa" value="<?php echo $desa->NamaDesa?>" >
					</div>
					<div class="form-group">
						<label>Titik Layu Permanen</label>
						<input class="form-control" name="tlp" id="tlp" value="<?php echo $desa->Tlp?>">
					</div>
					<div class="form-group">
						<label>Kapasitas Lapang</label>
						<input class="form-control" name="kl" id="kl" value="<?php echo $desa->Kl?>">
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
	$("#desaMaintenance").submit(function(e){
		e.preventDefault();
		var form=$("#desaMaintenance")[0];
		var formData=new FormData(form);
		waitingDialog.show();
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>/index.php/Desa/updatedesa",
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

</script>>