<?php
namespace App\Business;

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\UTCDatetime;

class SerializeUtil
{
    /**
     * Check value to find if it was serialized.
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     *
     * @param string $data   Value to check to see if was serialized.
     * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
     * @return bool False if not serialized and true if it was.
     */
    public static function is_serialized( $data) {
        // if it isn't a string, it isn't serialized.
        if ( ! is_string( $data ) ) {
            return false;
        }
        //this piece of code is for checking boolean value. In case of boolean, unserialize return false - which causing wrong.
        //So, this trick is used to pass by that case.
        if(strlen($data) ===4 && preg_match('/b:\d;/', $data)) {
            return true;
        }
        if (@unserialize($data) === false)
        {
            return false;
        }
        return true;
    }

    /**
     * @param $object
     * @return string
     */
    public static function serialize($object) {
        if(is_array($object)) {
            return self::serializeArray($object);
        }
        if($object instanceof UTCDatetime) {
            return $object->toDateTime()->format('Y-m-d H:i:s');
        }
        if($object instanceof ObjectID) {
            return serialize((string) $object);
        }
        return serialize($object);
    }

    /**
     * @param $array
     * @return string
     */
    public static function serializeArray($array) {
        $dataToSerialize = [];
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $dataToSerialize[$key] = self::serializeArray($value);
            }
            else if($value instanceof UTCDatetime) {
                $dataToSerialize[$key] =  $value->toDateTime()->format('Y-m-d H:i:s');
            }
            else if($value instanceof ObjectID) {
                $dataToSerialize[$key] = (string) $value;
            }
            else {
                $dataToSerialize[$key] = $value;
            }
        }
        return serialize($dataToSerialize);
    }

    /**
     * @param $serialized
     * @return array|mixed
     */
    public static function unserialize($serialized)
    {
        if(is_array($serialized)) {
            return self::unserializeArray($serialized);
        }
        else if(is_string($serialized) && self::is_serialized($serialized)) {
            $unserializedData = unserialize($serialized);
            if(is_array($unserializedData)) {
                return self::unserializeArray($unserializedData);
            } else if(self::is_serialized($unserializedData)) {
                return self::unserialize($unserializedData);
            }
            return $unserializedData;
        }
        return $serialized;
    }

    /**
     * @param array $arrayData
     * @return array
     */
    public static function unserializeArray(array $arrayData) {
        $arrayAfterUnserializing = [];
        foreach($arrayData as $key => $arrayElement) {
            $unserializedElement = self::unserialize($arrayElement);
            if($key === '_id' && ctype_xdigit($unserializedElement) && strlen($unserializedElement) == 24) {
                $arrayAfterUnserializing[$key] = new ObjectID($unserializedElement);
            } else {
                $arrayAfterUnserializing[$key] = $unserializedElement;
            }
        }
        return $arrayAfterUnserializing;
    }
}