<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Peramalan</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<form id="desaMaintenance" role="form">
<div class="row">
	<div class="col-lg-12" id="body-event">
		<div class="panel panel-red">
			<div class="panel-heading">
				List Desa
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Nama Desa</label>
						<select class="form-control" id="iddesa" name="iddesa">
							<?php
							foreach ($listdesa->result() as $row) {
								?>
								<option value="<?php echo $row->Id?>"><?php echo $row->NamaDesa?></option>
								<?php
							}
							?>
							
						</select>
					</div>
					
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
</form>

<div class="row" id="grafik-masa-tanam">
	<div class="col-lg-12" >
		<div class="panel panel-red">
			
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="col-lg-12">
					<div id="line-example" style="height: 250px;"></div>
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row" id="table-masa-tanam">
	<div class="col-lg-12" >
		<div class="panel panel-red">
			
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="col-lg-12">
					<table id="example" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
				       
			    	</table>
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>


<script src="<?php echo base_url()?>template/morris/raphael.js"></script>
<script src="<?php echo base_url()?>template/morris/morris.js"></script>
<script>
	
	$("#iddesa").change(function(e){

		e.preventDefault();
		var form=$("#desaMaintenance")[0];
		var formData=new FormData(form);
		waitingDialog.show();
		$.ajax({
			type:"POST",
			url:"<?php echo base_url();?>/index.php/ForecastHighOrder/index",
			data:formData,
			contentType: false,
			processData: false,
			success:function(data){
				waitingDialog.hide();

				var jsonData=[];

				$.each(JSON.parse(data), function(row, value){
					var obj={
						Bulan:value.Bulan,
						CurahHujan:value.CurahHujan,
						Etp:value.ETP,
						Status:value.Status
					}

					jsonData.push(obj);
				});

				$("#line-example").empty();
				Morris.Line({
				  element: 'line-example',
				  data: jsonData,
				  xkey: 'Bulan',
				  ykeys: ['CurahHujan', 'Etp'],
			  	  labels: ['CurahHujan', 'ETP'],
			  	  parseTime : false,
			  	  resize: true
				});

				var dataSet = new Array;

				$.each(jsonData, function (index, value) {
	                var tempArray = new Array;
	                for (var o in value) {
	                    tempArray.push(value[o]);
	                }
	                dataSet.push(tempArray);
            	})
				

				$('#example').DataTable( {
			    	data: dataSet,
			        columns: [
			            { title: "Bulan" },
			            { title: "CurahHujan" },
			            { title: "Etp" },
			            { title: "Status Kelayakan Masa Tanam" }
			        ],
			        paging: false,
    				searching: false,
    				"ordering": false,
    				destroy: true,
			    } );

				$("#grafik-masa-tanam").css("display","block");
			},
			error: function(xhr, status, error) {
				waitingDialog.hide();
				alert("error"+xhr.responseText);
			}
		});
	})


</script>

