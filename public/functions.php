<?php

function sanitizeInput($data)
{
    return htmlspecialchars(trim($data));
}

function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isImage($file)
{
    $check = getimagesize($file["tmp_name"]);
    return $check !== false;
}

function isFileSizeValid($file, $maxSize)
{
    return $file["size"] <= $maxSize;
}

function isFileTypeAllowed($file, $allowedTypes = ["jpg", "jpeg", "png"])
{
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    return in_array($imageFileType, $allowedTypes);
}

function moveFile($file, $targetDir, $targetName = "")
{
    // Ensure target directory exists, create if it doesn't
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Recursive directory creation
    }

    if (!empty($targetName)) {
        $targetFile = $targetDir . $targetName;
    } else {
        $targetFile = $targetDir . basename($file["name"]);
    }

    return move_uploaded_file($file["tmp_name"], $targetFile) ? $targetFile : false;
}

function normalizeImageName($filename)
{
    $filename = preg_replace("/[^a-zA-Z0-9_.]/", "", $filename);
    $filename = str_replace(" ", "_", $filename);
    $filename = strtolower($filename);
    return $filename;
}

function deleteFileInFolder($folderPath, $fileName)
{
    $filePath = $folderPath . $fileName;
    if (is_file($filePath)) {
        return unlink($filePath);
    }
    return false;
}

function deleteUserFolder($userId)
{
    $userFolder = "../uploads/" . $userId . "/";

    if (file_exists($userFolder)) {
        $dir = opendir($userFolder);

        while (($file = readdir($dir)) !== false) {
            // Skip "." and ".." entries
            if ($file == '.' || $file == '..') {
                continue;
            }

            if (!deleteFileInFolder($userFolder, $file)) {
                closedir($dir);
                return false;
            }
        }
        closedir($dir);

        if (rmdir($userFolder)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkImageFile($file)
{
    if (!isImage($file)) {
        return [false, "File is not an image."];
    }

    $maxFileSizeInBytes = 515000; // 500 KB in bytes
    if (!isFileSizeValid($file, $maxFileSizeInBytes)) {
        return [false, "File is too large, it exceeds max size of 500KB."];
    }

    if (!isFileTypeAllowed($file)) {
        return [false, "Only JPG, JPEG, and PNG files are allowed."];
    }
    return [true, null];
}
