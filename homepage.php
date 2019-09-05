<?php
session_start();
require("connectToDB.php");

//$myEmail = 'mainulislam588@gmail.com';

$myEmail = $_SESSION['email'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!------ Include the above in your HEAD tag ---------->

<style>
    .form-control-borderless {
        border: none;
    }

    .form-control-borderless:hover,
    .form-control-borderless:active,
    .form-control-borderless:focus {
        border: none;
        outline: none;
        box-shadow: none;
    }
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha314-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">


</head>


<body style="margin-top:5%">


<div class="container-fluid">

<div class="row">

    <div class="col-sm-5" style="padding-top:1%">
    <center><h3>Friends</h3></center>

                        <?php

                            $emailsearch = "SELECT * FROM `friend` WHERE `who`='$myEmail'";
                            $searchresult = mysqli_query($conn, $emailsearch);
                            $matchemail  = mysqli_num_rows($searchresult);

                            if($matchemail>0){
                                ?>

                                
    <center>
                <table class="table table-striped table-dark" style="width:85%;margin-top:3%">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Text</th>
                        </tr>
                    </thead>

                    <tbody>

<?php
                                while($row=$searchresult->fetch_assoc()){
                                    $email=$row['withWho'];

                                    $search="SELECT * FROM `userInfo` WHERE `email`='$email'";
                                    $result=mysqli_query($conn, $search);
                                    $match  = mysqli_num_rows($result);


                                    while($row1=$result->fetch_assoc()){
                                        $name=$row1['name'];
                                    }

                                    echo "<tr>
                                            <td>".$name."</td>
                                            <td>".$email."</td>
                                            <td>". "<a href='textArena.php?withWho=$email' style='font-size=30px'><i class='fa fa-envelope fa-2x' data-toggle='tooltip' title='Text friend'></i></a>" ."</td>
                                            </tr>";

                                }

                            }
                            else{
                                echo "<h2 align='center'>You don't have any friend yet.<h2>";
                            }




                        ?>

                    </tbody>
                </table>
            </center>

    </div>


<div class="col-sm-7" style="padding-top:1%">
<center><h3>Search friend</h3></center>

<?php

if (isset($_GET['who'])) {

    if ($_GET['task'] == 1) {
        $who = $_GET['who'];
        $withWho = $_GET['withWho'];
        $time = time();

        $query = "INSERT INTO `friend` (`who`,`withWho`,`time`) VALUES('$who','$withWho',$time)";
        $result = mysqli_query($conn, $query);

        if($result){?>
        <center>
            <div class="alert alert-success" style="width:65%;">
                <strong>Friend added. Wait for response.</strong>
            </div>
        </center>
    <?php
    header( "refresh:3; url=homepage.php" ); 
        }
        else{
            echo"".mysqli_error($conn);
        }

    } else {
        $who = $_GET['who'];
        $withWho = $_GET['withWho'];

        $query = "delete from `friend` where who='$who' and withWho='$withWho'";
        $result = mysqli_query($conn, $query);

        $query = "delete from `friend` where who='$withWho' and withWho='$who'";
        $result = mysqli_query($conn, $query);

        if ($result) { ?>
            <center>
                <div class="alert alert-danger" style="width:65%;">
                    <strong>Friend removed.</strong>
                </div>
            </center>
        <?php
        header( "refresh:3; url=homepage.php" ); 
        }
    }
}


if (isset($_POST['submit'])) {
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        $emailsearch = "SELECT * FROM `userInfo` WHERE `email`='$email'";
        $searchresult = mysqli_query($conn, $emailsearch);
        $matchemail  = mysqli_num_rows($searchresult);

        if ($email == $myEmail) { ?>
            <center>
                <div class="alert alert-warning" style="width:65%;">
                    <strong>Why are you searching yourself? LOL!</strong>
                </div>
            </center>
        <?php

        } else if ($matchemail > 0) { ?>
            <center>
                <div class="alert alert-success" style="width:65%;">
                    <strong>Match found.</strong>
                </div>
            </center>
            <?php

            while ($row = $searchresult->fetch_assoc()) {
                $name = $row['name'];
            } ?>

            <center>
                <table class="table table-striped table-dark" style="width:65%">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $email; ?></td>

                            <?php
                            $emailsearch = "SELECT * FROM `friend` WHERE `who`='$myEmail' and `withWho`='$email'";
                            $searchresult = mysqli_query($conn, $emailsearch);
                            $matchemail  = mysqli_num_rows($searchresult);

                            if ($matchemail > 0) {
                                $task = 0;
                                echo "<td>" . "<a href='homepage.php?who=$myEmail&withWho=$email&task=$task' style='font-size=20px'><i class='fas fa-user-friends' data-toggle='tooltip' title='You guys are already friend'></i></a>" . "</td>";
                            } else {
                                $task = 1;
                                echo "<td>" . "<a href='homepage.php?who=$myEmail&withWho=$email&task=$task' style='font-size=20px'><i class='fas fa-user-plus' data-toggle='tooltip' title='Add friend'></i></a>" . "</td>";
                            }

                            ?>

                        </tr>
                    </tbody>
                </table>
            </center>


        <?php
        } else { ?>
            <center>
                <div class="alert alert-danger" style="width:65%;">
                    <strong>Email not found in the database.</strong>
                </div>
            </center>

        <?php
        }
    } else { ?>
        <center>
            <div class="alert alert-danger" style="width:65%;">
                <strong> Please enter an email to search.</strong>
            </div>
        </center>

    <?php
    }
}


?>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <form class="card card-sm" style="border:2px solid black;" method="post" action="homepage.php">
                <div class="card-body row no-gutters align-items-center">
                    <div class="col-auto">
                        <i class="fas fa-search h4 text-body"></i>
                    </div>
                    <!--end of col-->
                    <div class="col">
                        <input class="form-control form-control-lg form-control-borderless" type="text" name="email" placeholder="Enter email to search">
                    </div>
                    <!--end of col-->
                    <div class="col-auto">
                        <button class="btn btn-lg btn-success" type="submit" name="submit">Search</button>
                    </div>
                    <!--end of col-->
                </div>
            </form>

        </div>
        <!--end of col-->
    </div>
</div>

</div>


  </div>
</div>

</body>
</html>
