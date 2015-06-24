<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caching {

    public function getQueryCache($dirName, $fileName = 'default', $cacheTime = null)
    {
        $cacheTime = $cacheTime * 60;
        $file = APPPATH . 'cache/' . $dirName . '/' . $fileName;
        if($cacheTime == null && file_exists($file)){
            return file_get_contents($file);
        }else{
            if(!file_exists($file) || time() - filemtime($file) >= $cacheTime) {
                return FALSE;
            } else {
                return file_get_contents($file);
            }
        }
    }

    public function cacheQuery($dirName, $fileName = 'default', $data = '')
    {
        $path = APPPATH . 'cache/' . $dirName . '/';
        $file = $path . $fileName;

        if(!file_exists($path)) {
            @mkdir($path);
        }

        $fh = @fopen($file, 'w');

        if($fh) {
            fputs($fh, $data);
            fclose($fh);
        }
    }

    public function getCacheLastUpdate($dirName, $fileName) {

        $file = APPPATH . 'cache/' . $dirName . '/' . $fileName;

        if(!file_exists($file)) {
            return date('Y-m-d H:i:s');
        } else {
            return date('Y-m-d H:i:s', filemtime($file));
        }
    }
    public function deleteCache($dirName, $fileName){
        $file = APPPATH . 'cache/' . $dirName . '/' . $fileName;

        if(file_exists($file)) {
            unlink($file);
        }
    }
}