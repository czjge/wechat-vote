<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-06-28
 * Time: 17:00
 */
namespace App\Extensions;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Processor\WebProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Formatter\LineFormatter;
use Request;
use Config;
use Auth;

/**
 * UserLog
 *
 * Custom monolog logger for CMS user : DEBUG,INFO,NOTICE,WARNING,ERROR,CRITICAL,ALERT,EMERGENCY
 *
 * @author
 */
class SelfLog {

    /**
     * write
     * @return void
     */
    public static function debug($log)
    {
        self::write($log,Logger::DEBUG);
    }
    public static function info($log)
    {
        self::write($log,Logger::INFO);
    }
    public static function notice($log)
    {
        self::write($log,Logger::NOTICE);
    }
    public static function warning($log)
    {
        self::write($log,Logger::WARNING);
    }
    public static function error($log)
    {
        self::write($log,Logger::ERROR);
    }
    public static function critical($log)
    {
        self::write($log,Logger::CRITICAL);
    }
    public static function alert($log)
    {
        self::write($log,Logger::ALERT);
    }
    public static function emergency($log)
    {
        self::write($log,Logger::EMERGENCY);
    }

    private static function write($logtext='',$level=Logger::INFO)
    {
        if ("yes"==Config::get('app.selflog'))
        {
            $log = new Logger('userlog');
            // handler init, making days separated logs
            $handler = new RotatingFileHandler(Config::get('app.selflog_path'), 0, $level);
            // formatter, ordering log rows
            $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message% %extra% %context%\n"));
            // add handler to the logger
            $log->pushHandler($handler);
            // processor, adding URI, IP address etc. to the log
            $log->pushProcessor(new WebProcessor);
            // processor, memory usage
            $log->pushProcessor(new MemoryUsageProcessor);

            $log->addInfo($logtext);
        }
    }
}