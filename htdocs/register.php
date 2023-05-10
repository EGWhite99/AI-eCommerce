<?php include('header.php'); ?>


<?php


include('connection.php');



//if user has already registered, then take user to account page            
if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}



if(isset($_POST['register'])){

  $Fname = $_POST['First'];
  $Lname = $_POST['Last'];
  $Phone_Num = $_POST['Phone_Num'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  //if passwords dont match
  if($password !== $confirmPassword){
    header('location: register.php?error=passwords don\'t match');
  

  //if passwod is less than 6 char
  }else if(strlen($password) < 6){
    header('location: register.php?error=password must be at least 6 characters');
  

  //if there is no error
  }else{
                //check whether there is a user with this email or not
                $stmt1= $db->prepare("SELECT count(*) FROM users where email=?");
                $stmt1->bind_param('s',$email);
                $stmt1->execute();
                $stmt1->bind_result($num_rows);
                $stmt1->store_result();
                $stmt1->fetch();

                //if there is a user already registered with this email
                if($num_rows != 0){
                  header('location: register.php?error=user with this eamil already exists');
                  

                  //if no user registed with this email before
                }else{
                        //create a new user
                        $stmt = $db->prepare("INSERT INTO users (Fname, Lname, email, pass, phoneNum) 
                        VALUES (?,?,?,?,?)");

                        $stmt->bind_param('sssss',$Fname,$Lname, $email, $password, $Phone_Num);

                  

                        //if account was created successfully
                        if($stmt->execute()){
                              $user_id = $stmt->insert_id;
                              $_SESSION['user_id'] = $user_id;
                              $_SESSION['user_email'] = $email;
                              $_SESSION['user_name'] = $name;
                              $_SESSION['logged_in'] = true;
                              header('location: account.php?register_success=You registered successfully');

                          //account could not be created
                        }else{

                             header('location: register.php?error=could not create an account at the moment');

                        }



                }

              }







}





?>





      <!--Resgister-->
      <section class="my-5 py-5">
          <div class="container text-center mt-3 pt-5">
              <h2 class="form-weight-bold">Register</h2>
              <hr class="mx-auto">
          </div>
          <div class="mx-auto container">
              <form id="register-form" method="POST"  action="register.php">
                <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error']; }?></p>
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" id="register-Fname" name="First" placeholder="First Name" required/>
                </div>
				<div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" id="register-Lname" name="Last" placeholder="Last Name" required/>
                </div>
				<div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" id="register-Phone" name="Phone_Num" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="XXXXXXXXXX" required/>
                </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required/>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                </div>
                <div class="form-group">
                    <a id="login-url" href="login.php" class="btn">Do you have an account? Login</a>
                </div>
              </form>
          </div>
      </section>






      <?php include('layouts/footer.php'); ?>