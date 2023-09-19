<?php

if (!function_exists('api_response')) {
    function api_response($message = null, $status = 200, $data = null) {
        return response()->json(['message' => $message, 'data' => $data], $status);
    }
}


if (!function_exists('dosyasil')) {
    function dosyasil($string) {
        if(file_exists($string)) {
            if(!empty($string)) {
                unlink($string);
            }
        }
    }
}



if (!function_exists('klasorac')) {
    function klasorac($dosyayol, $izinler = 0777) {
        if (!file_exists($dosyayol)) {
            mkdir($dosyayol, $izinler, true);
        }
    }
}

if (!function_exists('resimyukle')) {
    function resimyukle($image,$name,$yol) {
        klasorac($yol);
        $uzanti = $image->getClientOriginalExtension();
        $dosyadi = Str::slug($name).'-'.time();
        if($uzanti == 'pdf' ||  $uzanti == 'svg' ||  $uzanti == 'webp' ||  $uzanti == 'jiff') {
            $image->move(public_path($yol),$dosyadi.'.'.$uzanti);
            $imageurl = $yol.$dosyadi.'.'.$uzanti;
        }else {
            $image = ImageUpload::make($image);
            $image->encode('webp', 75)->save($yol.$dosyadi.'.webp');
            $imageurl = $yol.$dosyadi.'.webp';
        }
        return  $imageurl;
   }
}
