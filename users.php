<?php
// Initialize the session
session_start();
include "connect.php";
if ($_SESSION['usertype']!='administrator') {
  header("location:./logout.php");
  exit();
}
 

// Define variables and initialize with empty values
$year_err = $school_name_err = $village_name_err =  "";

//  Remove director of a specific schools
if(isset($_GET['act']) == 'delete' && is_numeric($_GET['st_id'])){

 $st_id = $_GET['st_id'];

 // echo $st_id;

  // Check user position
 $check_position = mysql_query("SELECT * from users WHERE `user_id` = '{$st_id}' && `Usertype` != 'administrator'") or die("Unable to find Position");
 $user_position = mysql_fetch_assoc($check_position);
 $user_data = $user_position['Usertype'];

 // echo $user_position['Usertype'];

 //Search Institution
 $sql_user = "SELECT * from";
  if ($user_position['Usertype'] == 'rehab' ) $sql_user .="`rehab`";
  if ($user_position['Usertype'] == 'user' ) $sql_user .="`schools`";
  if ($user_position['Usertype'] == 'executive' ) $sql_user .="`sector`";

  if ($user_position['Usertype'] == 'rehab' ) $sql_user .= "WHERE `userId` = '{$user_position['user_id']}'";
  else $sql_user .= "WHERE `user_id` = '{$user_position['user_id']}'";

  // echo $sql_user;

  $check_institution = mysql_query($sql_user) or die(mysql_error());

  if (mysql_num_rows($check_institution) > 0) {

  // Update Institution 
  $sql_inst = "UPDATE ";
  if ($user_position['Usertype'] == 'rehab' ) $sql_inst .="`rehab` ";
  if ($user_position['Usertype'] == 'user' ) $sql_inst .="`schools` ";
  if ($user_position['Usertype'] == 'executive' ) $sql_inst .="`sector` ";

  if ($user_position['Usertype'] == 'rehab' ) $sql_inst .= "SET `userId` = '1'";
  else $sql_inst .= "SET `user_id` = '1'";

  if ($user_position['Usertype'] == 'rehab' ) $sql_inst .= " WHERE `userId` = '{$st_id}'";
  else $sql_inst .= " WHERE `user_id` = '{$st_id}'";

  // echo $sql_inst;
  // die();
  
  // if ($user_position['Usertype'] == 'rehab' ) $sql_inst .=" WHERE `userId` = '{$st_id}'";
  // if ($user_position['Usertype'] == 'user' ) $sql_inst .=" WHERE `schools`";
  // if ($user_position['Usertype'] == 'executive' ) $sql_inst .="`sector`"

  $update_inst = mysql_query($sql_inst) or die(mysql_error());   

  if($update_inst) mysql_query("DELETE from users WHERE `user_id` = '{$st_id}'") or die("Unable to delete");
  else echo "Unable delete this user"; 
  // echo ""
  
  } else {

    $del_user = mysql_query("DELETE  from users WHERE `user_id` ='{$st_id}' ") or die(mysql_error());
    echo "User Deleted Successfully";
  }


 }


// Remove schools
// if ($_GET['delete_sch'] && is_numeric($_GET['sch_id'])) {
//   $chk = mysql_query("SELECT * from students WHERE school_id = '' ") or die(mysql_error());
// }


//save the school information

if(isset($_POST['save_school'])){
  //check the village information

  if(!empty($_POST['school_name'])){
    
    if(is_numeric($_POST['cell_id'])){
      //save the school information
      $check = mysql_query("SELECT * FROM schools WHERE school_name='".mysql_real_escape_string(trim($_POST['school_name']))."' && Village_id='{$_POST['cell_id']}'");
      if(mysql_num_rows($check) == 0){
        if(mysql_query("INSERT INTO schools SET school_name='".mysql_real_escape_string(trim($_POST['school_name']))."', Village_id='{$_POST['cell_id']}', user_id=1") or die(mysql_error())){
          echo  "<br />School Successfully Registered!";
          unset($_POST);
        } else
          echo " <br />Error While Saving School ";
      } else{
        echo " <br />School Name Already Exists ";
      }
    }
  } else{
    echo "<br />Empty School Name!";
  }

}


if(isset($_POST['save_dir'])){


  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $id = $_POST['id'];
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $sec_id = $_GET['dir'];


  //save executive information
  $sql = "INSERT into users VALUES(null,'{$user}','{$pass}','{$name}','{$phone}','{$id}','user')";

  $res = mysql_query($sql) or die(mysql_errno());

  $user_id = mysql_insert_id();

  unset($res);

  if(is_numeric($user_id)){

    $update = "UPDATE schools SET user_id = '{$user_id}' WHERE school_id = {$sec_id}";
    
    $res = mysql_query($update) or die(mysql_error());

    if ($res) {
      
      echo "Headmaster has been set";

    }


  }


}



 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>School Dropout Management</title>
  <!-- Tell the browser to be responsive to screen width -->
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="./bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="./bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="./dist/css/skins/_all-skins.min.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="./dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>O</b>S<b>D</b><b>M</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>School Dropout </b> management System</b> </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- Notifications: style can be found in dropdown.less -->
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="./dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['username'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['username'] ?> - <?php echo $_SESSION['usertype'] ?>
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                   <a href="./logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="./dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['username'] ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
          
        </li>
        
        
        <li >
          <a href="new_schools.php">
            <i class="fa fa-edit"></i> <span> Schools</span>
          </a>
        </li>
       
    
        <li >
          <a href="new_rehab.php">
            <i class="fa fa-edit"></i> <span> Rehabilitation</span>
          </a>
        </li>
       
    
        <li>
          <a href="new_seo.php">
            <i class="fa fa-edit"></i> <span>Sector Education Officer</span>
          </a>
        </li>
      
        <li class="header">Setting</li>
        <li><a href="#"><i class="fa fa-cogs text-red"></i> <span>Account Setting</span></a></li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Options
  
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Options</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- Used DATA WE NEED  -->

        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users Features </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <td>Name</td>
                  <td>Username</td>
                  <td>Phone</td>
                  <td>Identity</td>
                  <td> Position </td>
                  <td>Operations</td>
                </tr>
                </thead>
                <tbody>
                  <?php
                     $sql=mysql_query("SELECT * from users WHERE `users`.`Usertype` != 'administrator'") or die(mysql_error());

                     $data = array();
                     while($row=mysql_fetch_assoc($sql))
                        $data[] = $row;

                           $i = 1; 
                     foreach ($data as $row) {

                      $sql_position = "SELECT * from ";

                      if ($row['Usertype'] == 'rehab' ) $sql_position .="`rehab`";
                      if ($row['Usertype'] == 'user' ) $sql_position .="`schools`";
                      if ($row['Usertype'] == 'executive' ) $sql_position .="`sector`";

                      if ($row['Usertype'] == 'rehab' ) $sql_position .= "WHERE userId = '{$row['user_id']}'";
                      else $sql_position .= "WHERE user_id = '{$row['user_id']}'";
                      $position = array();
                      $query_position = mysql_query($sql_position) or die(mysql_error());
                      $data2=mysql_fetch_assoc($query_position);
                        // $position[] = $data2;
                      $rehab_name = "";
                      $school_name = "";
                      $sector_name = "";
                      if ($row['Usertype'] == 'rehab' ) $rehab_name = $data2['name'];
                      if ($row['Usertype'] == 'user' ) $school_name = $data2['school_name'];
                      if ($row['Usertype'] == 'executive' ) $sector_name = $data2['sector_name'];

                 ?>
               <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['Names'];?></td>
                <td><?php echo $row['Username'];?></td>
                <td><?php echo $row['Telephone'];?></td>
                <td> <?php echo $row['identity_no'];?> </td>
                <td>

                  <?php
                  // foreach ($position as $key) {
                   
                  //  if ($row['Usertype'] == 'rehab' && $key['userId'] == $row['user_id'] ) echo $key["name"];
                  //  elseif ($row['Usertype'] == 'user' && $key['user_id'] == $row['user_id'] ) echo $key['school_name'];
                  //  elseif ($row['Usertype'] == 'executive' && $key['user_id'] == $row['user_id'] ) echo $key['sector_name'];
                  // }
                      
                    if ($row['Usertype'] == 'rehab' && !empty($rehab_name) )  echo " Director at ".$rehab_name;
                    if ($row['Usertype'] == 'user' && !empty($school_name) ) echo "Director at ".$school_name;
                    if ($row['Usertype'] == 'executive' && !empty($sector_name) ) echo "Executive at ".$sector_name;
                    else echo "-";
                  
                  ?>
                 </td>
                <td><a href="users.php?act=delete&st_id=<?php echo $row['user_id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Remove</a>

                </td>   
                <?php include('./add_director.php'); ?>             
               </tr>
              <?php
                  }
                  
               ?>
                </tbody>
              </table>
             
            </div>

            <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add school </h4>
              </div>
              <div class="modal-body">
                
                <form class="form-horizontal" action="" method="POST">
              <div class="box-body">

                <div class="form-group">
                  <label for="departments" class="col-sm-3 control-label"> Village Name </label>

                  <div class="col-sm-9 <?php echo (!empty($village_name_err)) ? 'has-error' : ''; ?>">
                    <select name="cell_id" class="form-control" >
                      <option value=""> - </option>
                      <?php


                        $query = "select cells.cellname, villages.village_id, villages.villagename from villages, cells, sector WHERE cells.cell_id=villages.village_id && sector.sector_id=cells.sector_id order by cells.cellname asc; ";
                        #echo $query;
                        $cells = mysql_query($query);
                        if($cells && mysql_num_rows($cells)>0){
                             #var_dump($cells);
                           while($cell = mysql_fetch_assoc($cells)){
                             #var_dump($cell);
                              echo "<option value='{$cell['village_id']}'>".$cell['villagename']."(".$cell['cellname'].")</option>";
                         }
                        }                       

                     ?>
                    </select>
                    <span class="help-block"><?php echo $village_name_err; ?></span>
                  </div>
                </div> 

                <div class="form-group ">
                  <label for="school_name" class="col-sm-3 control-label"> School name </label>

                  <div class="col-sm-9 <?php echo (!empty($school_name_err)) ? 'has-error' : ''; ?>">
                    <input type="text" class="form-control" name="school_name">
                    <span class="help-block"><?php echo $school_name_err; ?></span>
                  </div>
              </div>

                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                <button type="submit" name="save_school" class="btn btn-info pull-right">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>


              </div>
              
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <!-- edit modal -->





      </div>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Designed By</b> Christian & Bonaventure
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.iprctumba.rp.ac.rw"> IPRC Tumba </a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="./bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="./bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="./bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="./bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
