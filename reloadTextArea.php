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


    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $who=$row['who'];
            $withWho=$row['withWho'];
            $time=$row['time'];
            $msg=$row['message'];

            if($who==$myEmail){ ?>
                <div class="container darker">
                    <img src="female.jpg" alt="Avatar" class="right" style="width:100%;">
                    <?php echo "".$msg; ?>
                    <span class="time-left"><?php echo "" . date("M d h:i A", $time); ?></span>
                </div>
                               
                <?php }
                    else{ ?>
                        <div class="container">
                            <img src="male.png" alt="Avatar" style="width:100%;">
                            <?php echo "".$msg; ?>
                            <span class="time-right"><?php echo "" . date("M d h:i A", $time); ?> </span>
                        </div>

                    <?php }
                }
            }

?>