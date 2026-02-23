<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../Manage Login/login.html");
    exit;
}

$con = mysqli_connect("localhost", "root", "", "fkpark");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$studentID = $_SESSION['userID'];

// Check if a specific notification is clicked
$inboxID = isset($_GET['inbox_ID']) ? intval($_GET['inbox_ID']) : 0;

include '../Layout/studentHeader.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inbox</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .inbox-container {
            width: 95%;
            margin: 30px auto;
            padding: 20px;
            background-color: #F9F9F9;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .message-list {
            list-style: none;
            padding: 0;
        }
        .message-list li {
            background-color: #fff;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
        }
        .message-list a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .message-detail {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 15px;
            color: #007BFF;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="inbox-container">
    <h2>Your Inbox</h2>

    <?php if ($inboxID > 0): ?>
        <!-- Show detailed message -->
        <?php

                    // Mark message as read
            $updateQuery = "UPDATE inbox SET is_read = 1 WHERE inbox_ID = ? AND student_ID = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ii", $inboxID, $studentID);
            mysqli_stmt_execute($updateStmt);

            $detailQuery = "SELECT i.message, i.time, b.booking_date, b.booking_startTime, b.booking_endTime, b.parkingSlot_ID, ps.parkingSlot_name
                FROM inbox i
                JOIN booking b ON i.booking_ID = b.booking_ID
                JOIN parkingslot ps ON b.parkingSlot_ID = ps.parkingSlot_ID
                WHERE i.inbox_ID = ? AND i.student_ID = ?";

            $stmt = mysqli_prepare($con, $detailQuery);
            mysqli_stmt_bind_param($stmt, "ii", $inboxID, $studentID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if ($row = mysqli_fetch_assoc($result)):
        ?>
        <a href="inbox.php" class="back-link">← Back to Inbox</a>
        <div class="message-detail">
            <p><strong>Booking Date:</strong> <?= htmlspecialchars($row['booking_date']) ?></p>
            <p><strong>Booking Time:</strong> <?= htmlspecialchars($row['booking_startTime']) ?> - <?= htmlspecialchars($row['booking_endTime']) ?></p>
            <p><strong>Parking Slot ID:</strong> <?= htmlspecialchars($row['parkingSlot_ID']) ?></p>
            <p><strong>Parking Slot:</strong> <?= htmlspecialchars($row['parkingSlot_name']) ?></p>
            <p><strong>Message:</strong></p>
            <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
            <p><small><em>Received at: <?= $row['time'] ?></em></small></p>
        </div>

        <?php else: ?>
            <p>Message not found or does not belong to you.</p>
        <?php endif; ?>

    <?php else: ?>
        <!-- Show list of messages -->
        <ul class="message-list">
            <?php
                $listQuery = "SELECT inbox_ID, message, time, is_read FROM inbox WHERE student_ID = ? ORDER BY time DESC";
                $stmt = mysqli_prepare($con, $listQuery);
                mysqli_stmt_bind_param($stmt, "i", $studentID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)):
                        $shortMsg = substr($row['message'], 0, 50) . (strlen($row['message']) > 50 ? "..." : "");
                        $status = $row['is_read'] ? 'Read' : 'Unread';  // Determine read/unread status
            ?>
                        <li>
                            <a href="inbox.php?inbox_ID=<?= $row['inbox_ID'] ?>">
                                <?= htmlspecialchars($shortMsg) ?>
                            </a>
                            <span style="float: right;"><?= $status ?></span> <!-- Display status at the right -->
                            <br>
                            <small><em>Received at: <?= $row['time'] ?></em></small>
                        </li>
            <?php
                    endwhile;
                else:
                    echo "<p>No messages yet.</p>";
                endif;
            ?>
        </ul>

    <?php endif; ?>

</div>

</body>
</html>

<?php
mysqli_close($con);
include '../Layout/allUserFooter.php';
?>
