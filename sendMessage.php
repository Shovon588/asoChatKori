<?php
session_start();
require("connectToDB.php");

$myEmail=$_SESSION['email'];
$targetEmail=$_SESSION['targetEmail'];

if(isset($_POST['send'])){
    if(isset($_POST['text']) && !empty($_POST['text'])){

        $text=$_POST['text'];
        $time=time()+21600;

        $q="insert into `message` (`who`,`withWho`,`time`,`message`) values('$myEmail','$targetEmail','$time','$text')";
        $r=mysqli_query($conn,$q);
        header("Location: textArena.php");
    }
}


?>