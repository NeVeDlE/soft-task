<?php

namespace App\Encryption;

use Illuminate\Support\Facades\Storage;

class AesEncryption extends Encryption
{
    private static $instance = null;

    //private constructs to ensure the singleton is working
    private function __construct($key, $iv = null)
    {
        parent::__construct($key, $iv);
    }

    //this method makes there can be only 1 instance for this class
    public static function getInstance($key, $iv = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($key, $iv);
        }
        return self::$instance;
    }

    //this function returns the full encrypted data
    public function encrypt($data)
    {

        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $this->iv);
        $encryptedData = $this->iv . $encryptedData;
        return $encryptedData;
    }

    //this function returns the full decrypted data
    public function decrypt($data)
    {
        $iv = substr($data, 0, 16); // Assuming IV is 16 bytes for AES
        $encryptedData = substr($data, 16);
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $this->key, 0, $iv);
        return $decryptedData;
    }
}
