<!DOCTYPE html>
<html>
<head>
<title>Submit Data On Enter Key - Demo Preview</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css">
<script src="script.js"></script>
<style>
  @import "http://fonts.googleapis.com/css?family=Droid+Serif";
/* Above line is to import Google Font Style */
div#maindiv{
margin:30px auto;
width:980px;
height:500px;
background:#Fff;
padding-top:20px;
font-family:'Droid Serif',serif;
font-size:14px
}
#text{
width:420px;
height:60px;
border-radius:4px;
box-shadow:0 0 2px 2px #123456;
margin-top:10px;
clear:both
}
#first{
width:65%;
float:left
}
#title{
width:500px;
height:70px;
text-shadow:2px 2px 2px #cfcfcf;
margin-top:40px;
font-size:16px
}
.notification{
color:#777
}

</style>

</head>
<body>


  <div id="maindiv">
    <div id="first">  

      <form action="#" id="my_form" method="post" name="my_form">
        <label>Type Message:</label><br>
        <textarea id="text" placeholder="Your Message..."></textarea>
      </form>
    </div>
  </div>



<script>


$(document).ready(function() {
  $('#text').keydown(function() {
    var message = $("textarea").val();
    if (event.keyCode == 13) {
      if (message == "") {
        alert("Enter Some Text In Textarea");
      } else {
        $('#my_form').submit();
        alert("Succesfully submitted:- " + message);
    }
  $("textarea").val('');
  return false;
}
});
});


  </script>

</body>
</html>