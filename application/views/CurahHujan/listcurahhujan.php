<?php
function numbertomonth($number){
    if($number==1){
      echo"Januari";
    }
    else if($number==2){
      echo"Pebruari";
    }
    else if($number==3){
      echo"Maret";
    }
    else if($number==4){
      echo"April";
    }
    else if($number==5){
      echo"Mei";
    }
    else if($number==6){
      echo"Juni";
    }
    else if($number==7){
      echo"Juli";
    }
    else if($number==8){
      echo"Agustus";
    }
    else if($number==9){
      echo"September";
    }
    else if($number==10){
      echo"Oktober";
    }
    else if($number==11){
      echo"November";
    }
    else if($number==12){
      echo"Desember";
    }
  }
?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Curah Hujan dan Suhu</h1>
  </div>
  <!-- /.col-lg-12 -->
</div>

<div class="row">
  <div class="col-lg-12" id="body-event">
    <div class="panel panel-red">
      <div class="panel-heading">
        List Curah Hujan
      </div>
      <!-- /.panel-heading -->
      <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-curahhujan">
          <thead>
            <tr>
              <th>No</th>
              <th>Tahun</th>
              <th>Bulan</th>
              <th>Curah Hujan</th>
              <th>Suhu</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
            foreach ($listcurahhujan->result() as $row) {
              ?>
              <tr class="odd gradeX" id="tb-event">
                <td><?php echo $no;?></td>
                <td><?php echo $row->Tahun;?></td>
                <td><?php echo numbertomonth($row->Bulan);?></td>
                <td><?php echo $row->CurahHujan;?></td>
                <td><?php echo $row->Suhu;?></td>
                <td><a href='#' data-id='<?php echo $row->Id;?>' class='btn btn-primary edit-desa' onclick="edit(<?php echo $row->Id;?>)" >Edit</a> | <a data-id='<?php echo $row->Id;?>'  href='#' class='btn btn-default delete-desa'>Delete</a></td>
              </tr>
              <?php
              $no++;
            }
            ?>
          </tbody>
        </table>
        <!-- /.table-responsive -->

        <a href="#" class="btn btn-primary" id="tambah-curahhujan">Tambah</a>

      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
  <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
  var table=$('#dataTables-curahhujan').DataTable();

  function edit(id){
      waitingDialog.show();
      $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>/index.php/CurahHujan/edit",
        data:"iddesa="+id,
        success:function(data){
          waitingDialog.hide();
          $("#maintenance-pane").html(data);
        },
        error: function(xhr, status, error) {
          alert("error"+xhr.responseText);
        }
      });
    }

  $(document).ready(function() {

    $("#tambah-curahhujan").click(function(){
      waitingDialog.show();
      $.ajax({
        type:"POST",
        url:"<?php echo base_url();?>/index.php/CurahHujan/create",
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
