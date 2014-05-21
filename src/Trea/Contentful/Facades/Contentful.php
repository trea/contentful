<?php namespace Trea\Contentful\Facades;

use \Illuminate\Support\Facades\Facade;

class Contentful extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'contentful';
    }
}
