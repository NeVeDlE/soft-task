<?php

namespace App\Helpers;

class FileMetadataHelper
{
    //function names say it all xD
    public static function addMetadata($data, $metadata)
    {
        $metadataJson = json_encode($metadata);
        $metadataLength = str_pad(strlen($metadataJson), 16, '0', STR_PAD_LEFT);
        return $metadataLength . $metadataJson . $data;
    }

    public static function extractMetadata($data)
    {
        $metadataLength = (int)substr($data, 0, 16);
        $metadataJson = substr($data, 16, $metadataLength);
        $metadata = json_decode($metadataJson, true);
        $dataWithoutMetadata = substr($data, 16 + $metadataLength);
        return [$metadata, $dataWithoutMetadata];
    }
}
