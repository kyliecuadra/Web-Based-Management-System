<?php 
include("../connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MCC: File Dashboard</title>
    <link type="image/png" rel="icon" href="../img/homeicon.png">
    <meta name="viewport" content="width=device-witdth, initial-scale=1.0">
    <!-- BOXICONS CDN -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <!-- FONTAWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- BOOTSTRAP 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- LOCAL CSS -->
    <link rel="stylesheet" type="text/css" href="../css/a-filesdashboard.css">


</head>
<body>
    <div class="sidebar" style="border-right: 1px solid #003860;">
        <div class="menu-details">
            <i class='bx bx-menu sidebarBtn'></i>
            <span class="menu-name">Menu</span>
        </div>
        <ul class="nav-links">
            <li>
                <a href="mcc-files.php">
                    <i class= "bx bx-grid-alt text-white"></i>
                    <span class="link-name text-white">Home</span>
                </a>
            </li>
            <li>
                <a href="announcement.php">
                    <i class="fa-solid fa-bullhorn"></i> 
                    <span class="link-name">Announcements</span>
                </a>
            </li>
            <li>
                <a href="recycle-bin-dashboard.php">
                    <i class="fa-solid fa-trash"></i>
                    <span class="link-name">Recycle Bin</span>
                </a>
            </li>
            <li>
                <a href="../index.html">
                    <i class='bx bx-log-out'></i>
                    <span class="link-name">Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Main Content -->
    <section class="home-section">
        <nav class="">
            <div class="sidebar-button">
                <span class="dashboard">ADMIN DASHBOARD</span>
            </div>
            <!-- <div class="search-box">
                <input type="text" name="" placeholder="Search">
                <i class='bx bx-search'></i>
            </div> -->
            <div class="d-flex justify-content-center align-items-center">
                <span class="name">Admin</span>
            </div>
        </nav>

        <div class="container-fluid px-4">
            <div class="row g3 my-3">
                <div class="col-md-6 overview">
                    <a href="announcement.php">
                        <div class="p-3 shadow-sm d-flex justify-content-around align-items-center rounded" style="background-color: #4682B4; margin:  18px;padding: 115px !important;">
                            <div>
                                <h1 class="fs-2 text-white">TODAY'S EVENT</h3>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-6 overview">
                     <a href="pending-accounts.php">
                        <div class="pending-account p-3 shadow-sm d-flex justify-content-around align-items-center rounded text-white" style="background-color: #6A757A; 
                        margin: 18px;
                        height: 285px;">
                        <div>

                        <!--COUNT ALL THE FILES OF PENDING ACCOUNTS-->
                        <?php
                        $result = mysqli_query($connections, "SELECT COUNT(1) FROM pending_request_tbl");
                        $row = mysqli_fetch_array($result);

                        $total = $row [0];
                        echo ' <h3 class="fs-2"> '.$total.' </h3>'

                        ?>
                            <p>Pending Accounts</p>
                        </div>
                        <i class="fa-solid fa-user-clock text-white p-3" style="font-size: 40px;"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- ATTENDANCE REPORT -->
    <div class="attendance-tab-header px-4">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="" placeholder="Search">
                <button>Search</button>
            </div> 
        </div>
    </div>
    <div class="col documents-table">
        <table class="table sortable table-responsive-md table-bordered bg-white rounded shadow-sm  table-striped text-center">
            <thead class="thead-color" style="position: sticky; top: 0;">
                <tr>
                    <th scope="col">Owner Email</th>
                    <th scope="col">Team</th>
                    <th scope="col">File Name</th>
                    <th scope="col">File Type</th>
                    <th scope="col">File Size</th>
                    <th scope="col">Last Date Modified</th>
                    <th scope="col" style="pointer-events: none">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // DATA LIMIT SET TO 10
                $limit = 10;  
                if (isset($_GET["page"])) {
                    $page  = $_GET["page"]; 
                } 
                else{ 
                    $page=1;
                };  
                $start_from = ($page-1) * $limit;  

                function formatSizeUnits($bytes) { 
                    if ($bytes >= 1024) {
                        $bytes = number_format($bytes / 1024, 2) . ' MB'; 
                    } elseif ($bytes >= 0) {
                        $bytes = number_format($bytes, 2) . ' KB'; 
                    } else { 
                        $bytes = '0 bytes';
                    } return $bytes; 
                }

                $result = mysqli_query($connections, "SELECT * FROM filetbl");
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)){
                        $File_ID = $row['File_ID'];
                        $email = $row['Email'];
                        $team = $row['team'];
                        $FileName = $row['FileName'];
                        $FileType = $row['FileType'];
                        $FileSize = $row['FileSize'];
                        $LastModified = $row['LastModified'];
                        $expiration_date = $row['Expiration'];


                        echo ' <tr>
                        <td> '.$email.' </td>
                        <td> '.$team.' </td>
                        <td> '.$FileName.' </td>
                        <td> '.$FileType.' </td>
                        <td> '.formatSizeUnits($FileSize).' </td>
                        <td> '.$LastModified.' </td>
                        <td class="mx-auto d-flex justify-content-around"><a href="#"><i class="fa-solid fa-eye text-dark" style="font-size: 20px;"></i></a>
                        <a onclick="javascript:confirmationDelete($(this));return false;" href="../delete.php?deleteid='.$File_ID.'"><i class="fa-solid fa-trash text-dark" style="font-size: 20px;"></i></a></td>
                        </tr> ';

                        // DELETE IF FILE EXPIRED
                        $dateToday = date('Y-m-d H:i:s');
                        if($dateToday >= $expiration_date){
                            mysqli_query($connections, "DELETE FROM recycletbl WHERE Expiration = '".$dateToday."'");
                        }

                    }

                }
                ?>
                <!-- DELETE CONFIRMATION SCRIPT START -->
                <script type="text/javascript">
                    function confirmationDelete(anchor)
                    {
                       var conf = confirm('Are you sure want to delete this file?');
                       if(conf)
                          window.location=anchor.attr("href");
                  }
              </script>
              <!-- DELETE CONFIRMATION SCRIPT END -->
          </tbody>
      </table>
      <!-- PAGINATION START -->
       <div class="page d-flex justify-content-around"> <!-- AYAW GUMANA -->
                <?php
                $result_db = mysqli_query($connections,"SELECT COUNT(*) FROM filetbl"); 
                $row_db = mysqli_fetch_row($result_db);  
                $total_records = $row_db[0];  
                $total_pages = ceil($total_records / $limit); 
                /* echo  $total_pages; */
                ?>
                <strong>Page <?php echo $page." of ".$total_pages; ?></strong>
                <?php
                $pagLink = "<ul class='pagination'>";  
                for ($i=1; $i<=$total_pages; $i++) {
                  $pagLink .= "<li class='page-item'><a class='page-link' href='pending-accounts.php?page=".$i."'>".$i."</a></li>";   
              }
              echo $pagLink . "</ul>";  

              ?>
            </div>
            <!-- PAGINATION END -->
  </div>
</div>
</section>
<footer>&copy; Copyright 2022 - Project-IT-25 - Melham Construction Interns</footer>
<!-- CHART JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <!-- BOOTSTRAP JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>
    <!-- LOCAL JS -->
    <script type="text/javascript" src="../js/sidebar.js"></script>
    <script type="text/javascript" src="../js/graph.js"></script>
</body>
</html>