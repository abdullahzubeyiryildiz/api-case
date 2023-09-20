<?php

if (!function_exists('api_response')) {
    function api_response($message = null, $status = 200, $data = null) {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}


if (!function_exists('removeImage')) {
    function removeImage($image) {
        if(file_exists($image)) {
            if(!empty($image)) {
                unlink($image);
            }
        }
    }
}



if (!function_exists('createFolder')) {
    function createFolder($filePath, $permission = 0777) {
        if (!file_exists($filePath)) {
            mkdir($filePath, $permission, true);
        }
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($image,$fileName,$filePath) {
        createFolder($filePath);
        $ext = $image->getClientOriginalExtension();
        $fileName = Str::slug($fileName).'-'.time();
        if($ext == 'pdf' ||  $ext == 'svg' ||  $ext == 'webp' ||  $ext == 'jiff') {
            $image->move(public_path($filePath),$fileName.'.'.$ext);
            $imageUrl = $filePath.$fileName.'.'.$ext;
        }else {
            $image = ImageUpload::make($image);
            $image->encode('webp', 75)->save($filePath.$fileName.'.webp');
            $imageUrl = $filePath.$fileName.'.webp';
        }
        return  $imageUrl;
   }
}
