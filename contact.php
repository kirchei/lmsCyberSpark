<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number']; 
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg']; 
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if($select_contact->rowCount() > 0){
      $message[] = 'Message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      $message[] = 'Message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/styles.css">

   <!-- email API -->
   <script src="https://smtpjs.com/v3/smtp.js" defer></script>
   
   <!-- custom js file link  -->
   <script src="js/script.js" defer></script>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post" onsubmit="sendEmail(event)">
         <h3>Get in Touch</h3>
         <label for="emailform" class="form-label">Email address</label>
         <input type="email" id="emailform" placeholder="Enter your Email Address" name="email" required maxlength="50" class="box">
         <label for="subjectform" class="form-label">Subject</label>
         <input type="text" id="subjectform" placeholder="Enter subject" name="subject" required maxlength="50" class="box">
         <label for="messageform" class="form-label">Message</label>
         <textarea id="messageform" name="message" class="box" placeholder="Enter your message" required maxlength="1000" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" class="inline-btn" id="submitBtn">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Phone Number</h3>
         <a href="tel:1234567890">123-456-7890</a>
         <a href="tel:1112223333">111-222-3333</a>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>Email Address</h3>
         <a href="mailto:dlsudcyberspark@gmail.com">dlsudcyberspark@gmail.com</a>
         <a href="mailto:cybersparkdev@gmail.com">cybersparkdev@gmail.com</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Office Address</h3>
         <a href="#">53 P. Del Rosario Street, Cebu City, Cebu, Philippines - 400104</a>
      </div>


   </div>

</section>

<!-- contact section ends -->

<?php include 'components/footer.php'; ?>  
   
<script>

   function sendEmail(e) {
       e.preventDefault();

       Email.send({
           Host : "smtp.elasticemail.com",
           Username : "justinecarlalbay@gmail.com",
           Password : "C108B477214C8056761B4ADC524E0F1BECB9",
           To : 'justinecarlalbay@gmail.com',
           From : document.getElementById('emailform').value,
           Subject : document.getElementById('subjectform').value,
           Body : document.getElementById('messageform').value
       }).then(
         message => alert(message)
       );

       return true;
   }


</script>

</body>
</html>