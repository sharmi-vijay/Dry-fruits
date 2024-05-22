<?php
	session_start();

	require 'config.php';

	// Add products into the cart table
	if (isset($_POST['pid'])) {
	  $pid = $_POST['pid'];
	  $pname = $_POST['pname'];
	  $pprice = $_POST['pprice'];
	  $pimage = $_POST['pimage'];
	  $pcode = $_POST['pcode'];
	  $pqty = $_POST['pqty'];

	  $total_price = $pprice * $pqty;

	  $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
	  $stmt->bind_param('s',$pcode);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['product_code'] ?? '';

	  if (!$code) {
	    $query = $conn->prepare('INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)');
	    $query->bind_param('ssssss',$pname,$pprice,$pimage,$pqty,$total_price,$pcode);
	    $query->execute();

	    echo '<div class="alert alert-success alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item added to your cart!</strong>
						</div>';
	  } 
	
	  
	  else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Item already added to your cart!</strong>
						</div>';
	  }
	}

	
                   

	// Get no.of items available in the cart table
	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  $stmt = $conn->prepare('SELECT * FROM cart');
	  $stmt->execute();
	  $stmt->store_result();
	  $rows = $stmt->num_rows;

	  echo $rows;
	}   
	

	// Remove single items from cart
	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];

	  $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
	  $stmt->bind_param('i',$id);
	  $stmt->execute();

	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}

	if (isset($_POST['pid'])) {
		$stmt= $conn->prepare('INSERT INTO trans SELECT Distinct * FROM cart');
	    $stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
        echo $rows;
	  } 
	  
	  
	  if (isset($_POST['pid'])) {
		$stmt= $conn->prepare('UPDATE item JOIN trans on trans.product_name = item.itemName SET stock = (stock - trans.qty)');
	    $stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
        echo $rows;
	  } 

	  if (isset($_POST['pid'])) {
		$stmt= $conn->prepare('UPDATE product JOIN trans on trans.product_name = product.product_name SET product_stock = (product_stock - trans.qty)');
	    $stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
        echo $rows;
	  }

	// Remove all items at once from cart
	if (isset($_GET['clear'])) {
	  //$stmt = $conn->prepare('INSERT trans select * from cart');
	  $stmt = $conn->prepare('DELETE FROM cart');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}

	// Set total price of the product in the cart table
	if (isset($_POST['pid'])) {
	  
		$pid = $_POST['pid'];
		$pqty = $_POST['pqty'];
	  
	  $pprice = $_POST['pprice'];

	 $tprice = $pqty * $pprice;

	  $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
	  $stmt->bind_param('isi',$pqty,$tprice,$pid);
	  $stmt->execute();
	  
	}

	// Checkout and save customer info in the orders table
	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = $_POST['name'];
	  $email = $_POST['email'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $qty = $_POST['qty'];
	  $grand_total = $_POST['grand_total'];
	  $address = $_POST['address'];
	  $pmode = $_POST['pmode'];

	  $data = '';

	  $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid,qty)VALUES(?,?,?,?,?,?,?,?)');
	  $stmt->bind_param('ssssssss',$name,$email,$phone,$address,$pmode,$products,$grand_total,$qty);
	  $stmt->execute();
	  $stmt2 = $conn->prepare('DELETE FROM cart');
	  $stmt2->execute();
	  $data .= '<div class="text-center">
								<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
								<h2 class="text-success">Your Order Placed Successfully!</h2>
								<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products .'</h4>
								<h4>Your Name : ' . $name . '</h4>
								<h4>Your E-mail : ' . $email . '</h4>
								<h4>Your Phone : ' . $phone . '</h4>
								<h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
								<h4>Payment Mode : ' . $pmode . '</h4>
						  </div>';
	  echo $data;
	}
?>
