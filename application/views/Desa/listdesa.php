
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Desa</h1>
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
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-desa">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Desa</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
            foreach ($listdesa->result() as $row) {
              ?>
              <tr class="odd gradeX" id="tb-event">
                <td><?php echo $no;?></td>
                <td><?php echo $row->NamaDesa;?></td>
                <td><a href='#' data-id='<?php echo $row->Id;?>' class='btn btn-primary edit-desa'>Edit</a> | <a data-id='<?php echo $row->Id;?>'  href='#' class='btn btn-default delete-desa'>Delete</a></td>
              </tr>
              <?php
              $no++;
            }
            ?>
          </tbody>
        </table>
        <!-- /.table-responsive -->

        <a href="#" class="btn btn-primary" id="tambah-desa">Tambah</a>

      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
  var table=$('#dataTables-desa').DataTable();

  $(document).ready(function() {

    $("#tambah-desa").click(function(){
      waitingDialog.show();
      $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>/index.php/desa/create",
        success:function(data){
          waitingDialog.hide();
          $("#maintenance-pane").html(data);
        },
        error: function(xhr, status, error) {
          alert("error"+xhr.responseText);
        }
      });
    });

    $(".edit-desa").click(function(){
      waitingDialog.show();
      $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>/index.php/desa/editdesa",
        data:"iddesa="+$(this).data('id'),
        success:function(data){
          waitingDialog.hide();
          $("#maintenance-pane").html(data);
        },
        error: function(xhr, status, error) {
          alert("error"+xhr.responseText);
        }
      });
    });

    $(".delete-desa").click(function(){
      waitingDialog.show();
      $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>/index.php/desa/deletedesa",
        data:"iddesa="+$(this).data('id'),
        success:function(data){
          waitingDialog.hide();
          location.reload();
        },
        error: function(xhr, status, error) {
          alert("error"+xhr.responseText);
        }
      });
    });
  });

</script>

<div id="maintenance-pane">

</div>
