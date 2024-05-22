<?php 
  include("db.php");

   $sql = "SELECT id,product_name,qty,total_price FROM trans WHERE id='".$_POST['id']."'";
   $query = mysqli_query($conn,$sql);
   while($row = mysqli_fetch_assoc($query))
   {
         $data = $row;
   }
    echo json_encode($data);
 ?>