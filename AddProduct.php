<?php

include 'Header1.php';
?>

   
<div style="text-align:center">
      
 <?php
require 'mysqli_connect.php';

  if($_SERVER['REQUEST_METHOD']=='POST')
  {
      //validate the incoming data
      $errors=array();
      // check for the product name
      if(!empty($_POST['product_name']))
      {
          $pn=trim($_POST['product_name']);
      }
      else
      {
          $errors[]="please enter the products name";
      }
      // chec for an image
      if(is_uploaded_file($_FILES['image']['tmp_name']))
     {
          // create a temporary file name
        $temp='./uploads/'.md5($_FILES['image']['name']);
        
        // move the file over
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $temp))
        {
            echo '<p style="font-weight:bold;color:green">File has been uploaded</p>';
            // set the $i var name to the images name
            $i=$_FILES['image']['name'];
        }
        else
        {
            $errors[]="The file could not be moved";
            $temp=$_FILES['image']['tmp_name'];
        }
      }
       else
       {
           $errors[]='no file was uploaded';
           $temp=NULL;
       }
       // check for a size (not required)
       // check for price
       if(is_numeric($_POST['price']) && ($_POST['price']>0))
       {
           $p=(float)$_POST['price'];
       }
       else
       {
           $errors[]='please enter the products price!';
       }
   // check for description or not
       $d=(!empty($_POST['description']))?trim($_POST['description']):NULL;
        // Validate the category
 if(isset($_POST['category']) && filter_var($_POST['category'],FILTER_VALIDATE_INT,array('min_range'=>1)))
       {
           $a=$_POST['category'];
       }
      else
      {
          $errors[]='plese select the category!';
      }
      if(isset($_POST['qty']) && filter_var($_POST['qty'],FILTER_VALIDATE_INT,array('min_range'=>1)))
       {
           $qty=$_POST['qty'];
       }
      else
      {
          $errors[]='plese Enter the quantity';
      }
      
        if(empty($errors)){
            // every thing is ok.
            $q='Insert into products(cid,product_name,price,description,quantity,image_name)
                 values(?,?,?,?,?,?)';
            $stmt=  mysqli_prepare($dbc, $q);
            mysqli_stmt_bind_param($stmt, 'isdsis',$a,$pn,$p,$d,$qty,$i);
            mysqli_stmt_execute($stmt) or die(mysqli_errno($dbc));
            if(mysqli_stmt_affected_rows($stmt)==1)
            {
                echo '<p style="font-weight:bold;color:green"> The Product has been added.</p>';
                // Rename the image
                $id=  mysqli_stmt_insert_id($stmt);
                rename($temp,"./uploads/$id");
                //clear $_POST
                $_POST=array();
            }
            else
            {
                echo '<p Style="font-weight:bold;color:c00">your submission
                    cannot be processed due to system error.</p>';
                
            }
            mysqli_stmt_close($stmt);
        }
        // delete upload files if still exists
        if(isset($temp) && file_exists($temp) && is_file($temp))
        {
            unlink($temp);
        }
  }
  //check for any errors and print them
  
  if(!empty($errors) && is_array($errors))
  {
       echo '<h1>Error!</h1>
       <p style="font-weight:bold;color:#c00">The following error occured:
       <br>';
       foreach($errors as $msg)
       {
         echo "-$msg<br/>\n";
       }
      echo 'please reselect the product image and try again </p>';
    }
 //  Displaying the form  
?>
        <h1> Add A product</h1>
        <form enctype="multipart/form-data" action="AddProduct.php"  method="post">
          <input type="hidden" name="max-file-size" value="524288" />
          
          <fieldset>
              <legend>
                  Fill out the form to add a product to catalog:
              </legend>
          <table align="center">
         
        <tr><td>  <p>
              <b>Product Name: </b>
           <td>   <input type="text" name="product_name" size="30" maxlength="60"
                     value="<?php if(isset($_POST['product_name'])) 
                         echo htmlspecialchars($_POST['product_name']);?>" />
          </p>
      <tr><td><p>
              <b>Image: </b>
            <td>  <input type="file" name="image"  />
          </p>
         <tr><td>
              <b>Category: </b>
            <td>  <select name="category">
                  <option>Select One</option>
                <?php
                // Retrive all products and add to pull down menu.
                $q="select id, product_name from categories order by product_name asc";
                $r=  mysqli_query($dbc, $q) or die(mysql_error());
                if(mysqli_num_rows($r)>0)
                {
                    while ($row=  mysqli_fetch_array($r, MYSQLI_NUM))
                            
                    {
                        echo "<option value=\"$row[0]\"";
                        // check for stickyness
                        if(isset($_POST['existing']) &&($_POST['existing']==$row[0]))
                        
                        echo 'selected="selected"';
                        echo ">$row[1]</option>\n";
                        
                    }
                }
                        else
                        {
                            echo '<option> please add a new category first</option';
                        }
                        
                        mysqli_close($dbc);
                    
                     
                    
                   
                ?>
              </select>
                  
       <tr> <td>  
              <b>price: </b>
             <td> <input type="text" name="price" size="10" maxlength="10"
                     value="<?php if(isset($_POST['price'])) 
                         echo ($_POST['price']);?>" />
              <small>Do not include the dollar sign  or comma.</small>
          </p>
        <tr><td>  <p>
              <b>Description : </b>
         <td>     <textarea name="description" cols="40" rows="5" >
                    <?php if(isset($_POST['Description'])) 
                         echo htmlspecialchars($_POST['Description']);?>
              </textarea>(optional)
          </p>
          <tr><td>   <p>
              <b>Quantity: </b>
            <td> <input type="text" name="qty" size="15" maxlength="10"
                     value="<?php if(isset($_POST['qty'])) 
                         echo htmlspecialchars($_POST['qty']);?>" />
          </p>
          </table>
          </fieldset>
          <div align="center">
              <input type="submit" name="submit" value="submit" />
              
          </div>
        </form> 
   
</div>
    <?php
include 'footer.php';
?>
