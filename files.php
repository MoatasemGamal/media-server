<?php
define("DS", DIRECTORY_SEPARATOR);
define("MEDIA_PATH", realpath(__DIR__) . DS . 'media' . DS);
define("SERIES_PATH", MEDIA_PATH . 'series' . DS);





class FileMAnager
{
    public static function getAllSeries()
    {
        $seriesDir = scandir(SERIES_PATH);
        $seriesDirectories = [];
        foreach ($seriesDir as $dir) {
            if ($dir === '.' || $dir === '..')
                continue;
            $sereisInfo = explode('-', $dir);
            $dir = SERIES_PATH . $dir;

            if (is_dir($dir))
                $seriesDirectories[] = $sereisInfo;
        }
        return $seriesDirectories;
    }

    public static function getSeriesVideos($series)
    {
        $seriesVideos = [];
        $series = SERIES_PATH . $series;
        if (file_exists($series)) {
            $seriesFiles = scandir($series);
            foreach ($seriesFiles as $file) {
                $path = $series . DS . $file;
                if (!is_dir($path)) {
                    $mime = mime_content_type($path);
                    if (strstr($mime, "video/")) {
                        // this code for video
                        $video = [];
                        $video['name'] = $file;
                        $video['encoded'] = self::encodeNameAsURL($file);
                        $video['duration'] = '00:00';
                        $seriesVideos[] = $video;
                    }
                }
            }
        } else {
            return false;
        }
        return $seriesVideos;
    }


    public static function encodeNameAsURL($name)
    {
        $characters = [
            "char" => [
                " ", "!", '"', "#", "$", "%", "&amp;", "\'", "(", ")", "*", "+", ",", "-", ".", "/", "0", "1", "2", "3", "4", "5", "6", "7", "8", "9", ":", ";", "&lt;", "=", "&gt;", "?", "@", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "[", "\\", "]", "^", "_", "`", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "{", "|", "}", "~"
            ],
            "encoded" => [
                "%20", "%21", "%22", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2D", "%2E", "%2F", "%30", "%31", "%32", "%33", "%34", "%35", "%36", "%37", "%38", "%39", "%3A", "%3B", "%3C", "%3D", "%3E", "%3F", "%40", "%41", "%42", "%43", "%44", "%45", "%46", "%47", "%48", "%49", "%4A", "%4B", "%4C", "%4D", "%4E", "%4F", "%50", "%51", "%52", "%53", "%54", "%55", "%56", "%57", "%58", "%59", "%5A", "%5B", "%5C", "%5D", "%5E", "%5F", "%60", "%61", "%62", "%63", "%64", "%65", "%66", "%67", "%68", "%69", "%6A", "%6B", "%6C", "%6D", "%6E", "%6F", "%70", "%71", "%72", "%73", "%74", "%75", "%76", "%77", "%78", "%79", "%7A", "%7B", "%7C", "%7D", "%7E", "%7F", "%80", "%81", "%82", "%83"
            ]

        ];
        for ($i = 0; $i < 4; $i++) {
            $name = str_replace($characters['char'][$i], $characters['encoded'][$i], $name);
        }

        return $name;
    }
    public static function removeCommonPrefix($str1, $str2)
    {
        $len = strlen($str1);
        $i = 0;

        while ($i < $len && strcmp($str1[$i], $str2[$i]) == 0) {
            $i++;
        }

        return str_replace(substr($str1, $i), "", $str1);
    }
}
