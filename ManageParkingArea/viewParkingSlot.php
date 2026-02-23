<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        table.center {
          margin-left: auto; 
          margin-right: auto;
        }

            h1{
                text-align: center;
            }

            .button-container {
                display: flex;
                justify-content: center;
                margin-top: 30px;
                
            }

            .button-container button {
                margin: 0 10px;
                padding: 15px 15px;
                font-size: 16px;
                background-color:  #17252A;
                color: white;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }


            .button-container button[type="book"]:hover {
                background-color: #0000FF;
            }

            .button-container button[type="view"]:hover {
                background-color: #0000FF;
            }

            main{
                padding-bottom:20px;
            }

            th{
                font-size:20px;
                text-align:left;
            }
            

    </style>
</head>
<body>

    <?php include '../Layout/adminHeader.php'; ?>
    <?php include '../DB_FKPark/dbcon.php'; ?>
   
    <main>

    <div style="padding-top:20px;" id="ParkingList">
    <div class="container">
        <table class="table table-hover table-bordered table-striped">
            <tr>
                <th style="text-align:center;">A</th>
                <th style="text-align:center;">B</th>
                <th style="text-align:center;">M</th>
            </tr>
            <?php
                $queryA = "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'A%'";
                $queryB = "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'B%'";
                $queryM = "SELECT * FROM parkingSlot WHERE parkingSlot_name LIKE 'M%'";

                $resultA = mysqli_query($con, $queryA);
                $resultB = mysqli_query($con, $queryB);
                $resultM = mysqli_query($con, $queryM);

                $maxRows = max(mysqli_num_rows($resultA), mysqli_num_rows($resultB), mysqli_num_rows($resultM));

                for ($i = 0; $i < $maxRows; $i++) {
                    echo "<tr>";
                    // A column
                    echo "<td style='text-align: center;'>";
                    if ($row = mysqli_fetch_assoc($resultA)) {
                        echo $row['parkingSlot_name'];
                    }
                    echo "</td>";

                    // B column
                    echo "<td style='text-align: center;'>";
                    if ($row = mysqli_fetch_assoc($resultB)) {
                        echo $row['parkingSlot_name'];
                    }
                    echo "</td>";

                    // M column
                    echo "<td style='text-align: center;'>";
                    if ($row = mysqli_fetch_assoc($resultM)) {
                        echo $row['parkingSlot_name'];
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>


    </main>
   
    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
