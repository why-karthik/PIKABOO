<?php
include 'Header.php';
$error="";
if(isset($_POST['register']))
    {
       $fname = $_POST['fn'];
       $email = $_POST['u1'];
       $password = $_POST['p1'];
       $rpassword = $_POST['p2'];
       $phone = $_POST['ph'];
       $address = $_POST['ad'];
       if($password==$rpassword)
       {
           // Check the email is existing or not 
           include 'mysqli_connect.php';
           $q="select * from customers where email='".$email."'";
           //echo "The query is ".$q;
           $stmt= mysqli_query($dbc, $q);
           if(mysqli_affected_rows($dbc)>0)
           {
               $error="Email Id is already registered";
           }
           else
           {
             $q="insert into customers(fname,email,pass,phone,address) values('$fname','$email','$password','$phone','$address')";
                //$stmt= mysqli_prepare($dbc,$q);
           //  mysqli_stmt_bind_param($stmt,"sss",$email,$password);
            // mysqli_stmt_execute($stmt);
            $r=  mysqli_query($dbc, $q) or die(mysqli_error($dbc));
             //check the result
            // echo mysqli_affected_rows($dbc); 
            if(mysqli_affected_rows($dbc)>0)
             {
                // echo "<p style='color:green'> The User has been added successfully ";
                $error="<p style='color:green'> The User has been Registered successfully ";
                 
             }
             else
                 $error='The new User could not be added to the database';
                
            
          }
            
             mysqli_close($dbc);
            // Register a user
       }
       else
       {
         $error="Passwords does not match";  
       }
   
}
?>
<div align="center">
   
    
    <table width="250px">
        <caption style="font-size:25px">Register User</caption>
      <form action="" method="post" >
          <tr>
      <td colspan="2" style="color:red"><?php echo $error; ?></td>
          </tr>
          <tr>
            <td>
                Full Name:
            </td>
            <td>
                <input type="text" name="fn" size="15" required>
            </td>
          </tr>
          <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr> 
        <tr>
            
             <td>
                Email:
            </td>
            <td>
                <input type="email"  name="u1" size="15" required="required" />
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
            <td>
               Re-PASSWORD:
            </td>
            <td>
                <input type="password" name="p2" size="15" required="required" minlength="5" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                Phone:
            </td>
            <td>
                <input type="text" name="ph" size="15" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td>
                Address:
            </td>
            <td>
            <input type="text" name="ad" size="15" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>


        <tr>
            <td colspan="2" align="center">
                <input type="submit" name="register" value="Register" />
            </td>
        </tr>
        <tr>
            <td colspan="2">
                 &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <a href="login.php">For login Click Here</a>                
            </td>
        </tr>
    </form>
    </table>    
    <br>
    <br>
    <br>
    <br><br>
    <br>
</div>
     
<?php
include 'footer.php';
?>
