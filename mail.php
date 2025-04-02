<?php
header("Access-Control-Allow-Origin: https://itzanasafzal.github.io");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

echo "CORS header sent!";
// Handle preflight OPTIONS request (CORS fix)
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit();
}

// Include PHPMailer manually (Ensure correct path!)
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["Name"]);
    $email = htmlspecialchars($_POST["E-mail"]);
    $message = htmlspecialchars($_POST["Message"]);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'anasafzalg85@gmail.com'; // Your Gmail
            $mail->Password = 'fjrpfzncqymakndc'; // Use an App Password, never your actual password!
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email Content
            $mail->setFrom('anasafzalg85@gmail.com', 'Portfolio Website');
            $mail->addReplyTo($email, $name);
            $mail->addAddress('anasafzalg85@gmail.com');
            $mail->Subject = "New Contact Form Message";
            $mail->isHTML(true);
            $mail->Body = "<h3>New message from your website</h3>
                           <p><strong>Name:</strong> $name</p>
                           <p><strong>Email:</strong> $email</p>
                           <p><strong>Message:</strong> $message</p>";

            if ($mail->send()) {
                echo json_encode(["status" => "success", "message" => "✅ Message sent successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "❌ Message could not be sent."]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "❌ Error: " . $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "❌ Please fill in all fields."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "❌ Invalid request."]);
}


































// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/Exception.php';
// require 'PHPMailer/PHPMailer.php';
// require 'PHPMailer/SMTP.php';

// $mail = new PHPMailer(true);

// try {
//     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//     $mail->isSMTP();
//     $mail->Host       = 'smtp.gmail.com';
//     $mail->SMTPAuth   = true;
//     $mail->Username   = 'anasafzalg85@gmail.com'; // Replace with your email
//     $mail->Password   = 'fjrpfzncqymakndc'; // Use App Password (not your actual password)
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
//     $mail->Port       = 465;

//     $mail->setFrom('anasafzalg85@gmail.com', 'web client');
//     $mail->addAddress('anasafzalg85@gmail.com', 'Recipient Name');

//     $mail->isHTML(true);
//     $mail->Subject = 'New Contact Form Message';
//     $mail->Body    = 'This is a test message from your PHP mail script.';

//     $mail->send();
//     echo '✅ Message sent successfully!';
// } catch (Exception $e) {
//     echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }
?>
