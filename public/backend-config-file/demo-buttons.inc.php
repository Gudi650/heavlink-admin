<?php


//require the session
require_once __DIR__ . '/../includes/session_config.inc.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//required files
require_once __DIR__ . '/../../vendor/autoload.php';



//checking if this page was accessed via post method

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    //obtain the email from the post method 
    $email = $_POST['email'] ?? '';

    //obtaining the role from the post method
    $role = $_POST['role'] ?? '';

    //obtaining the first name from the post method
    $fname = $_POST['fname'] ?? '';

    //obtaining the last name from the post method
    $lname = $_POST['lname'] ?? '';

    //obtaining the church name from the post method
    $churchname = $_POST['churchname'] ?? '';



    //require the db connection
    require_once __DIR__ . '/../includes/dbh.inc.php';

    //approving the approve button
    if ($_POST['action'] === 'approve' && $email) {
        
        //updating the status and seting the approvedat timestand
        $query = "UPDATE demo SET ApprovedAt = CURRENT_TIMESTAMP, Status = 'Approved' WHERE Email = :email";
        $stmt = $pdo->prepare($query);
        $stmt ->bindParam(':email', $email);
        $stmt->execute();


        /*
        --------------------------------
        --------------------------------
           EMAIL AUTOMATION
        --------------------------------
        --------------------------------
        */
        //sending email to the user about the approval of demo request
        try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'godluckmsangi3@gmail.com';
        $mail->Password   = 'iuoxemhzpmujlxay';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        $mail->setFrom('godluckmsangi3@gmail.com', 'Godluck Msangi');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = "Welcome to Salt";
        $mail->Body    = "We cordially welcome you to Salt.<br><br>
                        Your Salt installation has just been created for you. You can log in with the user <strong>$email</strong> and the password <strong>". $role ."</strong>.<br>
                        For security reasons, please change your password immediately after the first login.";

        $mail->send();
        } catch (Exception $e) {
            error_log("Email could not be sent. PHPMailer Exception: {$e->getMessage()}");
            echo "There is an error here";
        }

        //populating the data to the db with the credentials in users table
        $defaultPassword = password_hash($role, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (email, password_hash,first_name, last_name) VALUES (:email, :password, :fname, :lname)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $defaultPassword);
        $stmt->bindParam(':fname', $_POST['fname']);
        $stmt->bindParam(':lname', $_POST['lname']);
        $stmt->execute();


        //populating the data to the db with the credentials in church table
        $query = "INSERT INTO churches (name) VALUES (:churchname)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':churchname', $churchname);
        $stmt->execute();

        //return to the demo page after approval 
        header("Location: ../demo.php");
        exit();
    }



    //approving the delete button
    if ($_POST['action'] === 'delete' && $email) {
        
        //deleting the data from the db 
        $query = "DELETE FROM demo WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt ->bindParam(':email', $email);
        $stmt ->execute();

        //return to the demo page after deleting the data
        header("Location: ../demo.php");
        exit();
    }

}else{

    //return the individual to the previous page
    header("Location: ../demo.php");

}