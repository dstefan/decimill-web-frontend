<?php

class DecimillClient {

    public static function call() {
        
        $args = implode(" ", func_get_args());
        
        $config = get_config();
        $clientPath = $config['decimill_client_path'];
        $configPath = $config['decimill_client_config'];
        
//        echo "java -jar $clientPath $configPath $args";
//        exit();
        
        exec("java -jar $clientPath $configPath $args", $out, $ret);
        
//        var_dump($ret);
//        print_r($out);
//        exit();
        
        if (count($out) > 0) {
            return json_decode($out[0]);
        }
        return FALSE;
    }

}
