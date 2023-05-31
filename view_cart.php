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

$page_title='view your shopping cart';

// check if the form has been submitted
if($_SERVER['REQUEST_METHOD']=='POST')
{
    // change any qunatity
    foreach ($_POST['qty'] as $k=>$v)
    {
        // Must be integers
        $pid=(int)$k;
        $qty=(int)$v;
        if($qty==0)
        {
            //delete
            unset($_SESSION['cart'][$pid]);
            
        }
        else if ($qty>0)
        {
            $_SESSION['cart'][$pid]['quantity']=$qty;
        }
        
    }
}
// Display the cart if it is not empty
if(!(empty($_SESSION['cart'])))
{
    // Retrieve all of the information  for the products  in the cart
    require 'mysqli_connect.php';
    $q="select pid,cname,
        product_name,quantity from browser_products where 
        pid in(";
         foreach($_SESSION['cart'] as $pid => $value)
         {
             $q.=$pid.',';
            // echo $q;
         }
         $q=  substr($q,0,-1) . ')';
         $r=  mysqli_query($dbc, $q)or die(mysqli_error($dbc));
         
         //Create a form and a table
        echo '<form action="view_cart.php" method="post">
        <table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
        <tr>
        <td align="left" width="30%"><b>Category</b></td>
        <td align="left" width="30%"><b>Product Name</b></td>
        <td align="left" width="30%"><b>Price</b></td>
        <td align="left" width="30%"><b>Qty</b></td>
        <td align="left" width="30%"><b>Total Price</b></td>
        </tr>
           ';
        //print each item
        $total=0; //total cost of the order
        while($row= mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            // calculate the total and sub total
            if($row['quantity']<$_SESSION['cart'][$row['pid']]['quantity'])
            {
                echo "<tr><td style='color:red'>only ".$row['quantity']." are available in stock" ;
              $_SESSION['cart'][$row['pid']]['quantity']=  $row['quantity'];
            }
            $subtotal=$_SESSION['cart'][$row['pid']]['quantity'] *
             $_SESSION['cart'][$row['pid']]['price'];
            $total+=$subtotal;
            //print the row
            echo "\t<tr>
            <td align=\"left\">{$row['cname']}</td>
            <td align=\"left\">{$row['product_name']}</td>
            <td align=\"left\">\${$_SESSION['cart'][$row['pid']]['price']}</td>
            <td align=\"center\"><input type=\"text\" size=\"3\" name=\"qty[{$row['pid']}]\"
                value=\"{$_SESSION['cart'][$row['pid']]['quantity']}\"</td>
            <td align=\"right\">$".number_format($subtotal,2)."</td>
            <tr>\n";
        }// end of while loop
        mysqli_close($dbc);// close the  connection
        // print the total , close the table  and form
        echo '<tr>
          <td colspan="4" align="right" >
          <b>Tax:</b> 
          </td>
          <td align="right">$', ($total*8)/100 .'</td>
           <tr>
          <td colspan="4" align="right" >
          <b>Total:</b> 
          </td>
          <td align="right">$',  number_format($total+($total*8)/100,2).'</td>   
          </tr></table>
          <div align="center"><input type="submit" name="submit" value=
          "update my cart" /></div>
          </form><p align="center">Enter an quantity of 0 to remove an item
          <br><br><a href="checkout.php">CheckOut</a></p>';
        $total=$total+($total*8)/100;
        $_SESSION['total']=$total;
}
else
{
 echo '<p>Your cart is Currently empty.</p>';    
}


?>


</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    