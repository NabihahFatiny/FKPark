<?php
session_start(); // Ensure the session is started
include '../DB_FKPark/dbcon.php';

$con = mysqli_connect("localhost", "root", "", "fkpark");



// Check if the user is logged in and the user ID is set in the session
$studentID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;

// If the student ID is not set, redirect to the login page
if ($studentID === null) {
    die('Student ID not found in session. Please login again.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Student Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Dashboard/adminDashboard.css">

    <!-- Include ApexCharts Library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .grid-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            flex: 1;
            padding: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-bar input[type="text"] {
            width: 200px;
            padding: 8px;
            font-size: 14px;
            border: 2px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        .search-bar input[type="submit"] {
            padding: 5px 12px;
            font-size: 14px;
            cursor: pointer;
        }
        
        .search-results table {
            width: 100%;
            border-collapse: collapse;
        }

        .search-results {
            margin-top: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .search-results p {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .search-results table {
            width: 100%;
            border-collapse: collapse;
        }

        .search-results th, .search-results td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .search-results th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .search-results tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .search-results tr:hover {
            background-color: #ddd;
        }

        .search-results th, .search-results td {
            padding: 12px 15px;
        }

        
    </style>
</head>
<body>

<?php include '../Layout/studentHeader.php'; ?>
<div class="grid-container">

    <!-- Main -->
    <main class="main-container">
        <div class="main-title">
            <p class="font-weight-bold">DASHBOARD</p>
        </div>

        <div class="main-cards">

              <!-- Display Total Summon Count -->
        <div class="card">
            <div class="card-inner">
                <p class="text-primary">TOTAL SUMMON</p>
                <span><img class="colored_image" style="width:50px; height:50px;" src="../resource/sad.png" alt="Sad"></span>
            </div>
            <span class="text-primary font-weight-bold">
                <?php
                $querySummons = "SELECT COUNT(*) AS summon_count 
                                 FROM Summon s
                                 JOIN Vehicle v ON s.vehicle_numPlate = v.vehicle_numPlate
                                 JOIN Student st ON v.student_ID = st.student_ID
                                 WHERE st.student_ID = ?";
                
                $stmtSummons = mysqli_prepare($con, $querySummons);
                mysqli_stmt_bind_param($stmtSummons, 'i', $studentID);
                mysqli_stmt_execute($stmtSummons);
                $resultSummons = mysqli_stmt_get_result($stmtSummons);

                $totalSummonCount = 0;

                if ($resultSummons && mysqli_num_rows($resultSummons) > 0) {
                    $rowSummons = mysqli_fetch_assoc($resultSummons);
                    $totalSummonCount = (int)$rowSummons['summon_count'];
                }

                echo $totalSummonCount;
                ?>
            </span>
        </div>


        <div class="card">
            <div class="card-inner">
                <p class="text-primary">TOTAL DEMERIT</p>
                <span>
                    <img class="colored_image" style="width:50px; height:50px;" src="../resource/demerit.png" alt="Demerit">
                </span>
            </div>
            <!-- Update the total demerit points count with PHP -->
            <span class="text-primary font-weight-bold">
                    <?php
                    $querySummons = "SELECT SUM(summon_demerit) AS summon_demerit 
                                    FROM Summon s
                                    JOIN Vehicle v ON s.vehicle_numPlate = v.vehicle_numPlate
                                    JOIN Student st ON v.student_ID = st.student_ID
                                    WHERE st.student_ID = ?";
                    
                    $stmtSummons = mysqli_prepare($con, $querySummons);
                    mysqli_stmt_bind_param($stmtSummons, 'i', $studentID);
                    mysqli_stmt_execute($stmtSummons);
                    $resultSummons = mysqli_stmt_get_result($stmtSummons);

                    $totalSummons = 0;

                    if ($resultSummons && mysqli_num_rows($resultSummons) > 0) {
                        $rowSummons = mysqli_fetch_assoc($resultSummons);
                        $totalDemeritPoints = (int)$rowSummons['summon_demerit'];
                    }

                    echo $totalDemeritPoints;
                ?>
            </span>
        </div>




        <div class="card">
            <div class="card-inner">
                <p class="text-primary">TOTAL VEHICLE REGISTERED</p>
                <span><img class="colored_image" style="width:50px; height:50px;" src="../resource/available1.png" alt="QR Code"></span>
            </div>
            <span class="text-primary font-weight-bold">
                <?php
                    // Use prepared statement to prevent SQL injection
                    $query5 = "SELECT COUNT(*) AS vehicle_count FROM vehicle WHERE student_ID = ?";
                    $stmt5 = mysqli_prepare($con, $query5);
                    mysqli_stmt_bind_param($stmt5, 'i', $studentID);
                    mysqli_stmt_execute($stmt5);
                    $result5 = mysqli_stmt_get_result($stmt5);

                    $totalRegisteredCount = 0;

                    if ($result5 && mysqli_num_rows($result5) > 0) {
                        $row5 = mysqli_fetch_assoc($result5);
                        $totalRegisteredCount = (int)$row5['vehicle_count'];
                    }

                    echo $totalRegisteredCount;

                    // Close the statement and the connection
                    mysqli_stmt_close($stmt5);
                ?>
            </span>
        </div>

        <div class="card">
                  <div class="card-inner">
                      <p class="text-primary">TOTAL BOOKING MADE</p>
                      <span><img  class="colored_image" style="width:50px; height:50px;" src="../resource/check1.png" alt="Available"></span>
                  </div>
                  <span class="text-primary font-weight-bold">
                    <?php
                      // Assuming $con is your mysqli connection and $stmt4 is your prepared statement

                          $query4 = "SELECT COUNT(*) AS total_booking FROM booking WHERE student_ID = ?";
                          
                          // Prepare the statement
                          $stmt4 = mysqli_prepare($con, $query4);
                          
                          // Assuming $studentID is set correctly earlier in your code
                          mysqli_stmt_bind_param($stmt4, 'i', $studentID);
                          
                          // Execute the statement
                          mysqli_stmt_execute($stmt4);
                          
                          // Get the result
                          $result4 = mysqli_stmt_get_result($stmt4);
                          
                          $totalBookingCount = 0;
                          
                          if ($result4 && mysqli_num_rows($result4) > 0){
                              $row4 = mysqli_fetch_assoc($result4);
                              $totalBookingCount = (int)$row4['total_booking'];
                          }
                          
                          echo $totalBookingCount;
                    ?>
                  </span>
              </div>

              

        </div>

        <div class="charts">

              <div class="charts-card">
                  <p class="chart-title">TOTAL DEMERIT</p>
                  <div id="bar-chart"></div>
              </div>
              <div class="charts-card">
                  <p class="chart-title">TOTAL BOOKING</p>
                  <div id="area-chart"></div>
              </div>
        

        </div>

        <div class="search-bar">
            <form method="POST" action="">
                <input type="text" name="search_query" placeholder="Search..." required>
                <input type="submit" value="Search">
            </form>

            <!-- Search Results -->
        </div>
 <!-- Search Results -->
 <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_query = mysqli_real_escape_string($con, $_POST['search_query']);
    
    // Query to fetch search results based on the search query

    $searchQuery = "SELECT * FROM student WHERE student_demtot LIKE '%$search_query%'";
    $searchResult = mysqli_query($con, $searchQuery);



        // Check if there are any search results
        if ($searchResult && mysqli_num_rows($searchResult) > 0) {
          echo '<div class="search-results">';
          echo '<p>Search Results: ' . htmlspecialchars($search_query) . '</p>';
          echo '<table>';
          echo '<tr><th>Student ID</th><th>Demerit</th></tr>';
  
          // Loop through and display each search result
          while ($row = mysqli_fetch_assoc($searchResult)) {
              $studentId = $row['student_ID'];
              $studentDemtot = $row['student_demtot'];
  
              echo '<tr><td>' . htmlspecialchars($studentId) . '</td><td>' . htmlspecialchars($studentDemtot) . '</td></tr>';
          }
  
          echo '</table>';
          echo '</div>';
      } else {
          // Display message if no results are found
          echo '<div class="search-results">';
          echo '<p>No results found for "' . htmlspecialchars($search_query) . '"</p>';
          echo '</div>';
      }

   
}
?>

    </main>
    <!-- End Main -->

</div>

<!-- Scripts -->
<!-- ApexCharts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
<!-- Custom JS -->
<script>
  // ---------- CHARTS ----------

  // BAR CHART FOR TOTAL DEMERIT
  const barChartOptions = {
        series: [
            {
                name: 'Total Demerit',
                data: [], // Initialize with empty data
            },
        ],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false,
            },
        },
        colors: ['#246dec'],
        plotOptions: {
            bar: {
                distributed: true,
                borderRadius: 4,
                horizontal: false,
                columnWidth: '40%',
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        xaxis: {
            categories: ['Total Demerit'],
        },
        yaxis: {
            title: {
                text: 'Points',
            },
        },
    };

    const barChart = new ApexCharts(
        document.querySelector('#bar-chart'),
        barChartOptions
    );
    barChart.render();

    <?php
    // Fetch total demerit points for student_ID through vehicle_numPlate from vehicle
    $summonQuery = "SELECT SUM(summon_demerit) AS total_demerit 
                    FROM Summon s
                    JOIN Vehicle v ON s.vehicle_numPlate = v.vehicle_numPlate
                    JOIN Student st ON v.student_ID = st.student_ID
                    WHERE st.student_ID = ?";
    $stmtSummon = $con->prepare($summonQuery);
    $stmtSummon->bind_param("i", $studentID);
    $stmtSummon->execute();
    $summonResult = $stmtSummon->get_result();
    $summonData = $summonResult->fetch_assoc()['total_demerit'];
    $stmtSummon->close();
    mysqli_close($con);
    ?>
    const summonData = [<?php echo $summonData; ?>];

    // Function to update bar chart data with total demerit points
    function updateBarChartData(totalDemeritPoints) {
        console.log('Updating bar chart data with total demerit points:', totalDemeritPoints); // Debugging line
        barChart.updateSeries([{
            data: [totalDemeritPoints] // Update with the total demerit points
        }]);
    }

    // Call the function to update bar chart data with total demerit points
    updateBarChartData(<?php echo $totalDemeritPoints; ?>);

     // AREA CHART FOR TOTAL BOOKING
     const areaChartOptions = {
        series: [{
            name: 'Total Booking',
            data: [<?php echo $totalBookingCount; ?>], // Initialize with the fetched booking count
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: {
                show: false,
            },
        },
        colors: ['#246dec'],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'smooth',
        },
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        markers: {
            size: 0,
        },
        yaxis: {
            title: {
                text: 'Total Booking',
            },
        },
        tooltip: {
            shared: true,
            intersect: false,
        },
    };

    const areaChart = new ApexCharts(
        document.querySelector('#area-chart'),
        areaChartOptions
    );
    areaChart.render();
  </script>

  <?php include '../Layout/allUserFooter.php'; ?>


</body>
</html>
