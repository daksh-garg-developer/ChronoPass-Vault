<?php
session_start();
session_destroy();
header("Location: index.html"); // Go back to the new landing page
exit();
?>