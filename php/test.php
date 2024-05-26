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
            <input type="file" name="myfile" id="file" multiple accept=".jpg, .png, .jepg" onchange="validateFiles(this);">
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
</body>
</html>
<?php
// check if files are uploaded
if(isset($_FILES['myfile'])) {
    var_dump($_FILES['myfile']);
    $errors = [];
    $path = 'uploads/';
    $extensions = ['jpg', 'jpeg', 'png'];
    $all_files = count($_FILES['myfile']['tmp_name']);
    for($i = 0; $i < $all_files; $i++) {
        $file_name = $_FILES['myfile']['name'][$i];
        $file_tmp = $_FILES['myfile']['tmp_name'][$i];
        $file_type = $_FILES['myfile']['type'][$i];
        $file_size = $_FILES['myfile']['size'][$i];
        $file_ext = strtolower(end(explode('.', $_FILES['myfile']['name'][$i])));
        $file = $path . $file_name;
        if(!in_array($file_ext, $extensions)) {
            $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
        }
        if($file_size > 2097152) {
            $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
        }
        if(empty($errors)) {
            move_uploaded_file($file_tmp, $file);
        }
        
    }
    if($errors) print_r($errors);
}