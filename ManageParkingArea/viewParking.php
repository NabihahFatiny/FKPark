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

            .square {
                height: 220px;
                width: 350px;
                background-color: #254D98;
                border-radius: 20%;
                color:white;
                padding-top:20px;
                padding-left:20px;
                padding-right:20px;
                
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

    <div id="ParkingList">
        <div class="container">
            <table style="margin-top:30px;" class="table table-hover table-bordered table-striped" >
                <tr>
                    <th style="text-align:center;">Parking Area</th>
                    <th style="text-align:center;" >Action</th>
                </tr>
                <tbody>
                    <?php
                        $query = "select * from `parkingArea`";

                        $result = mysqli_query($con, $query);

                        if(!$result){
                            die("query Failed".mysqli_error());
                        }
                        else{
                            while($row = mysqli_fetch_assoc($result)){

                                ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo$row['parkingArea_name']; ?></td>
                                        <td>
                                            <div style="margin-top:5px; margin-bottom:5px; " class="button-container">
                                                <a href="view-link-here" >
                                                    <button  style="width:100px; padding:10px 10px;"type="view">View</button>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>


        
    </table>
    </div>
    

    </div>

    
        
    </main>
   
    <?php include '../Layout/allUserFooter.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>