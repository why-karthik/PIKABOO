<?php
include 'Header2.php';
if(!isset($_SESSION['user']))
{
    header('Location:Welcome_user.php');
}
$email=$_SESSION['user'];
?>
<div style="text-align:center">
    
<?php

$page_title="Browse The Products";
require 'mysqli_connect.php';

// default query  for this page
$q="select * from browser_products";
  
  if(isset($_GET['aid']) && filter_var($_GET['aid'],FILTER_VALIDATE_INT,array('min_range'=>1)))
  {
    $q = "select * from browser_products where id ={$_GET['aid']}";
  }
  // create the table head
  echo '<div align=center><table border="0" width="90%" cellspacing="3" cellpadding="3" 
       align="center">
   <tr>
   <td align="left" width="20%"><b>category</b></td>
   <td align="left" width="20%"><b>Product Name</b></td>
   <td align="left" width="20%"><b>Description</b></td>
   <td align="left" width="20%"><b>Price</b></td>
   <td align="left" width="20%"><b>Quantity</b></td>
';
  // display all the productss, linked to URLs
  
  $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
  while($row= mysqli_fetch_array($r,MYSQLI_ASSOC))
  {
      // display each record
      
      echo "\t<tr>
        <td align=\"left\"><a href=\"browse_products.php?aid={$row['id']}\"> 
            {$row['cname']}</a></td>
        <td align=\"left\"><a href=\"view_product.php?pid={$row['pid']}\"> 
            {$row['product_name']}</a></td>
        <td align=\"left\"> 
            {$row['description']}</td>
               <td align=\"left\"> 
            {$row['price']}</td>
              <td align=\"left\"> 
            {$row['quantity']}</td>
                
       </tr>\n ";
  } // end of while loop
  echo "</table></div>";
  mysqli_close($dbc);
  ?>

</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    