<?php
include_once('config.php');

define('REDIS_KEY', 'fs_roar' . dirname($_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]));

class Config_All{
    public static function get_Redis() {
        $redis = new Redis();
        $redis->connect(REDIS_HOST, REDIS_PORT);
        return $redis;
    }

    public static function get_Value($key) {
        $redis = self::get_Redis();
        $value = $redis->get(REDIS_KEY.$key);
        $redis->close();
        return $value;
    }

    public static function set_Value($key, $value) {
        $redis = self::get_Redis();
        $value = $redis->set(REDIS_KEY.$key, $value);
        $redis->close();
        return;
    }

    public static function get_Settings(){
        $settings = self::get_Value("settings");
        if(empty($settings)){
            $settings = [
                'programDescription' => 'Hello',
                'enableComments' => true,
                'enableRoarButton' => true,
                'roarButtonMessage' => 'ROAR ! ! !'
            ];
        } else {
            $settings = json_decode($settings, true);
        }
        return $settings;
    }

    public static function push_message($message) {
        $redis = self::get_Redis();
        $redis->rpush(REDIS_KEY.'msg', json_encode($message));
        $redis->close();
    }
}


class Test_Global{

    private static $G_ALL = [] ;
    public static function get_Count()
    {
        error_log('....'.json_encode(self::$G_ALL));
        $count = self::$G_ALL['count'];
        if(empty($count)){
            $count = 0;
        }
        $count++;
        self::$G_ALL['count'] = $count;

        return $count;
    }

}

?>