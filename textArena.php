<?php
session_start();
//error_reporting(0);
require("connectToDB.php");

$myEmail=$_SESSION['email'];

if(isset($_GET['withWho'])){
    $targetEmail=$_GET['withWho'];
    $_SESSION['targetEmail']=$targetEmail;
}


if(isset($_POST['text']) && !empty($_POST['text'])){
    $text=$_POST['text'];
    $time=time()+36000;

    $q="insert into `message` (`who`,`withWho`,`time`,`message`) values('$myEmail','$targetEmail','$time','$text')";
    $r=mysqli_query($conn,$q);

    header("Refresh:.1");
    
}

    $query="select * from `userInfo` where `email`='$targetEmail'";
    $result=mysqli_query($conn,$query);

    while($row=$result->fetch_assoc()){
        $senderName=$row['name'];
    }

    $query="select * from `friend` where `who`='$myEmail' and `withWho`='$targetEmail'";
    $result=mysqli_query($conn,$query);
    while($row=$result->fetch_assoc()){
        $addTime=$row['time'];
    }


    $query="select * from `message` where `who`='$myEmail' and `withwho`='$targetEmail'";
    $result=mysqli_query($conn,$query);
    $messageSent=$result->num_rows;

    $query="select * from `message` where `who`='$targetEmail' and `withwho`='$myEmail'";
    $result=mysqli_query($conn,$query);
    $messageReceived=$result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Text Arena</title>

    
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript"src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha314-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


    <script>
           $(document).ready(
            function() {
                setInterval(function() {
                    $('#text').load('reloadTextArena.php');
                }, 5000);
            });

    </script>



    <style>
        #text{
            height:75vh;
            width:80%;
        }

        #type{
            height:9vh;
            width:80%;
        }

        #textarea{
            width: 100%;
            height:10vh;
            padding: 12px 20px;
            box-sizing: border-box;
            border:2px solid black;
            background-color:mintcream;
            font-size: 16px;
            color:black;
            resize: none;
        }

        .container {
        border: 2px solid black;
        background-color:chartreuse;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        font-size:20px;
        text-align: left;
        }

        .darker {
        border-color: #ccc;
        background-color:floralwhite;
        border:2px solid black;
        font-size:20px;
        text-align: left;
        }

        .container::after {
        content: "";
        clear: both;
        display: table;
        }

        .container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
        }

        .container img.right {
        float: right;
        margin-left: 20px;
        margin-right:0;
        }

        .time-right {
        float: right;
        color: #aaa;
        font-size: 15px;
        color: black;
        }

        .time-left {
        float: left;
        color: #999;
        font-size: 15px;
        color: black;
        }
    </style>


</head>
<body>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-sm-3" style="background-color:burlywood;margin-bottom:5vh;">
                <center><a href="homepage.php"><i style="color:black;margin-top:5vh;" class='fa fa-home fa-5x' data-toggle='tooltip' title='Return home'></i></a><br>

                <button data-toggle="collapse" data-target="#details" class="btn btn-danger" style="margin-top:2vh;margin-bottom:2vh" >View details</button>

                    <section id="details" class="collapse">
                                        
                    <a style="font-size:20px">Name: <?php echo "" .$senderName; ?></a><br>
                    <a style="font-size:20px">Added on: <?php echo "" . date("M d h:i A", $addTime); ?></a><br>
                    <a style="font-size:20px">Text sent: <?php echo "" .$messageSent; ?></a><br>
                    <a style="font-size:20px">Text Received: <?php echo "" .$messageReceived; ?></a></center>
                    </section>
            </div>

            
            <div class="col-sm-6">

            <center><div id="type" style="margin-bottom:10vh;margin-top:5vh">
                        <form action="" method="post" id="form" name="form">
                            <textarea name="text" required autofocus id="textarea" placeholder="Type your message..."></textarea>
                            <button class="btn btn-success" style="float: right;margin-bottom:5%"  name="send">Send</button>
                        </form>

                    </div>



                <div id="text">
                    <?php

                        $query="select * from message where `who`='$targetEmail' and `withWho`='$myEmail'";
                        $result=$conn->query($query);
                        $count=$result->num_rows;
                        $_SESSION['count']=$count;


                        $query="select * from message where (`who`='$myEmail' and `withWho`='$targetEmail') or (`who`='$targetEmail' and `withWho`='$myEmail') order by `time` desc";
                        $result=$conn->query($query);

                        if($result->num_rows>0){
                            while($row=$result->fetch_assoc()){
                                $who=$row['who'];
                                $withWho=$row['withWho'];
                                $time=$row['time'];
                                $msg=$row['message'];

                                if($who==$myEmail){ ?>
                                     <div class="container darker">
                                        <?php echo "<b><a style='text-align:left;font-size:20px;color:darkorange'>"."You"."</a></b>"; ?><br>
                                        <?php echo "<a style='text-align:left;'>".$msg."</a>"; ?>
                                        <span class="time-right"><?php echo "" . date("M d h:i A", $time); ?></span>
                                    </div>
                               
                            <?php }
                                else{ ?>
                                   <div class="container">
                                        <?php echo "<b><a style='text-align:left;font-size:20px;color:Black'>".$senderName."</a></b>"; ?><br>
                                        <?php echo "<a style='text-align:left;'>".$msg."</a>"; ?>
                                        <span class="time-right"><?php echo "" . date("M d h:i A", $time); ?> </span>
                                    </div>

                                
                                <?php }
                            }
                        }

                    ?>

                </div>

            </center>

            </div>


            <div class="col-sm-3" style="background-color:burlywood"></div>

        </div>
    </div>


    <script>
                    
                    $(document).ready(function() {
        $('#textarea').keydown(function() {
            var message = $("textarea").val();
            if (event.keyCode == 13) {
            if (message == "") {
                alert("Enter Some Message First.");
            } else {
                $('#form').submit();
            }
        $("textarea").val('');
        return false;
        }
        });
        });


</script>
    
</body>
</html>