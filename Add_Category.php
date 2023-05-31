<?php

include 'Header1.php';
?>
<div style="text-align:center">
   
     <?php
         if($_SERVER['REQUEST_METHOD']=='POST')
         {
             $pn=(!empty($_POST['product_name']))
             ? trim($_POST['product_name']):NULL;
             $des=(!empty($_POST['description']))
             ? trim($_POST['description']):NULL;
             
             // add an category to the database
             require ('mysqli_connect.php');
             $q='insert into Categories(product_name,description)
                 values(?,?)';
             $stmt=  mysqli_prepare($dbc, $q);
             mysqli_stmt_bind_param($stmt, 'ss',$pn,$des);
             mysqli_stmt_execute($stmt);
             
             //check the result
             if(mysqli_stmt_affected_rows($stmt)==1)
             {
                 echo "<p style='color:green'> The Category has been added successfully ";
                 $post=array(); 
                 
             }
             else
                 $error='The new Category could not be added to the database';
             
             mysqli_stmt_close($stmt);
             mysqli_close($dbc);
             
             
         
         }
         
     
     // check for an error and print it
      if(isset($error))
      {
          echo "<h1>ERROR</h1>
          <p style='font-weight:bold;color:#C00'>".$error.'.</p>';
      }
        ?>
        <h1>Add Categoreis</h1>
        <form action='Add_Category.php' method="post">
            <fieldset>
                <legend>
                    Fill out the Form to add an Category
                </legend>
               <p><b>Product Name:</b>
         <input type="text" name="product_name" size="10" maxlength="20"
        value="<?php if(isset($_POST['product_name'])) echo $_POST['product_name'] ?>" />
         
         
               </p>
               <p><b>Description:</b>
         <input type="text" name="description" size="10" maxlength="300"
        value="<?php if(isset($_POST['description'])) echo $_POST['description'] ?>" />
               </p>
               
               
            </fieldset>
           <div align="center">
                   
                   <input type="submit" name="submit" value="submit" />
                    
           </div>
           <br>    
        </form>
</div>
    <?php
include 'footer.php';
?>
