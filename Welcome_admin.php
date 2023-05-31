<?php
include 'Header1.php';
if(!isset($_SESSION['admin']))
{
    header('Location:login.php');
}

?>
<div style="text-align:center">
    
    <h2 style="text-align: center">Welcome To Admin</h2>
    <p style="text-align:justify;line-height:20px;padding:10px">
	<h1 style="color:red;"> You are now logged in.</h1>
   
</div>
    <?php
include 'footer.php';
?>
