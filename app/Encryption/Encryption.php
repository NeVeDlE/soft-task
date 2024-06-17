<?php

namespace App\Encryption;

abstract class Encryption
{
    protected $key;
    protected $iv;
    public function __construct($key, $iv = null)
    {
        $this->key = $key;
        $this->iv = $iv ?? random_bytes(16); // Default to 16 bytes for AES
    }
    public abstract function encrypt($data);
    public abstract function decrypt($data);

}
