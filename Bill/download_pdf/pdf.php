<?php 
   include("db.php");
   
   ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="pdf.css" />
    <script src="pdf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

</head>

<body>

<div class="container d-flex justify-content-center mt-50 mb-50">
        <div class="row">
            <div class="col-md-12 text-right mb-3">
                <button class="btn btn-primary" id="download"> download pdf</button>
            </div>
            <div class="col-md-12">

                <div class="card" id="invoice">
                   
                    <div><br></br>
                        <h3 class="text-center" style="color:green">THE ORIGINALS FOR YOU</h3>
                        <h6 class="text-center" style="font-size:15px;">410,Kunnathur Road,Perundurai TK</h6>
                        <h6 class="text-center" style="font-size:15px;">Gmail:originalsforyou12@gmail.com</h6>
                        <h6 class="text-center" style="font-size:15px;">Phone:9840427861</h6><hr></hr>
                        
                       
                             
                    <div class="p-4">
                       <div class="text-center">
                             <h4>Receipt</h4>
                        </div>
                        <span class="mt-4"> Date : </span><span  class="mt-4">
                        <?php 
                              date_default_timezone_set('Asia/Kolkata');
                              $currentDate = date( 'd-m-Y');
                              $currentTime= date('h:i',time ());
                              echo $currentDate;
                              echo "</br>";
                              echo "Time : "; 
                              echo $currentTime;?></span>
                        <div class="row">
                             <div class="col-xs-6 col-sm-6 col-md-6 ">
                                 <span><?php ?></span>
                             </div>
                             
                        </div>  
                    </div>   
                   
              
                    <div class="table-responsive">
                        <table class="table table-lg">

                            <thead>
                                <tr>
                                   <th> No.</th>
                                   <th>Product Name</th>
                                   <th>Quantity</th>
                                   <th >Price</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                 <td>
                                   <?php 
                                   $grand_total=0;
                                   $gtax=0;
                                   ?>
                                     <?php 
                                         $sql = "SELECT id,product_name,qty,total_price FROM cart";
                                         $query = mysqli_query($conn,$sql);
                                         
                                       
                                         while($row = mysqli_fetch_assoc($query)){
                                            $grand_total += $row['total_price'];
                                            $gtax=$grand_total*((100+5)/100);
                                         ?>
                                 <tr>
                                   <td> <?php echo $row['id']; ?> </td>      
                                   <td> <?php echo $row['product_name']; ?> </td>
                                   <td><?php echo $row['qty']; ?> </td>
                                   <td> <?php echo $row['total_price']; ?> </td><br><br> <?php  }?> 
                                 </tr>
                                 </td> 
                               
                                
                                   <td class="text-right text-dark" >
                                        <h5><strong>Sub Total:  ₹ <?php echo number_format($grand_total,2) ?>  </strong></h5>
                                        <p><strong>Tax (5%) : ₹ <?php echo number_format($gtax,2) ?></strong></p>
                                   </td> 
                                   <td class="text-center text-dark" >
                                      <h5> <strong><span id="subTotal"></strong></h5>
                                      <h5> <strong><span id="taxAmount"></strong></h5>
                                   </td>  
                                </tr>
                            </tbody>
                            <tr>
                                <td>  
                                   <td>  </td>
                                   <td>  </td>
                                   <td>  </td>  
                                   
                                   <td class="text-right text-dark">
                                
                                      <h5 > <strong>Gross Total: ₹ <?php echo number_format($gtax,2) ?></strong>  </h5> 
                                   </td>
                                   <td class="text-center text-danger">
                                      <h5 id="totalPayment"><strong> </strong></h5>
                                      
                                   </td>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
            

                    <div class="card-footer"> <h6 class="text-center" style="font-size:15px;">Thanks For Shopping!</h6> </div>

                </div>
            </div>
        </div>
    </div>
 </body>        
</html>                   
    <script>
        // Code for year 
        $(document).ready(function(){     
        // Code for year 
             
        var currentdate = new Date(); 
             var datetime = currentdate.getDate() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getFullYear();
                $('#year').text(datetime);
 
           // Code for extract Weekday     
                function myFunction()
                 {
                    var d = new Date();
                    var weekday = new Array(7);
                    weekday[0] = "Sunday";
                    weekday[1] = "Monday";
                    weekday[2] = "Tuesday";
                    weekday[3] = "Wednesday";
                    weekday[4] = "Thursday";
                    weekday[5] = "Friday";
                    weekday[6] = "Saturday";
 
                    var day = weekday[d.getDay()];
                    return day;
                    }
                var day = myFunction();
                $('#day').text(day);
     });
</script>
 
<!-- // Code for TIME -->
<script>
    window.onload = displayClock();
 
     function displayClock(){
       var time = new Date().toLocaleTimeString();
       document.getElementById("time").innerHTML = time;
        setTimeout(displayClock, 1000); 
     }
</script>