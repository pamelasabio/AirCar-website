<?php
require_once 'dbconnect.php';
$error = false;
$name= "";
$email= "";
$pass= "";
$repass= "";
$nameError= "";
$emailError= "";
$passError= "";
$repassError= "";

if ( isset($_POST['btn-signup']) ) {   // check if submit button was pressed     
    // clean user inputs to prevent sql injections
    $name = trim($_POST['name']);
    $name = strip_tags($name);
    $name = htmlspecialchars($name);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $repass = trim($_POST['repass']);
    $repass = strip_tags($repass);
    $repass = htmlspecialchars($repass);

    $nameError ="";
    $emailError ="";
    $passError ="";
    $repassError ="";

    // basic name validation
    if (empty($name)) {  
         $error = true;
         $nameError = "Please enter your full name.";
    } else if (strlen($name) < 3) {
          $error = true;
          $nameError = "Name must have atleat 3 characters.";
    } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
         $error = true;
         $nameError = "Name must contain alphabets and space.";
    }

    //basic email validation
    if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        $stmt = $conn->prepare("SELECT userEmail FROM users WHERE userEmail=?");
        $stmt->bind_param("s", $email);
        if($stmt->execute()){
            /* bind result variables */
            $stmt->bind_result($result);
            
            /* fetch value */
            if($stmt->fetch() == true){
                $error = true;
                $emailError = "Provided Email is already in use.";
            }
        }else{
            $error = true;
            $emailError = "Ops, something went wrong.";
        }
        
        $stmt->close();
    }

    // password validation
    if (empty($pass)){
       $error = true;
       $passError = "Please enter password.";
    } else if(strlen($pass) < 6) {
       $error = true;
       $passError = "Password must have at least 6 characters.";
    }
    // compare password
    if(empty($repass)){
     $error = true;
     $repassError = "Please enter password to compare.";
    }else if(strcmp($pass,$repass) !== 0){
     $error = true;
     $repassError = "Passwords don't match.";
    }

    // password encrypt using SHA256();  // reference: http://php.net/manual/en/function.hash.php
    $password = hash('sha256', $pass);

    // if there's no error, continue to signup
    if( !$error ) {
        // prepare and bind
        if(($stmt2 = $conn->prepare("INSERT INTO users(userName,userEmail,userPass) VALUES (?, ?, ?)"))){
            $stmt2->bind_param("sss", $name, $email, $password);

            if($stmt2->execute()){
                $errTyp = "success";
                $errMSG = "Successfully registered, you may login now";
                $name ="";
                $email ="";
                $pass = "";
            }else{
                $errTyp = "danger";
                $errMSG = "Something went wrong, try again later 1 ...";            
            }
        }else{
                $errTyp = "danger";
                $errMSG = "Something went wrong, try again later 2 ...";            
        }
        
        $stmt2->close();
        $conn->close();
    }
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/registerLogin.css"/>   
</head>    

<body>
    <div id="registerBox" class="modal">        
        <script type="text/javascript">
            var bool = "<?php echo $error;?>";
                if(bool == "1"){
                    showTab();
                }else{
                    closeTab();
                }

        </script>
        
        
            <div id="containerId" class="container">
                <div id="tableDiv" class ="table-responsive">
                    <form method="post" id="regForm" class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                        <table class="table">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <h2 class="">Sign Up.</h2>
                                </div>

                                <div class="form-group">
                                    <hr />
                                </div>

                                <?php
                                      if ( isset($errMSG) ) { 

                                ?>
                                <script type="text/javascript">
                                    showTab();
                                </script>
                                <div class="form-group">
                                    <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                                         <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                                     </div>
                                    
                                </div>
                                
                                <?php
                                       }
                                ?>
                
                            <div class="form-group">
                                <span onclick="closeTab()" class="close">&times;</span>
                                 <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                    <input type="text" id ="nameText" name="name" class="form-control" placeholder="Enter Name" maxlength="50" required value="<?php echo $name ?>" />
                                 </div>
                                 <span class="text-danger"><?php echo $nameError; ?></span>
                            </div>

                            <div class="form-group">
                                 <div class="input-group">
                                     <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                     <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required maxlength="40" value="<?php echo $email ?>" />
                                </div>
                                <span class="text-danger"><?php echo $emailError; ?></span>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input type="password" name="pass" class="form-control" placeholder="Enter Password" required maxlength="15" />
                                </div>
                                <span class="text-danger"><?php echo $passError; ?></span>
                            </div>
                                
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                    <input type="password" name="repass" class="form-control" placeholder="Re-Enter Password" required maxlength="15" />
                                </div>
                                <span class="text-danger"><?php echo $repassError; ?></span>
                            </div>
                                
    
                            <div class="form-group">
                                <hr />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                            </div>

                            <div class="form-group">
                                 <hr />
                            </div>

                            <div class="form-group">
                                <h1 id="signInh1" class="btn btn-block btn-primary logregbuttons" onClick="callLoginTab()">Sign In</h1>
                            </div>

                        </div>
                    </table>
                </form>
                </div>
        </div>
        
    </div>
</body>
</html>