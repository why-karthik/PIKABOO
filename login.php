<?php

include 'Header.php';
$error="";
if(isset($_SESSION['admin']))
{
    header('Location:Welcome_admin.php');
}

if(isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
 else 
{
    if(isset($_POST['login']))
    {
       $email=$_POST['u1'];
       $password=$_POST['p1'];
       if($email=='admin' && $password=='admin')
       {
               $_SESSION['admin']=$email;
               header('Location:Welcome_admin.php');
       }
       require 'mysqli_connect.php';
       
       $q="select * from customers where email='".$email."' and pass='".$password."'";
           //echo "The query is ".$q;
           $stmt= mysqli_query($dbc, $q);
           if(mysqli_affected_rows($dbc)>0)
           {
               $_SESSION['user']=$email;
               header('Location:Welcome_user.php');
           }
           else
           {
                $error="User Id and password is wrong";  
           }
    }
}
?>
<div align="center">
    
    <br>
    <table width="250px">
        <caption style="font-size:25px;text-align: center">Login</caption>
      <form action="" method="post" >
          <tr>
      <td colspan="2" style="color:red"><?php echo $error; ?></td>
          </tr> 
        <tr>
            
             <td>
                USER NAME:
            </td>
            <td>
                <input type="text" name="u1" size="15" required="required" minlength="5" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                PASSWORD:
            </td>
            <td>
                <input type="password" name="p1" size="15" required="required" minlength="5" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="login" value="LOGIN" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <a href="Register.php">New Users Can Register Here</a>                
            </td>
        </tr>
    </form>
    </table>    
    
</div>
     
<?php
include 'footer.php';
?>
