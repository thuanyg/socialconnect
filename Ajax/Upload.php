<?php
if (!empty($_FILES['fileToUpload'])) {
    $targetDirectory = "../uploads/posts/";
    $uploadedFiles = $_FILES['fileToUpload'];
    $uploadResponse = "";
    $images = array();
    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        $targetFile = $targetDirectory . basename($uploadedFiles['name'][$i]);
        if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetFile)) {
            $uploadResponse .= "Tệp " . htmlspecialchars($uploadedFiles['name'][$i]) . " đã được tải lên thành công. ";
            array_push($images, basename($uploadedFiles['name'][$i]));
        } else {
            $uploadResponse .= "Có lỗi xảy ra khi tải lên tệp " . htmlspecialchars($uploadedFiles['name'][$i]) . ". ";
        }
    }
    echo json_encode($images);
} else {
    echo null;
}
