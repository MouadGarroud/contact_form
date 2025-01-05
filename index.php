<!-- Mouad Garroud -->
<?php
// Database connection settings
$localhost = 'localhost';
$username = 'root';
$password = '';
$dbname = 'test';
// Establish the connection to the database
$conn = mysqli_connect($localhost, $username, $password, $dbname);
// Check if the connection failed and display error
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="This is a popup form to send message">
    <meta name="keywords" content="popup, form, message">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
</head>
<body>
    <div class="container">
        <form method="post" action="">
            <div class="popup">
                <h2>Send us a Message</h2>
            </div>
            <div class="row">
                <div class="icon-input">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Enter your fullname" name="name" minlength="6" maxlength="30" id="name" required>
                </div>
                <div class="icon-input">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Enter your email" minlength="9" maxlength="30" name="email" id="email" required>
                </div>
            </div>
            <div class="row">
                <div class="icon-input">
                    <i class="fas fa-phone"></i>
                    <input type="tel" placeholder="Enter your phone number" minlength="8" maxlength="30" name="phone" id="phone">
                </div>
                <div class="icon-input">
                    <i class="fas fa-globe"></i>
                    <input type="url" placeholder="Enter your website" name="web" id="web">
                </div>
            </div>
            <div class="icon-input">
                <i class="fas fa-comment"></i>
                <textarea name="msg" class="msg" id="Message" placeholder="Write your message" required minlength="25" maxlength="255"></textarea>
            </div><br>
            <p>
            <?php
                if (isset($_POST['submit'])) {
                    $username = $_POST['name'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $website = $_POST['web'] ?: "null";
                    $msg = $_POST['msg'];
                    $currentTime = (new DateTime())->format('Y-m-d H:i:s');
                    // Check if the email exists and was used in the last hour
                    $stmt = $conn->prepare("SELECT date FROM contact WHERE email = ? ORDER BY date DESC LIMIT 1");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($lastMessageTime);
                    $stmt->fetch();
                    $stmt->close();
                    if ($lastMessageTime) {
                        $lastMessageDateTime = new DateTime($lastMessageTime);
                        $timeDifference = $lastMessageDateTime->diff(new DateTime($currentTime));
                        // Check if less than one hour has passed
                        if ($timeDifference->h < 1 && $timeDifference->days == 0) {
                            echo '<p style="color:red">You can only send one message per hour. Please try again later.</p>';
                            exit;
                        }
                    }
                    // If no recent message or more than an hour has passed, insert the new message
                    $stmt = $conn->prepare("INSERT INTO contact (name, email, phone, web, msg, date) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $username, $email, $phone, $website, $msg, $currentTime);
                    if ($stmt->execute()) {
                        echo "<p>The message has been sent. <b>You can send again in an hour.</b></p>";
                    } else {
                        echo "<p>Something went wrong. Please try again.</p>";
                    }
                    $stmt->close();
                }
                ?>
            </p>
            <button type="submit" class="send" name="submit">Send</button>            
        </form>
    </div>
</body>
</html>
