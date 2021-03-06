<?php
// Initialize the session
session_start();
include '../../config.php';
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../login.php");
    exit;
}
?>

<?php

 
// Define variables and initialize with empty values
$dept_id = $dept_name = $dept_head =  "";
$dept_id_err = $dept_name_err = $dept_head_err =  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate dept_id
    if(empty(trim($_POST["dept_id"]))){
        $dept_id_err = "Please enter a Department Code.";
    } else{
        // Prepare a select statement
        $sql = "SELECT dept_id FROM department WHERE dept_id = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_dept_id);
            
            // Set parameters
            $param_dept_id = trim($_POST["dept_id"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $dept_id_err = "This Department Code is already taken.";
                } else{
                    $dept_id = trim($_POST["dept_id"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }

     if(empty(trim($_POST["dept_name"]))){
        $dept_name_err = "Please Select Department Name.";     
    } else{
        $dept_name = trim($_POST["dept_name"]);
    }
    
    // Validate dept_head
    if(empty(trim($_POST["dept_head"]))){
        $dept_head_err = "Please Select Head of Department .";     
    } else{
        $dept_head = trim($_POST["dept_head"]);
    }
    

    
    // Check input errors before inserting in database
    if(empty($dept_id_err) && empty($dept_name_err) && empty($dept_head_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO department (dept_id,dept_name,dept_head) VALUES (?,?,?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_dept_id, $param_dept_name,  $param_dept_head);
            
            // Set parameters
            $param_dept_name = $dept_name;
            $param_dept_id = $dept_id;
            $param_dept_head = $dept_head; 
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: department.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Time Table</title>
  <!-- Tell the browser to be responsive to screen width -->
   <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>I</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>IPRC Tumba</b> </span>
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
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['names'] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['names'] ?> - <?php echo $_SESSION['username'] ?>
                  <small><?php echo $_SESSION['college'] ?></small>
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                   <a href="../../logout.php" class="btn btn-default btn-flat">Sign out</a>
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
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['names'] ?></p>
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
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Entry Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="department.php"><i class="fa fa-circle-o"></i> Department</a></li>
            <li><a href="lecture.php"><i class="fa fa-users"></i> Lecture </a></li>
            <li><a href="course.php"><i class="fa fa-file"></i> Course </a></li>
            <li><a href="room.php"><i class="fa fa-university"></i> Room </a></li>
            <li><a href="level.php"><i class="fa fa-cubes"></i> Level </a></li>
            <li><a href="time.php"><i class="fa fa-calendar-check-o"></i> Time </a></li>
            <li><a href="class.php"><i class="fa fa-building"></i> Class </a></li>
          </ul>
        </li>
       
    
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Time Table</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- IT -->
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o text-yellow"></i> Information Technology
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-yellow"></i> Level 1 IT
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 1 IT-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 1 IT-B</a></li>
                  </ul>
                </li>
                <!-- ET -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-yellow"></i> Level 2 IT
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 2 IT-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 2 IT-B</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 2 IT-C</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 2 IT-D</a></li>
                  </ul>
                </li>
                <!-- RE -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-yellow"></i> Level 3 IT 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 3 IT-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> 3 IT-B</a></li>
                  </ul>
                </li>
              </ul>
            </li>

            <!-- ET -->

               <li class="treeview">
              <a href="#"><i class="fa fa-circle-o text-aqua"></i> Electronic Telecom
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-aqua"></i> Level 1 ET
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 1 ET-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 1 ET-B</a></li>
                  </ul>
                </li>
                <!-- ET -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-aqua"></i> Level 2 ET
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 2 ET-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 2 ET-B</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 2 ET-C</a></li>
                  </ul>
                </li>
                <!-- RE -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-aqua"></i> Level 3 ET 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 3 ET-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> 3 ET-B</a></li>
                  </ul>
                </li>
              </ul>
            </li>

            <!-- RE -->

              <li class="treeview">
              <a href="#"><i class="fa fa-circle-o text-red"></i> Renewable Energy
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-red"></i> Level 1 RE
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 1 RE-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 1 RE-B</a></li>
                  </ul>
                </li>
                <!-- ET -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-red"></i> Level 2 RE
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 2 RE-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 2 RE-B</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 2 RE-C</a></li>
                  </ul>
                </li>
                <!-- RE -->
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o text-red"></i> Level 3 RE 
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 3 RE-A</a></li>
                    <li><a href="#"><i class="fa fa-circle-o text-red"></i> 3 RE-B</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            
          </ul>
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
        Department
  
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Department</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <!-- Used DATA WE NEED  -->

        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Department Features </h3>
              <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">
                <i class="fa fa-plus"> </i> Add Department
              </button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                 
              <table  class="table table-bordered table-striped">
                
                <tbody>
               
                  <?php
                      //include our connection
                 
                      //include_once('config.php');

                      $database = new Connection();
                        $db = $database->open();
                        $i=1;
                        //$dept_id = $_POST['dept_id'];
                      try{  
                          $sql = 'SELECT department.dept_id, department.dept_name,department.dept_head FROM department';

                         $query = $db->prepare($sql);

                         $query->execute(array('dept_id'=>$dept_id));

                         $dept = $query->fetchAll(PDO::FETCH_OBJ);

                         if ($query->rowCount() > 0) {
                          
                         echo "
                         <thead>
                            <tr>
                              <th>#</th>
                              <th>Department Code</th>
                              <th>Department Name</th>
                              <th>Head of Department </th>
                              <th>Action</th>
                            </tr>
                            </thead>";

                          foreach ($dept as $row) 
                          {
                            ?>

                            <tr>
                              <td><?php echo $i; ?></td>
                              <td><?php echo htmlentities($row->dept_id); ?></td>
                              <td><?php echo htmlentities($row->dept_name); ?></td>
                              <td><?php echo htmlentities($row->dept_head); ?></td>
                              
                              <td>
                                <a href="#edit_<?php echo $row->dept_id; ?>" class="btn btn-success btn-sm" data-toggle="modal"><span class="fa fa-edit "></span> Edit </a>
                                <a href="#delete_<?php echo $row->dept_id; ?>" class="btn btn-danger btn-sm" data-toggle="modal"><span class="fa fa-trash"></span> Delete </a>
                              </td>
                             
                            </tr>
                            <?php 
                            $i++;
                          }
                      }
                    }
                      catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                      }

                      //close connection
                      $database->close();

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
                <h4 class="modal-title">Add Department </h4>
              </div>
              <div class="modal-body">
                
                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
              <div class="box-body">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"> Department Code </label>

                  <div class="col-sm-9 <?php echo (!empty($dept_id_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="dept_id" class="form-control"  placeholder="Department Code">
                    <span class="help-block"><?php echo $dept_id_err; ?></span>
                  </div>
                </div> 

                <div class="form-group ">
                  <label for="inputEmail3" class="col-sm-3 control-label"> Department Name </label>

                  <div class="col-sm-9 <?php echo (!empty($dept_name_err)) ? 'has-error' : ''; ?>">
                    <select name="dept_name" class="form-control select2" style="width: 100%;">
                        <option selected="selected"> </option>
                        <option>Information Technology</option>
                        <option>Electronic and Telecommunication </option>
                        <option>Renewable Energy </option>
                      </select>
                      <span class="help-block"><?php echo $dept_name_err; ?></span>
                </div>
              </div>

                <div class="form-group">
                  <label for="inputdept_head3" class="col-sm-3 control-label">Head Of Department </label>

                  <div class="col-sm-9 <?php echo (!empty($dept_head_err)) ? 'has-error' : ''; ?>">
                   <select name="dept_head" class="form-control select2" style="width: 100%;">
                        <option selected="selected"> </option>
                        <option>Information Technology</option>
                        <option>Electronic and Telecommunication </option>
                        <option>Renewable Energy </option>
                      </select>
                      <span class="help-block"><?php echo $dept_head_err; ?></span>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Save</button>
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
      <b>Designed By</b> Robert & Rehema
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
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
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
