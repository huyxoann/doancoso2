<?php
require_once('connection.php');
if (isset($_POST['change'])) {
    $cv_name = mysqli_escape_string($conn, $_POST['cv_name']);
    $pdf_file = $_FILES['file_pdf']['name'];
    $pdf_file_temp = $_FILES['file_pdf']['tmp_name'];
    $career_id = mysqli_escape_string($conn, $_POST['career']);
    $exp_id = mysqli_escape_string($conn, $_POST['exp']);
    $id_cv = mysqli_escape_string($conn, $_POST['id_cv']);
    $destination_path = getcwd() . DIRECTORY_SEPARATOR;
    $target_path = $destination_path . '../pdf/' . basename($_FILES["file_pdf"]["name"]);
    $query_update_cv_info = "UPDATE `cv` SET `cv_name` = '$cv_name', `file_name` = '$pdf_file', `career_id` = '$career_id', `exp_id` = '$exp_id' WHERE `cv_id` = '$id_cv'";

    $allowUpload   = true;

    $imageFileType = pathinfo($target_path, PATHINFO_EXTENSION);

    $maxfilesize   = 800000;

    $allowtypes    = array('pdf');


    if ($_FILES["file_pdf"]["size"] > $maxfilesize) {
        echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
        $allowUpload = false;
    }


    if (!in_array($imageFileType, $allowtypes)) {
        echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
        $allowUpload = false;
    }


    if ($allowUpload) {
        if (file_exists($target_path)) {
            echo "Tên file đã tồn tại trên server, không được ghi đè";
            if (mysqli_query($conn, $query_update_cv_info)) {
                // header("Location: ../hoso_cv.php");
            }
        } else {
            if (move_uploaded_file($_FILES["file_pdf"]["tmp_name"], $target_path)) {
                echo "File " . basename($_FILES["file_pdf"]["name"]) .
                    " Đã upload thành công.";
                if (mysqli_query($conn, $query_update_cv_info)) {
                    // header("Location: ../hoso_cv.php");
                } else {
                    echo "..";
                }
                echo "File lưu tại " . $target_path;
            } else {
                echo "Có lỗi xảy ra khi upload file.";
            }
        }
    } else {
        echo "Không upload được file, có thể do file lớn, kiểu file không đúng ...";
    }
}
