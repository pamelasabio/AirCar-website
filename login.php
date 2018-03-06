<?php
ob_start();
require_once 'dbconnect.php';
$error = false;

if( isset($_POST['btn-login']) ) { 
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if(empty($email)){
       $error = true;
       $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
       $error = true;
       $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
       $error = true;
       $passError = "Please enter your password.";
    }
  
    // if there's no error, continue to login
    if (!$error) { 
        $password = hash('sha256', $pass); // password hashing using SHA256
        $stmt3 = $conn->prepare("SELECT userId, userName, userPass FROM users WHERE userEmail=?");
        $stmt3->bind_param("s", $email);
        if($stmt3->execute()){
            /* bind result variables */
            $stmt3->bind_result($userId,$userName,$userPass);
            
            /* fetch value */
            if(($row = $stmt3->fetch()) == true){
                if($userPass == $password){
                    $_SESSION['user'] = $userId;
                }else{
                    $errMSG = "Incorrect Credentials, Try again...";
                }
            }
        }else{
            $errMSG = "Ops, something went wrong.";
        }
        
        $stmt3->close();
    }
 }
?>





<div id="loginbox" class="modal">
    <div id="containerId" class="container">
        <form id="loginForm" class="modal-content animate" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
            <span onclick="closeLoginTab()" class="close">&times;</span>            
            <?php
                   if ( isset($errMSG) ) {

            ?>
                <div class="form-group">
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                    </div>
                </div>
            <?php
                }
            ?>

            <div class="form-group">
                <div class="input-group" id="email">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                    <input type="email" name="email" class="form-control" placeholder="Your Email" required/>
                </div>
                <span class="text-danger"><?php if(isset($emailError)){echo $emailError;} ?></span>
            </div>
            <div class="form-group">
                <div class="input-group" id="password">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" name="pass" class="form-control" placeholder="Your Password" required/>
                </div>
                <span class="text-danger"><?php if(isset($passError)){echo $passError;} ?></span>
            </div>
            <div>
                <input type="checkbox" checked="checked" placeholder="Remember Me">
                <span>Remember Me</span>
                <span id="forgotpw" class="psw"><a href="#">Forgot password?</a></span>
            </div>
            <div class="form-group">
                <button id="login" type="submit" class="btn btn-block btn-primary" name="btn-login">Log In</button>
                <hr/>
            </div>
            <div class="form-group">
                <span id="noaccount">Don't have an account?</span>
                <h1 id="signup" onClick="callReg()" class="btn btn-block btn-primary logregbuttons" name="btn-signup">Sign Up</h1>

            </div>
        </form>
    </div>
</div>
