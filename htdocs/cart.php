<?php include('header.php'); ?>


<?php





if(isset($_POST['add_to_cart'])){

    //if user has already added a product to cart
    if(isset($_SESSION['cart'])){

       $products_array_ids = array_column($_SESSION['cart'],"itemNum"); // [2,3,4,10,15]
       //if product has already been addedcto cart or not
       if( !in_array($_POST['itemNum'], $products_array_ids) ){

            $itemNum = $_POST['itemNum'];
      
              $product_array = array(
                              'itemNum' => $_POST['itemNum'],
                              'title' =>  $_POST['title'],
                              'price' => $_POST['price'],
                              'merchImagePath' => $_POST['merchImagePath'],
                              'product_quantity' => $_POST['product_quantity']
              );
      
              $_SESSION['cart'][$itemNum] = $product_array;


        //product has already been added
       }else{
         
            echo '<script>alert("Product was already to cart");</script>';
           

       }


      //if this is the first product
    }else{
 
       $itemNum = $_POST['itemNum'];
       $title = $_POST['title'];
       $price = $_POST['price'];
       $merchImagePath = $_POST['merchImagePath'];
       $product_quantity = $_POST['product_quantity'];

       $product_array = array(
                        'itemNum' => $itemNum,
                        'title' => $title,
                        'price' => $price,
                        'merchImagePath' => $merchImagePath,
                        'product_quantity' => $product_quantity
       );

       $_SESSION['cart'][$itemNum] = $product_array;
       // [ 2=>[] , 3=>[], 5=>[]  ]


    }


    //calculate total
    calculateTotalCart();






//remove product from cart
}else if(isset($_POST['remove_product'])){

  $itemNum = $_POST['itemNum'];
  unset($_SESSION['cart'][$itemNum]);

  //calculate total
  calculateTotalCart();



}else if( isset($_POST['edit_quantity']) ){

    //we get id and quantity from the form
   $itemNum = $_POST['itemNum'];
   $product_quantity = $_POST['product_quantity'];

   //get the product array from the session
   $product_array = $_SESSION['cart'][$itemNum];

   //update product quantity
   $product_array['product_quantity'] = $product_quantity;


   //return array back its place
   $_SESSION['cart'][$itemNum] = $product_array;


   //calculate total
   calculateTotalCart();

   

}else{
  // header('location: index.php');
}





function calculateTotalCart(){

     $total_price = 0;
     $total_quantity = 0;

    foreach($_SESSION['cart'] as $key => $value){
 
        $product =  $_SESSION['cart'][$key];

        $price =  $product['price'];
        $quantity = $product['product_quantity'];

        $total_price =  $total_price + ($price * $quantity);
        $total_quantity = $total_quantity + $quantity;
        

    }

    $_SESSION['total'] = $total_price;
    $_SESSION['quantity'] = $total_quantity;

}





?>





    <!--Cart-->
    <section class="cart container my-5 py-5">
        <div class="container mt-5">
            <h2 class="font-weight-bolde">Your Cart</h2>
            <hr>
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>

          <?php if(isset($_SESSION['cart'])){ ?>  

            <?php foreach($_SESSION['cart'] as $key => $value){ ?>

            <tr>
                <td>
                    <div class="product-info">
                        <img src="<?php echo $value['merchImagePath']; ?>"/>
                        <div>
                            <p><?php echo $value['title']; ?></p>
                            <small><span>$</span><?php echo $value['price']; ?></small>
                            <br>
                            <form method="POST" action="cart.php">
                                 <input type="hidden" name="itemNum" value="<?php echo $value['itemNum']; ?>"/>
                                 <input type="submit" name="remove_product" class="remove-btn" value="remove"/>
                            </form>
                           
                        </div>
                    </div>
                </td>

                <td>
                    
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="itemNum" value="<?php echo $value['itemNum'];?>"/>
                        <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>"/>
                        <input type="submit" class="edit-btn" value="edit" name="edit_quantity"/>
                    </form>
                    
                </td>

                <td>
                    
                    <span class="product-price">$<?php  echo $value['product_quantity'] * $value['price']; ?></span>
                </td>
            </tr>

         
            <?php } ?>


            <?php } ?>

         
        </table>


        <div class="cart-total">
          <table>
            <!-- <tr>
              <td>Subtotal</td>
              <td>$155</td>
            </tr> -->
            <tr>
              <td>Total</td>
              <?php if(isset($_SESSION['cart'])){?>
                 <td>$<?php echo $_SESSION['total']; ?></td>
               <?php } ?>  
            </tr>
          </table>
        </div>
    

        <div class="checkout-container">
          <form method="POST" action="checkout.php">
             <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
          </form>
        </div>


    </section>








    <?php include('layouts/footer.php'); ?>