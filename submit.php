<?php
    session_start();
    if (!isset($_SESSION['SESSION_EMAIL'])) {
        header("Location: index.php");
        die();
    }

    include 'config.php';

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$_SESSION['SESSION_EMAIL']}'");

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);

       // echo "Welcome " . $row['name'] . " <a href='logout.php'>Logout</a>";
    }

    include 'config.php';
?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <!--<title>  Admin Dashboard </title>-->
    <link rel="stylesheet" href="css/style1.css" />
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="icon" type="image/x-icon" href="images/favicon .ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-details">
        

      </div>
      <ul class="nav-links">
        <li>
          <a href="welcome.php" class="active">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <!--<li>
          <a href="#">
            <i class="bx bx-box"></i>
            <span class="links_name">Product</span>
          </a>
        </li>

        <li>
          <a href="#">
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Past Reports</span>
          </a>
        </li>-->
        <li>
          <a href="Submit.php" >
            <i class="bx bx-upload"></i>
            <span class="links_name">Submit</span>
          </a>
        </li>

        <!--<li>
          <a href="#">
            <i class="bx bx-user"></i>
            <span class="links_name">Team</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-message"></i>
            <span class="links_name">Messages</span>
          </a>
        </li>-->

        <li class="log_out">
          <a href="logout.php">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
    </div>
    
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard"><?php echo "Welcome " . $row['name']?> </span>
        </div>
      </nav>
  </section>
    
  </div>
  
    <section class="container" id="Submit">
    <div class="Submit">
    <?php

  
    if(isset($_POST["import"])){
    $fileName = $_FILES["file"]["tmp_name"];

    if($_FILES["file"]["size"] > 0){
      $file = fopen($fileName , "r");

      while(($column = fgetcsv($file, 10000 , ",")) !== FALSE){
        $sqlInsert ="Insert into data (Customer_id, user_id, Gender, Age, Annual_income, Spending_score) values('$column[0]','{$_SESSION['SESSION_ID']}','$column[1]','$column[2]','$column[3]','$column[4]')";
           
        $result=mysqli_query($conn, $sqlInsert);
      }
      if(!empty($result)){
       echo"";
      }  
      else{
       echo"Problem in importing";
      }
    }
}

?>


<form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">

<div>
    <label>Choose csv file</label>
    <input type="file" name="file" accept=".csv">
    <button type="submit" name="import">Import</button>
</div>

</form>

<?php

//display uploaded data

$sqlSelect = "SELECT * from data WHERE user_id = '{$_SESSION['SESSION_ID']}'";

$result=mysqli_query($conn, $sqlSelect);
if(mysqli_num_rows($result) > 0){
    ?>
    <table>
    <thead>
    <tr>
    <th>Customer ID</th>
    <th>Gender</th>
    <th>Age</th>
    <th>Annual Income</th>
    <th>Spending Score</th>
    </tr>
    </thead>
    <?php 
    while($row = mysqli_fetch_array($result)){

    ?>
    <tbody>
    <tr>
    <td><?php echo $row['Customer_id'];?></td>
    <td><?php echo $row['Gender'];?></td>  
    <td><?php echo $row['Age'];?></td>  
    <td><?php echo $row['Annual_income'];?></td>  
    <td><?php echo $row['Spending_score'];?></td>   
    </tr>
    </tbody>

    <?php } ?>

    </table>
    <?php }

    ?>
    </div>
    </section>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
    
  </body>
</html>
