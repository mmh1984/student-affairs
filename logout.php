<?php
session_start();
session_unset();
session_destroy();

echo "<script> alert('Logging out') </script>";
echo "<script> window.location.href='index.html' </script>";

?>