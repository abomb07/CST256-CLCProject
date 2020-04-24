<?php
/*
 * CLC Project version 7.0
 * ILoggerService version 7.0
 * Adam Bender and Jim Nguyen
 * April 17, 2020
 * ILoggerService handles logging service provider
 */
namespace App\Services\Utility;

interface ILoggerService
{
    public function debug($message, $data=array());
    public function info($message, $data=array());
    public function warning($message, $data=array());
    public function error($message, $data=array());
}

