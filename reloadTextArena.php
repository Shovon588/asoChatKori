<?php
    session_start();
    require("connectToDB.php");

    $myEmail=$_SESSION['email'];
    $targetEmail=$_SESSION['targetEmail'];
    $previous=$_SESSION['count'];

    $query="select * from message where `who`='$targetEmail' and `withWho`='$myEmail'";
    $result=$conn->query($query);
    $current=$result->num_rows;

    if($current>$previous){
        $_SESSION['count']=$current; ?>
        <audio autoplay>
  <source src="notification.mp3" type="audio/mpeg">
</audio>

    <?php }

    $query="select * from message where (`who`='$myEmail' and `withWho`='$targetEmail') or (`who`='$targetEmail' and `withWho`='$myEmail') order by `time` desc";
    $result=$conn->query($query);


    $q="select * from userInfo where `email`='$targetEmail'";
    $r=$conn->query($q);

    while($row=$r->fetch_assoc()){
        $senderName=$row['name'];
    }


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