<?php

include 'Header1.php';
?>
<div style="text-align:center">
    <?php

$page_title="User List";
require 'mysqli_connect.php';

// default query  for this page
$q="select customer_id,fname,email,phone,address from customers order by customer_id";
  
  
  // create the table head
  echo '<div align=center><table border="1" cellspacing="3" cellpadding="3" 
       align="center">
   <tr>
   <td ><b>Customer ID</b></td>
   <td ><b>full name</b></td>
   <td ><b>Email</b></td>
   <td ><b>Phone</b></td>
   <td ><b>Address</b></td>
   ';
  // display all the products, linked to URLs
  
  $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
  while($row= mysqli_fetch_array($r,MYSQLI_ASSOC))
  {
      // display each record
      
      echo "\t<tr>
        
        <td align=\"left\"> 
            {$row['customer_id']}</td>
            <td align=\"left\"> 
            {$row['fname']}</td>
               <td align=\"left\"> 
            {$row['email']}</td>
            <td align=\"left\"> 
            {$row['phone']}</td>
            <td align=\"left\"> 
            {$row['address']}</td>
                
       </tr>\n ";
  } // end of while loop
  echo "</table></div>";
  mysqli_close($dbc);
  ?>

</div>
    <?php
include 'footer.php';
?>
