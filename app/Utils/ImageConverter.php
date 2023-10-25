<?php

namespace App\Utils;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * Class ImageConverter
 * @package App\Utils
 */
class ImageConverter
{

    /**
     * @param $data
     * @return string
     */
    public static function base64url_encode($data)
    {
        return base64_encode($data);
    }

    /**
     * @param $data
     * @return false|string
     */
    public static function base64url_decode($data)
    {
        return base64_decode($data);
    }

    /**
     * @param File $file
     * @return string
     */
    public static function imageConvertToBase(File $file): string
    {
        return base64_encode(file_get_contents($file));
    }

    /**
     * @param $base64_str
     * @return string
     */
    public static function base64ToImageFtp($dir, $base64_str, string $format = Constants::IMAGE_FORMAT_PNG, int $quality = 100): string
    {
        try {
            $base64 = explode(',', $base64_str);
            $image = base64_decode($base64[1]);
            $safeName = md5(rand(11111, 99999)) . '.' . $format;
            $resized_image = Image::make($image)->resize(300, 250)->stream($format, $quality);
            $path = "/crm/$dir/" . basename($safeName);
            Storage::disk('sftp')->put("/$dir/" . basename($safeName), $resized_image);
            return env('CDN_IMG_URL', "http://localhost") . '/storage/' . $path;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param $dir
     * @param $base64_str
     * @param string $format
     * @param int $quality
     * @return string
     */
    public static function base64ToImageLocal($dir, $base64_str, string $format = Constants::IMAGE_FORMAT_PNG, int $quality = 100): string
    {
        try {
            $base64 = explode(',', $base64_str);
            $image = base64_decode($base64[1]);
            $safeName = md5(rand(11111, 99999)) . '.' . $format;
            $resized_image = Image::make($image)->resize(300, 250)->stream($format, $quality);
            $path = "/images/$dir/" . basename($safeName) . $safeName;
            Storage::disk('public')->put($path, $resized_image);
            return env('APP_URL') . '/storage/' . $path;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * @param $base64_str
     * @return string
     */
    public static function base64ToImage($dir, $base64_str)
    {
        try {
            $base64 = explode(',', preg_match("/data:([a-zA-Z0-9]+\/[a-zA-Z0-9-.+]+).base64,.*/", $base64_str) ? $base64_str : 'data:image/jpeg;base64,' . $base64_str);
            $image = base64_decode($base64[1]);
            $safeName = CommonUtil::generateUUID() . '.' . Constants::IMAGE_FORMAT_PNG;
            $resized_image = Image::make($image)->resize(500, 500)->stream('png', 100);
            Storage::disk('oss')->put(env('CDN_IMG_PATH_URL') . "/$dir/" . basename($safeName), $resized_image, 'public');
            return 'https://' . env('CDN_IMG_PATH_URL') . '.' . env('CDN_IMG_URL') . '/' . env('CDN_IMG_PATH_URL') . "/$dir/" . $safeName;
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
}
