<?php
class ImageResizer
{
    private $thumbWidth = "550";
    private $thumbHeight = "340";
    
    function resizeImage($image_name) {
        $sourcePath = 'images/' . $image_name;
        $targetPath = 'images/thumb/' . $image_name;
        $sourcePathinfo = getimagesize($sourcePath);
        $originalImage = imagecreatefromjpeg($sourcePath);
        $width          =   $sourcePathinfo[0];
        $height          =   $sourcePathinfo[1];
        if($width > $height) {
            $thumbWidth    =   $this->thumbWidth;
            $thumbHeight    =   $height*($this->thumbHeight/$width);
        }
        if($width < $height) {
            $thumbWidth    =   $width*($this->thumbWidth/$height);
            $thumbHeight    =   $this->thumbHeight;
        }
        if($width == $height) {
            $thumbWidth    =   $this->thumbWidth;
            $thumbHeight    =   $this->thumbHeight;
        }
        $thumbImage  =   ImageCreateTrueColor($thumbWidth,$thumbHeight);
        imagecopyresampled($thumbImage,$originalImage,0,0,0,0,$thumbWidth,$thumbHeight,$width,$height);
        $result = imagejpeg($thumbImage,$targetPath,80);
        return $result;
    }
}
?>