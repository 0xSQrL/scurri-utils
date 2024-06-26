<?php
namespace Scurri\Utils;

class RandomString{
    /**
     * Generate a random string of given length
     */
    static function make(int $length=64): string{
        $b64str = base64_encode(random_bytes($length));
        $b64str = substr($b64str, 0, $length);
        return $b64str;
    }
}
?>