<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .btn {
            border: 2px solid gray;
            color: gray;
            background-color: white;
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
    <div class="upload-btn-wrapper">
        <button class="btn">Upload Images</button>
        <input type="file" name="myfile" id="file" multiple accept=".jpg, .png" onchange="validateFiles(this);">
    </div>

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
