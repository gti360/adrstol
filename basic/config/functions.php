<?php
/**
 * Created by PhpStorm.
 * User: gti
 * Date: 04.02.16
 * Time: 21:25
 */

/**
 * Debug function
 * d($var);
 */
function d($var,$caller=null)
{
    if(!isset($caller)){
        $dtrace = debug_backtrace(1);
        $caller = array_shift($dtrace);
    }
    echo '<code>File: '.$caller['file'].' / Line: '.$caller['line'].'</code>';
    echo '<pre>';
    yii\helpers\VarDumper::dump($var, 10, true);
    echo '</pre>';
}

/**
 * Debug function with die() after
 * dd($var);
 */
function dd($var)
{
    $dtrace = debug_backtrace(1);
    $caller = array_shift($dtrace);
    d($var,$caller);
    die();
}

function dv($var, $caller=null)
{
    if(!isset($caller)){
        $dtrace = debug_backtrace(1);
        $caller = array_shift($dtrace);
    }
    echo 'File: '.$caller['file'].' / Line: '.$caller['line'] . "\n";
    var_dump($var);
}