<?php

namespace MagedAhmad\Insular\Helpers;

use Illuminate\Support\Str as LaravelStr;

class Str
{
    public static function studly(string $value): string
    {
        return LaravelStr::studly($value);
    }

    public static function snake(string $value, string $delimiter = '_'): string
    {
        return LaravelStr::snake($value, $delimiter);
    }

    public static function realName(string $name, string $pattern = '//'): string
    {
        $name = preg_replace($pattern, '', $name);

        return implode(' ', preg_split('/(?=[A-Z])/', $name, -1, PREG_SPLIT_NO_EMPTY));
    }

    public static function feature(string $name): string
    {
        $parts = array_map(static function($part) { return self::studly($part); }, explode("/", $name));
        $feature  = self::studly(preg_replace('/Feature(\.php)?$/', '', array_pop($parts)).'Feature');

        $parts[] = $feature;

        return join(DS, $parts);
    }

    public static function job(string $name): string
    {
        return self::studly(preg_replace('/Job(\.php)?$/', '', $name).'Job');
    }

    public static function operation(string $name): string
    {
        return self::studly(preg_replace('/Operation(\.php)?$/', '', $name).'Operation');
    }

    public static function module(string $name): string
    {
        return self::studly($name);
    }

    public static function type(string $name): string
    {
        return self::studly(preg_replace('/Type(\.php)?$/', '', $name).'Type');
    }

    public static function resource(string $name): string
    {
        return self::studly(preg_replace('/Resource(\.php)?$/', '', $name).'Resource');
    }

    public static function request(string $name): string
    {
        return self::studly(preg_replace('/Request(\.php)?$/', '', $name).'Request');
    }

    public static function controller(string $name): string
    {
        return self::studly(preg_replace('/Controller(\.php)?$/', '', $name).'Controller');
    }

    public static function model(string $name): string
    {
        return self::studly($name);
    }
}
