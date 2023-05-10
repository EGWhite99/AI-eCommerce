<?php include('header.php'); ?>


<?php

include('connection.php');

if(isset($_GET['itemNum'])){

    $itemNum =  $_GET['itemNum'];

    $stmt = $db->prepare("SELECT * FROM products WHERE itemNum = ?");
    $stmt->bind_param("i",$itemNum);

    $stmt->execute();


    $product = $stmt->get_result();//[]




  //no product id was given
}else{

  header('location: index.php');

}



?>



      <!--Single product-->
      <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

          <?php  while($row = $product->fetch_assoc()){ ?>

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="<?php echo $row['merchImagePath']; ?>" id="mainImg"/>
            </div>

           


            <div class="col-lg-6 col-md-12 col-12">
                <h6>Men/Shoes</h6>
                <h3 class="py-4"><?php echo $row['title']; ?></h3>
                <h2>$<?php echo $row['price']; ?></h2>

                <form method="POST" action="cart.php">
                  <input type="hidden" name="itemNum" value="<?php echo $row['itemNum']; ?>" />
                  <input type="hidden" name="merchImagePath" value="<?php echo $row['merchImagePath']; ?>"/>  
                  <input type="hidden" name="title" value="<?php echo $row['title']; ?>"/>
                  <input type="hidden" name="price" value="<?php echo $row['price']; ?>"/>
                  
                      <input type="number" name="product_quantity" value="1"/>
                      <button class="buy-btn" type="submit" name="add_to_cart">Add To Cart</button>
                </form>

               

            </div>

        

            <?php } ?>

        </div>





<?php include('layouts/footer.php'); ?>