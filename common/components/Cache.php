<?php
namespace common\components;

use Yii;
use yii\base\Component;
use Redis;
use yii\base\Event;

class Cache extends Component
{
    const EVENT_UPDATE_PRODUCT = 'updateProduct';
    private static $host;
    private static $port;
    public static $cache;

    public final function __construct(array $config = [])
    {
               self::$host = $config['host'];
        self::$port = $config['port'];

        return self::run();
    }

    private static function run()
    {
        self::$cache = new Redis();
        self::$cache->connect(self::$host, self::$port);

        return self::$cache;
    }
    public  static function updateProduct (ProductEvent $event)
    {
       self::deleteKey($event->productId);

    }
    public static function exists($key)
    {
        if (self::$cache->exists($key)) {
            return true;
        } else {
            return false;
        }
    }

    public static function set($key, $value, $expire = null)
    {
        if (self::$cache->set($key, $value)) {
            if ($expire !== null) {
                self::$cache->expire($key, $expire);
            }

            return true;
        } else {
            return false;
        }
    }

    public static function hmset($key, array $value, $expire = null)
    {
        foreach ($value as $field=>$item){
            self::$cache->hset($key, $field, $item);
        }

        if ($expire !== null) {
            self::$cache->expire($key, $expire);
        }
    }

    public static function hincr($key)
    {
        self::$cache->hincrby($key, 'counter', 1);
    }

    public static function get($key)
    {
        if (self::exists($key)) {
            return self::$cache->get($key);
        } else {
            return false;
        }
    }

    public static function getField($key, $field)
    {
        if (self::exists($key)) {
            return self::$cache->hget($key, $field);
        } else {
            return false;
        }
    }

    public static function getAll($key)
    {
        if (self::exists($key)) {
            return self::$cache->hgetall($key);
        } else {
            return false;
        }
    }

    public static function deleteField($key, $value)
    {
        if (self::exists($key)) {
            if (self::$cache->del($key, $value)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function deleteKey($key)
    {
        if (self::exists($key)) {
            self::$cache->delete($key);
            return true;
        } else {
            return false;
        }
    }

    public static function clearAll()
    {
        self::$cache->flushAll();

        return true;

    }
}