<?php

include "connectToDB.php";

if(isset($_POST['email']) && isset($_POST['password'])){

  $email=$_POST['email'];
  $password=$_POST['password'];
  
  
  $emailsearch = "SELECT * FROM `userInfo` WHERE `email`='$email' and `password`='$password'";
  
  $searchresult = mysqli_query($conn, $emailsearch);
  $matchemail  = mysqli_num_rows($searchresult);
  
  if ($matchemail > 0) {
      session_start();
      $search = "SELECT `id` FROM `userInfo` WHERE `email`='$email' ";
      $result = mysqli_query($conn,$search);
  
      while ($row = $result->fetch_assoc()) {
          $id = $row['id'];
      }
      $_SESSION['id']=$id;
      $_SESSION['email']=$email;
  
  
      header("Location: homepage.php");
  }
      else{
          $message = "Incorrect email or password!!";
  
          echo "<script type='text/javascript'>alert('$message');
      window.location.href='logIn.php';
      
      </script>";
      }

}



?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Login</title>
</head>


<body>
    <div class="row" style="margin-top:15%">
        <div class="col-md-6 offset-md-3">
            <span class="anchor" id="formLogin"></span>

            <div class="card card-outline-secondary">
                <div class="card-header">
                    <h3 class="mb-0">Login credentials</h3>
                </div>
                <div class="card-body">

                    <form action="" method="post">
                        <div class="form-group">
                            <label for="npass">Email</label>
                            <input type="text" id="email" class="form-control" name="email" placeholder="Enter your email" value="">
                        </div>
                        <div class="form-group">
                            <label for="cpass">Password:</label>
                            <input type="password" id="password" class="form-control" name="password" placeholder="Type in your password">
                        </div>
                        <button type="submit" class="btn btn-default" style="margin:auto;display:block;color:black;border:1px solid black">Login</button>
                    </form>


                </div>
                <!--/card-body-->
            </div>
            <!-- /form card login -->

        </div>
    </div>
</body>

</html>