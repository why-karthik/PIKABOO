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
// This page adds products to the shopping cart
// set the page title and include the html header
$page_title='Add to cart';

if(isset($_GET['pid']) && filter_var($_GET['pid'],FILTER_VALIDATE_INT,  array('min_range'=>1)))
{
 // check for a product id.
    $pid=$_GET['pid'];
    // check if the cart already contains one of these products
    // if so increment the qunatity.
    if(isset($_SESSION['cart'][$pid]))
    {
        $_SESSION['cart'][$pid]['quantity']++; // Add another
        // display a message
        echo '<p>Another product has been add to your shopping cart</p><br><a href="browse_products.php">Back</a><br><a href="view_cart.php">Checkout</a>';
    }
    else
    {
        // new product to the cart.
        // Get the product's price fromt the database
        require 'mysqli_connect.php';
        // connect to the database
        $q="select price from products where pid=$pid";
        $r=  mysqli_query($dbc, $q);
        if(mysqli_num_rows($r)==1)
        {
            // valid product id
            //Fetch the information
            list($price)=  mysqli_fetch_array($r, MYSQLI_NUM);
            // Add to cart
            $_SESSION['cart'][$pid]=array('quantity'=>1,'price'=>$price);
            // Display a message
            echo '<p style="text-align:center"> product has been added to shopping cart<br><a href="browse_products.php">Back</a><br><a href="view_cart.php">Checkout</a>';
            
        }
        else
        {
            // not a valid product id
            echo '<div align=center> This page has been accessed in error!<br><a href="browse_products.php">Back</a></div>';
            
        }
        mysqli_close($dbc); 
    } // End of isset ($_SESSION['cart'])
}
else
{
    // no product id
     echo '<div align=center> This page has been accessed in error!</div>';
            
}
foreach($_SESSION['cart'] as $pid => $value)
         {
             $q=$pid;
            
         }

?>

</div>
<?php
  include 'footer.php';
?>
</body>
</html>
    