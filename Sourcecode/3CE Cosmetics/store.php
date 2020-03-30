<?php
include('functions.php');
// session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	case "add":
		if(!empty($_POST["quantity"])) {
			$productByName = $db_handle->runQuery("SELECT * FROM products WHERE name='" . $_GET["name"] . "'");
			$itemArray = array($productByName[0]["name"]=>array('name'=>$productByName[0]["name"], 'quantity'=>$_POST["quantity"], 'price'=>$productByName[0]["price"], 'image'=>$productByName[0]["image"]));
			
			if(!empty($_SESSION["cart_item"])) {
				if(in_array($productByName[0]["name"],array_keys($_SESSION["cart_item"]))) {
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByName[0]["name"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0; 
								}
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				$_SESSION["cart_item"] = $itemArray;
			}
		}
    break;
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["name"] == $k)
						unset($_SESSION["cart_item"][$k]);				
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	case "empty":
		unset($_SESSION["cart_item"]);
    break;
    case "checkout":
        $data = file_get_contents('http://localhost/3CE%20Cosmetics/store.php');
        $dom = new domDocument;

        @$dom->loadHTML($data);
        $dom->preserveWhiteSpace = false;
        $tables = $dom->getElementsByTagName('table');

        foreach($rows as $row){
            $row = $tables->item(1)->getElementsByTagName('tr');

            foreach ($row as $cell) {
                    $cols = $cell->getElementsByTagName('td');
                    echo $cols[2];
            }
        }
        // $list = array();
        // $id = document.getElementsByClassName('id');
        // $name = document.getElementsByClassName('name');
        // $age = document.getElementsByClassName('age');

        // foreach($id){
        //     array_push($list,{$id: $id[i].innerHTML,$name: $name[i].innerHTML, $age: $age[i].innerHTML})
        // }
    break;
}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>3CE Cosmetics | Store</title>
        <meta charset="UTF-8">  
        <link rel="stylesheet" href="styles.css" />
        <script src="jquery/jquery.min.js"></script>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <script>
        function checkOut() {
            let list = new Array();
            let productname = document.getElementsByClassName('name');
            let quantity = document.getElementsByClassName('quantity');
            let price = document.getElementsByClassName('unitprice');
            for (let i = 0; i < productname.length; i++){
                list.push({productname: productname[i].innerHTML,quantity: quantity[i].innerHTML, price: price[i].innerHTML.substring(2, 9)})
            }
            console.log(list);

            $.ajax({
                url:"readJson.php",
                method: "post", 
                data: { list: JSON.stringify(list) },
                success: function(res){
                    console.log(res);
                }
            })
            alert('Thank you for your purchase')
        }
        </script>
    </head>
    
    <body>
        <div class="wrapper">

        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container" style="width: auto"><!-- Collapsable nav bar -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            
                <!-- Your site name for the upper left corner of the site -->
                <a class="brand">3CE Cosmetics</a>
            
                <!-- Start of the nav bar content -->
                <div class="nav-collapse"><!-- Other nav bar content -->
            
                    <!-- The drop down menu -->
                    <ul class="nav pull-right">
                    <li><a href="register.php">Sign Up</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="login.php">Sign In</a></li>
                    <li><?php  if (isset($_SESSION['user'])) : ?>
					<strong style="margin-left: 50px;"><?php echo $_SESSION['user']['username']; ?></strong>
				
						<i style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i> 
						<a href="admin.php?logout='1'" style="color: red;">logout</a>
				
				    <?php endif ?></li>
                    </ul>
                </div>
                </div>
            </div>
        </div>

        <header class="main-header">
            <h1 class="band-name-header band-name-large">3CE Cosmetics</h1>
        </header>
    
        <section class="main">
        <nav class="main-nav nav">
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="store.php">STORE</a></li>
                    <li><a href="about.html">ABOUT</a></li>
                </ul>
            </nav>
            <section class="content">
                <section class="container content-section">
                    <h2 id="duongam" class="section-header">Dưỡng ẩm</h2>
                    <div class="shop-items">
                    <?php
                    $product_array = $db_handle->runQuery("SELECT * FROM products WHERE category = 'skin_moisturizing' ORDER BY id ASC");
                    if (!empty($product_array)) { 
                        foreach($product_array as $key=>$value){
                    ?>
                        <div class="product-item">
                            <form method="post" action="store.php?action=add&name=<?php echo $product_array[$key]["name"]; ?>">
                            <img class="product-image"  src="Images/<?php echo $product_array[$key]["image"]; ?>">
                            <div class="product-tile-footer">
                                <div class="shop-item-title"><?php echo $product_array[$key]["name"]; ?></div>
                                <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                                <div class="cart-action"><input type="text" style="width: 50px;height: 32px;padding: 5px 10px;" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                            </div>
                            </form>
                        </div>
                        <?php
                            }
                        }?>
                        </div>
                </section>  

                <section class="container content-section">
                    <h2 id="trangdiemmoi" class="section-header">Trang điểm môi</h2>
                    <div class="shop-items">
                    <?php
                    $product_array = $db_handle->runQuery("SELECT * FROM products WHERE category = 'makeup_lips' ORDER BY id ASC");
                    if (!empty($product_array)) { 
                        foreach($product_array as $key=>$value){
                    ?>
                        <div class="product-item">
                            <form method="post" action="store.php?action=add&name=<?php echo $product_array[$key]["name"]; ?>">
                            <img class="product-image" src="Images/<?php echo $product_array[$key]["image"]; ?>">
                            <div class="product-tile-footer">
                            <div class="shop-item-title"><?php echo $product_array[$key]["name"]; ?></div>
                            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                            <div class="cart-action"><input type="text" style="width: 50px;height: 32px;padding: 5px 10px;" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                            </div>
                            </form>
                        </div>
                        <?php
                            }
                        }
                        ?>
                        </div>

                </section>
                
                <section class="container content-section">
                        <h2 id="duongthe" class="section-header">Dưỡng thể</h2>
                        <div class="shop-items">
                    <?php
                    $product_array = $db_handle->runQuery("SELECT * FROM products WHERE category = 'body_lotion' ORDER BY id ASC");
                    if (!empty($product_array)) { 
                        foreach($product_array as $key=>$value){
                    ?>
                        <div class="product-item">
                            <form method="post" action="store.php?action=add&name=<?php echo $product_array[$key]["name"]; ?>">
                            <img class="product-image" src="Images/<?php echo $product_array[$key]["image"]; ?>">
                            <div class="product-tile-footer">
                            <div class="shop-item-title"><?php echo $product_array[$key]["name"]; ?></div>
                            <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                            <div class="cart-action"><input type="text" style="width: 50px;height: 32px;padding: 5px 10px;" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>
                            </div>
                            </form>
                        </div>
                        <?php
                            }
                        }
                        ?>
                        </div>
                </section>

                <section class="container content-section">
                <div id="shopping-cart">
                <div class="txt-heading">Shopping Cart</div>
                
                
                    <?php
                    if(isset($_SESSION["cart_item"])){
                        $total_quantity = 0;
                        $total_price = 0;
                    ?>	
                    <table class="tbl-cart"  cellpadding="10" cellspacing="1">
                    <tbody>
                    <tr>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:right;" width="5%">Quantity</th>
                    <th style="text-align:right;" width="10%">Unit Price</th>
                    <th style="text-align:right;" width="10%">Price</th>
                    <th style="text-align:center;" width="5%">Remove</th>
                    </tr>	
                                                        <!-- <img src="Images/?php echo $item["image"]; ?>" class="cart-item-image" /> -->
                    <?php		
                        foreach ($_SESSION["cart_item"] as $item){
                            $item_price = $item["quantity"]*$item["price"];
                            // $item_id =  $item["id"];
                            ?>
                                <tr>
                                <td class="name"><?php echo $item["name"]; ?></td>
                                <td style="text-align:right;" class="quantity"><?php echo $item["quantity"]; ?></td>
                                <td style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
                                <td style="text-align:right;" class="unitprice"><?php echo "$ ". number_format($item_price,2); ?></td>
                                <td style="text-align:center;"><a href="store.php?action=remove&name=<?php echo $item["name"]; ?>" class="btnRemoveAction"><img src="icon-delete.png" alt="Remove Item" /></a></td>
                                </tr>
                                <?php
                                $total_quantity += $item["quantity"];
                                $total_price += ($item["price"]*$item["quantity"]);
                            }
                            ?>
                    <tr>
                    <td colspan="2" align="right">Total:</td>
                    <td align="right"><?php echo $total_quantity; ?></td>
                    <td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>  
                    </tr>
                    </tbody>
                    </table>   
                    <a id="btnCart" href="store.php?action=empty">Empty Cart</a>
                    <a ></a>
                    <!-- <a id="btnCart" href="store.php?action=checkout">Check Out</a> -->
                    <?php
                        if(!isLoggedIn()) {?>
                            <div class="no-records">Please Login to CheckOut</div>
                    <?php
                        }else {
                    ?>
                    <input id="btnCheckOut" type="button" value="Checkout" onclick="checkOut()"/>
                    <?php 
                    }
                    ?>
                    
                    <?php
                    } else {
                    ?>
                    <div class="no-records">Your Cart is Empty</div>
                    <?php 
                    }
                    ?>
                    </div>
                    </section>                
                </section> 


            <aside class="left">
                <h3>Dưỡng da</h3>
                <ul>
                    <li><a href="#duongam">Dưỡng ẩm</a></li>
                    <li><a href="#">Mặt nạ</a></li>
                    <li><a href="#">Làm sạch</a></li>
                    <li><a href="#">Chống nắng</a></li>
                    <li><a href="#">Tinh chất dưỡng</a></li>
                </ul>
                <h3>Dụng cụ trang điểm</h3>
                <ul>
                    <li><a href="#">Trang điểm nền</a></li>
                    <li><a href="#trangdiemmoi">Trang điểm môi</a></li>
                    <li><a href="#">Trang điểm mắt</a></li>
                    <li><a href="#">Móng tay</a></li>
                </ul>
                <h3>Toàn thân</h3>
                <ul>
                    <li><a href="#duongthe">Dưỡng thể</a></li>
                    <li><a href="#">Dưỡng da tay</a></li>
                    <li><a href="#">Nước hoa</a></li>
                </ul>
            </aside>
        </section>

        <footer class="main-footer">
            <div class="container  main-footer-container">
                <h3 class="band-name-footer">3CE Cosmetics</h3>
                <ul class="nav footer-nav">
                    <li>
                        <a href="https://www.youtube.com" target="_blank">
                            <img src="Images/YouTube Logo.png">
                        </a>
                    </li>
                    <li>    
                        <a href="https://www.spotify.com" target="_blank">
                            <img src="Images/Spotify Logo.png">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com" target="_blank">
                            <img src="Images/Facebook Logo.png">
                        </a>
                    </li>
                </ul>
            </div>
        </footer>

        </div>
    </body>

    
</html>