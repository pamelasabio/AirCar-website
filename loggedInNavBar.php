<?php
require_once 'dbconnect.php';
include "userQuery.php";

if(isset($_SESSION['user']) != ""){ ?>
<nav id="headerNav" class="navbar navbar-default navbar-fixed-top">
    <div class="nav navbar-right" id="mainrightNav">
        <div class="dropdown">
            <span class="dropdown-toggle" role="button" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $user ?><span class="caret"></span></span>
            <ul class="dropdown-menu">
                <li><a id="editPassButton" onclick="document.getElementById('profileBox').style.display='block'"><span class="glyphicon glyphicon-user"></span>&nbsp;Settings</a></li>
                <li><a href="profile.php"><span class="glyphicon glyphicon-save-file"></span>&nbsp;Upload Picture</a></li>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php }else{ include 'notLoggedInNavVarMain.php';} ?>

<div id="profileBox" class="modal">
    <div id="containerId" class="container">
        <form id="updateForm" class="modal-content animate" method="post" action="<?php echo htmlspecialchars("updatePassword.php"); ?>" autocomplete="off">
            <span onclick="closeTheTab('profileBox')" class="close">&times;</span>            
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
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" name="oldPass" class="form-control" placeholder="Old Password" required/>
                </div>
                <span class="text-danger"><?php if(isset($oldError)){echo $oldError;} ?></span>
            </div>
            <div class="form-group">
                <div class="input-group" id="password">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input type="password" name="newPass" class="form-control" placeholder="New Password" required/>
                </div>
                <span class="text-danger"><?php if(isset($newError)){echo $newError;} ?></span>
            </div>
            
            <div class="form-group">
                <button id="login" type="submit" class="btn btn-block btn-primary" name="btn-change">Change</button>
                <hr/>
            </div>
            
            <div class="form-group">
                <span id="noaccount">Don't like us anymore?</span>
                <button id="deletebtn" type="submit" form="deleteForm" name="btn-delete" class="btn btn-danger">Delete</button>
            </div>
        </form>
        
        <form id="deleteForm"  name="deleteForm" method="post" action="<?php echo htmlspecialchars("updatePassword.php"); ?>" autocomplete="off">
        </form>
    </div>
</div>