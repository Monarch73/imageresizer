<!DOCTYPE html>
<html>
<head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #0000aa;
        color: white;
    }
    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .btn {
        border: 2px solid gray;
        color: white;
        background-color: #0000aa;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 20px;
        font-weight: bold;
    }
    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
</style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="upload-btn-wrapper">
            <button class="btn">Upload Images</button>
            <input type="file" name="myfile[]" id="file" multiple accept=".jpg, .png, .jepg" onchange="validateFiles(this);">
        </div>
        <input type="submit" value="Upload" name="submit">
    </form>
    <script>
        function validateFiles(input) {
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            for(var i=0; i<input.files.length; i++) {
                if(!allowedExtensions.exec(input.files[i].name)) {
                    alert('Invalid file type. Only jpg and png are allowed.');
                    input.value = '';
                    break;
                }
            }
        }
    </script>
<?php
// check if files are uploaded
if(isset($_FILES['myfile'])) {
    var_dump($_FILES);
    $errors = [];
    $path = 'uploads/';
    $extensions = ['jpg', 'jpeg', 'png'];
    $all_files = count($_FILES['myfile']['tmp_name']);
    $zip = new ZipArchive();
    $zipName = date('Y-m-d-H-i-s') . '.zip';
    if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE) {
        exit("Cannot open <$zipName>\n");
    }

    for($i = 0; $i < $all_files; $i++) {
        $file_name = $_FILES['myfile']['name'][$i];
        $file_tmp = $_FILES['myfile']['tmp_name'][$i];
        $file_type = $_FILES['myfile']['type'][$i];
        $file_size = $_FILES['myfile']['size'][$i];
        $file_ext = strtolower(end(explode('.', $_FILES['myfile']['name'][$i])));
        $file = $path . $file_name;
        if(!in_array($file_ext, $extensions)) {
            // display warning message that tells the user that the current file is skipped
            echo "File $file_name has an invalid extension and was skipped.<br>";
            continue;
        }
        // Get the image dimensions
        list($width, $height) = getimagesize($file_tmp);

        // Check if the resolution is less than 4MPixels
        if ($width * $height < 4000000) {
            // Move the uploaded file to the desired location without resizing
            move_uploaded_file($file_tmp, $file);
        } 
        else {
            if ($file_ext == "jpg" || $file_ext == "jpeg") {
                $src = imagecreatefromjpeg($file_tmp);
            } else if ($file_ext == "png") {
                $src = imagecreatefrompng($file_tmp);
            }
    
            // Get the image dimensions
    
            // Calculate new dimensions, keeping aspect ratio
            $maxResolution = 2000; // Maximum resolution for either width or height

            if($width > $height) {
                // Landscape image
                $newWidth = $maxResolution;
                $newHeight = ($height / $width) * $newWidth;
            } else {
                // Portrait image
                $newHeight = $maxResolution;
                $newWidth = ($width / $height) * $newHeight;
            }    
            // Create a new true color image
            $dst = imagecreatetruecolor($newWidth, $newHeight);
    
            // Copy and resize the image
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
            // Save the resized image
            if ($file_ext == "jpg" || $file_ext == "jpeg") {
                imagejpeg($dst, $file,75);
            } else if ($file_ext == "png") {
                imagepng($dst, $file,9);
            }
        } 
        $zip->addFile($file, basename($file));

        // Free up memory
        imagedestroy($src);
        imagedestroy($dst);
    }
} 
$zip->close();

// Get all existing zip files in the current directory
$zipFiles = glob('*.zip');

// After all zip files have been created, iterate over the array
foreach ($zipFiles as $zipFile) {
    // Generate an HTML link for downloading the file
    echo "<a href=\"$zipFile\">Download $zipFile</a><br>";

    // Generate an HTML link for deleting the file
    $encodedFile = urlencode($zipFile);
    echo "<a href=\"delete.php?file=$encodedFile\">Delete $zipFile</a><br>";
}
?>
</body>
</html>