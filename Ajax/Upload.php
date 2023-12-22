<?php
if (isset($_POST["action"])) {
    if ($_POST["action"] == "upload-file-post") {
        $targetDirectory = "../uploads/posts/";
        uploadFiles($targetDirectory);
    }
    if ($_POST["action"] == "upload-file-message") {
        $targetDirectory = "../uploads/messages/";
        uploadFiles($targetDirectory);
    }
    if ($_POST["action"] == "upload-file-user") {
        $targetDirectory = "../uploads/avatars/";
        uploadFiles($targetDirectory);
    }
    if ($_POST["action"] == "upload-file-about") {
        $targetDirectory = "../uploads/avatars/";
        uploadFiles($targetDirectory);
    }
}
function uploadFiles($targetDirectory)
{
    if (!empty($_FILES['fileToUpload'])) {
        $uploadedFiles = $_FILES['fileToUpload'];
        $uploadResponse = "";
        $images = array();
        for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
            $fileName = renderFileName(basename($uploadedFiles['name'][$i]));
            $targetFile = $targetDirectory . $fileName;
            if (move_uploaded_file($uploadedFiles['tmp_name'][$i], $targetFile)) {
                $uploadResponse .= "Tệp " . htmlspecialchars($uploadedFiles['name'][$i]) . " đã được tải lên thành công. ";
                array_push($images, $fileName);
            } else {
                $uploadResponse .= "Có lỗi xảy ra khi tải lên tệp " . htmlspecialchars($uploadedFiles['name'][$i]) . ". ";
            }
        }
        echo json_encode($images);
    } else {
        echo null;
    }
}

function renderFileName($fileName)
{
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $date = new DateTime();
    $strDate = $date->format("d_m_y");
    $randomString = generateRandomString(19);
    $newFileName = $strDate . '_' . $randomString . '.' . $fileExt;
    return $newFileName;
}
// Hàm sinh chuỗi ngẫu nhiên
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charLength - 1)];
    }
    return $randomString;
}

// echo renderFileName('91694736_258997547138232_1178341678839777451_n.jpgd');