<?php require "includes/header.php"; ?>
<?php require "config/config.php";?>

<?php

if(!isset($_SESSION['user_id'])){
    echo "<script> window.location.href='".APPURL."/auth/login.php'</script>";
}

$data = $conn->query("SELECT * FROM users WHERE id=$_SESSION[user_id]");
$data->execute();
$userData = $data->fetch(PDO::FETCH_OBJ);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'mail/src/Exception.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/SMTP.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

if(isset($_POST['submit']) AND isset($_POST['Message'])){
    //Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'PorDin1122@gmail.com';                     //SMTP username
    $mail->Password   = 'agbhdcgefpgvemou';                               //SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('PorDin1122@gmail.comm', 'Freshcery-App');
    $mail->addAddress('PorDin1122@gmail.com', 'Owner');     //Add a recipient
    $mail->addAddress('PorDin1122@gmail.com');               //Name is optional
    $mail->addReplyTo($_POST['email'],$_POST['fullname']);
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Customer FeedBack';
    $mail->Body    = "Title: Customer FeedBack <br><br>".$_POST['Message']."<br><br> Sent by Customer: ".$_POST['fullname']."<br> Customer Email: ".$_POST['email'];
    //$mail->AltBody = "'FROM: ".$userData->email."'";

    $mail->send();
    echo "<script>alert('Message has been sent')</script>";
} catch (Exception $e) {
    echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
}
}

?>
    <div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Contact
                    </h1>
                    <p class="lead">
                        Don't Hesitate to Contact Us.
                    </p>
                </div>
            </div>
        </div>

        <section class="pb-0">
            <div class="contact1 mb-5">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-lg-7">
                            <div class="contact-wrapper">
                                <h3 class="title font-weight-normal mt-0 text-left">Send Us a Message</h3>
                                <form data-aos="fade-left" data-aos-duration="1200" action="contact.php" method="POST">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" placeholder="Full Name" name="fullname" value="<?php echo "$userData->fullname";?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo "$userData->email";?>">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <textarea class="form-control" rows="3" placeholder="Message" name="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-right">
                                            <button type="submit" class="btn btn-lg btn-primary mb-5" name="submit">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="detail-wrapper p-5 bg-primary">
                                <h3 class="font-weight-normal mb-3 text-light">
                                    Freshcery Headquarter
                                </h3>

                                <p class="text-light">
                                    Russian Federation Blvd (110)<br> 
                                    Phnom Penh<br> 
                                    120404
                                </p>

                                <p class="text-light">
                                    <i class="fas fa-phone"></i> 099215186<br>
                                    <i class="fas fa-envelope"></i> PorDin1122@gmail.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d58885.9114530437!2d104.82943482744295!3d11.579529628971482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109519fad8972b5%3A0xbdd878abfba713fd!2sRUPP%20STEM%20Building!5e0!3m2!1sen!2skh!4v1741955346616!5m2!1sen!2skh" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen></iframe>
        </section>
    </div>
<?php require "includes/footer.php"; ?>
