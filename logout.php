<?php
include("dataconnection.php");
session_start();

unset($_SESSION["id"]); //only remove this data
session_unset(); //remove the data of all session variables
session_destroy();

echo '<script>alert("Logout successful!"); window.location.href = "indexhome.php";</script>';

?>