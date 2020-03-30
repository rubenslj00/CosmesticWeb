<?php
    session_start();
    include('functions.php');
    require_once("dbcontroller.php");
    $db_handle = new DBController();

    $list=json_decode($_POST['list'],true);
    // foreach($list as $row){
    //     print_r($row['productname']);
    //     print_r($row['quantity']);
    //     print_r($row['price']);
    // }

    if(isset($_SESSION['user'])){
        echo $output = $_SESSION['user']['username'];
        $db_handle->insertQuery("INSERT INTO `orders`(`user`) VALUES ('" .$output. "')");
       $listID = $db_handle->runQuery("SELECT `id` FROM `orders` WHERE `user`='" .$output. "' ORDER BY `id` DESC LIMIT 1");
    }

    print_r($listID);
    foreach($listID as $id){

        $orderID = $id['id'];

    }
    
    print_r($orderID);

    foreach($list as $row){
        $name = $row['productname'];
        $quantity = $row['quantity'];
        $price = $row['price'];
        $db_handle->insertQuery("INSERT INTO `order_detail` (`orderid`, `productname`, `quantity`, `price`) VALUES ('" .$orderID. "', '" .$name. "', '" .$quantity. "', '" .$price. "')");
    }
?>