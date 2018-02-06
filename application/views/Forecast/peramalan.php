<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Peramalan</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

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
						<select class="form-control" id="desa" name="desa">
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