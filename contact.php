<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/main.css?v=<?=time()?>" type="text/css" >
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">
<h3>get in touch</h3>
<form action="" method="post">

   <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         
      <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>

      
      
      <input type="text" name="name" placeholder="Name" required maxlength="20" class="box" value="<?= $fetch_profile["name"]; ?>" >   
      <input type="email" name="email" placeholder="Email" required maxlength="50" class="box" value="<?= $fetch_profile["email"]; ?>"  >
      <input type="number" name="number" min="0" max="9999999999" placeholder="Phone Number" required onkeypress="if(this.value.length == 10) return false;" class="box">
      <textarea name="msg" class="box" placeholder="Message" cols="30" rows="10" required ></textarea>
      
      <button type="submit" value="send message" name="send" class="btn-1"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </button>
   </form>
   <?php
      }
   }else{
      echo '<p class="empty-1">You need to login first</p>';
   }
   ?>
   

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<script>
document.querySelectorAll('.button').forEach(button => {

let getVar = variable => getComputedStyle(button).getPropertyValue(variable);

button.addEventListener('click', e => {

    if(!button.classList.contains('active')) {

        button.classList.add('active');

        gsap.to(button, {
            keyframes: [{
                '--left-wing-first-x': 50,
                '--left-wing-first-y': 100,
                '--right-wing-second-x': 50,
                '--right-wing-second-y': 100,
                duration: .2,
                onComplete() {
                    gsap.set(button, {
                        '--left-wing-first-y': 0,
                        '--left-wing-second-x': 40,
                        '--left-wing-second-y': 100,
                        '--left-wing-third-x': 0,
                        '--left-wing-third-y': 100,
                        '--left-body-third-x': 40,
                        '--right-wing-first-x': 50,
                        '--right-wing-first-y': 0,
                        '--right-wing-second-x': 60,
                        '--right-wing-second-y': 100,
                        '--right-wing-third-x': 100,
                        '--right-wing-third-y': 100,
                        '--right-body-third-x': 60
                    })
                }
            }, {
                '--left-wing-third-x': 20,
                '--left-wing-third-y': 90,
                '--left-wing-second-y': 90,
                '--left-body-third-y': 90,
                '--right-wing-third-x': 80,
                '--right-wing-third-y': 90,
                '--right-body-third-y': 90,
                '--right-wing-second-y': 90,
                duration: .2
            }, {
                '--rotate': 50,
                '--left-wing-third-y': 95,
                '--left-wing-third-x': 27,
                '--right-body-third-x': 45,
                '--right-wing-second-x': 45,
                '--right-wing-third-x': 60,
                '--right-wing-third-y': 83,
                duration: .25
            }, {
                '--rotate': 55,
                '--plane-x': -8,
                '--plane-y': 24,
                duration: .2
            }, {
                '--rotate': 40,
                '--plane-x': 45,
                '--plane-y': -180,
                '--plane-opacity': 0,
                duration: .3,
                onComplete() {
                    setTimeout(() => {
                        button.removeAttribute('style');
                        gsap.fromTo(button, {
                            opacity: 0,
                            y: -8
                        }, {
                            opacity: 1,
                            y: 0,
                            clearProps: true,
                            duration: .3,
                            onComplete() {
                                button.classList.remove('active');
                            }
                        })
                    }, 2000)
                }
            }]
        })

        gsap.to(button, {
            keyframes: [{
                '--text-opacity': 0,
                '--border-radius': 0,
                '--left-wing-background': getVar('--primary-darkest'),
                '--right-wing-background': getVar('--primary-darkest'),
                duration: .1
            }, {
                '--left-wing-background': getVar('--primary'),
                '--right-wing-background': getVar('--primary'),
                duration: .1
            }, {
                '--left-body-background': getVar('--primary-dark'),
                '--right-body-background': getVar('--primary-darkest'),
                duration: .4
            }, {
                '--success-opacity': 1,
                '--success-scale': 1,
                duration: .25,
                delay: .25
            }]
        })

    }

})

});

</script>
</body>
</html>