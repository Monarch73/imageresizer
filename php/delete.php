<?php
if(isset($_GET['file'])) {
    $file = urldecode($_GET['file']); // Decode URL-encoded string

    if(file_exists($file)) { // Check the file exists 
        unlink($file); // Delete the file
    }
}

// Redirect to test.php
header("Location: test.php");
exit;
