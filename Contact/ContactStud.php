<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            height: 100vh;
        }
        .container-contact-us {
            width: 80%;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 20px;
            text-align: center;
        }
        .our-image {
            border-radius: 50%;
        }
        @media (max-width: 600px) {
            table, th, td {
                display: block;
                width: 100%;
            }
            th, td {
                padding: 10px;
                text-align: center;
            }
            img {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>
<body>
<?php include '../Layout/studentHeader.php'; ?>

    <div class="container-contact-us">
        <table>
            <tr>
                <th><img src="../resource/akmal.png" alt="akmal" width="100" height="100" class="our-image"></th>
                <th><img src="../resource/arif.png" alt="arif" width="100" height="100" class="our-image"></th>
                <th><img src="../resource/harith.png" alt="harith" width="100" height="100" class="our-image"></th>
                <th><img src="../resource/azam.png" alt="Azam" width="100" height="100" class="our-image"></th>
            </tr>
            <tr>
                <td>CB22071</td>
                <td>CB22085</td>
                <td>CB22028</td>
                <td>CB22129</td>
            </tr>
        </table>
    </div>

    <?php include '../Layout/allUserFooter.php'; ?>

</body>
</html>
