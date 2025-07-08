<?php

class StringUtils {

    public static function snakeToCamelCase($string) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}