<?php 
session_start();
include("dataconnection.php");
include 'header.php';
 
 $d=$dr='';

 if(isset($_POST['s']))
 {
     if($_POST['d']!='')
     {
        $d=$_POST['d'];

        $ey=date('Year',strtotime($_POST['d'])); //entered year
        $em=date('Month',strtotime($_POST['d'])); //entered month
        $ed=date('Date',strtotime($_POST['d'])); //entered date

        $edays=($ey-1)*365 + ($em-1)*30 + $ed;

        $sy=date('Year'); //system or current year
        $sm=date('Month'); //system or current month
        $sd=date('Date'); //system or current date

        $sdays=($sy-1)*365 + ($sn-1)*30 + $sd;

        $diff = ($edays - $sdays);

        if($diff>0 && $diff<=30)
        {
            $dr="Date of booking confirmed ".$d;
        }
        else
        {
            $dr="Booking for within 39 days";
        }

     }
     else
     {
        $dr='Enter any date';
     }
 }
?>

<!DOCTYPE html>
<html >
<head>
    <link rel="stylesheet" href="1234.css">
</head>
<!-- banner -->
<div class="banner">    	   
    <img src="images/photos/SkylineMalaysia.jpg"  class="img-responsive " alt="slide">
    <div class="welcome-message">
        <div class="wrap-info">
            <div class="information rgba">
                <h1  class="animated fadeInDown">Best hotel in Malaysia</h1>
                <p class="animated fadeInUp">Most luxurious hotel of asia with the royal treatments and excellent customer service.</p>                
            </div>
            
        </div>
    </div>
</div>
<!-- banner-->

<!-- reservation-information -->

<!-- reservation-information -->



<!-- services -->

</html>
<!-- services -->


<?php include 'footer.php';?>