<?php require('conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}


$colname_Recordset2 = "-1";
if (isset($_SESSION['user'])) {
  $colname_Recordset2 = $_SESSION['user'];
}

$Recordset2 = $mysqli->query("SELECT attendance.nama, attendance.year, attendance.noIC, attendance.date AS date, attendance.stationCode, stationName.name AS stationName, COUNT(attendance.date) AS totalDay , attendance.month FROM attendance INNER JOIN stationName ON attendance.stationCode = stationName.stationCode WHERE attendance.timeOut IS NOT NULL GROUP BY attendance.noIC, attendance.month, attendance.year ORDER BY attendance.year,attendance.month DESC");
$row_Recordset2 = mysqli_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysqli_num_rows($Recordset2);

$station = $mysqli->query("SELECT login.nama, login.role, login.username AS emel, login.noIC FROM login INNER JOIN employeeData ON employeeData.noIC = login.noIC WHERE login.noIC NOT LIKE 'admin'");
$row_station = mysqli_fetch_assoc($station);
$totalRows_station = mysqli_num_rows($station);
$a=1;
?>
<div class="box">
<div class="box-body table-responsive no-padding">
<?php if($row_Recordset2['stationCode'] > 0) {?>
              <table id="example3" class="table table-hover">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Full Name</th>
                  <th>Station</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Total working days</th>
                </tr>
                </thead>
                <tbody>

                  <?php do {?>    
                  <tr>
                  <td><?php echo $a++;?></td>	
    	            <td> <span data-toggle="modal" data-target="#viewRiderModal" data-whatever="<?php echo $row_Recordset2['noIC'];?>" data-whatever2="<?php echo $row_Recordset2['month'];?>" class="badge badge-primary" role="button" aria-pressed="true"><?php echo ucwords($row_Recordset2['nama']);?></span></td>	
    	            <td><?php echo $row_Recordset2['stationName'];?></td>
    	            <td><span class="badge badge-info"><?php $date=date_create($row_Recordset2['date']);echo date_format($date,"F");?></span></td>
                   <td><?php echo $row_Recordset2['year'];?></td>
                    <td class="d-sm-inline-flex"><span class="badge badge-warning"><?php echo $row_Recordset2['totalDay'];?></span></td>	
    	            </tr>
                  <?php } while ($row_Recordset2 = mysqli_fetch_assoc($Recordset2));?>

                  </tbody>
                  <tfoot>
                  <tr>
                  <th>No.</th>
                  <th>Full Name</th>
                  <th>Station</th>
                  <th>Month</th>
                  <th>Year</th>
                  <th>Total working days</th>
                </tr>
                </tfoot>
              </table>
<?php }?>
</div>
</div>
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.js"></script>
<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script>
  $(function () {
    $('#example3').DataTable();
  });
</script>