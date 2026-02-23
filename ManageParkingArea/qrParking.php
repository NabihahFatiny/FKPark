<?php
    include '../DB_FKPark/dbcon.php';
    include '../phpqrcode/qrlib.php';
    $path = '../resource';
    $qrcode = $path.time().".png";
    $qrimage = time().".png";

    if(isset($_REQUEST['add_parking']))
    {
    $qrtext = $_REQUEST['p_area'];
    $query = mysqli_query($connection,"insert into parking set parking_qr='$qrimage'");
    }

    QRcode :: png($qrtext, $qrcode, 'H', 4, 4);
    echo "<img src='".$qrcode."'>";
?>