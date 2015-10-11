<?php

class ContextModel extends CL_Model {
    
    public static function get_free_params($caseId, $modelId) {
        
        $cmd = "java -jar C:\Users\David\Dev\dmtools\apps\decimill-client\dist\decimill-client.jar -a getFreeParams -c $caseId -m $modelId";
        $out = null;
        $res = null;
        
        exec($cmd, $out, $res);
        
        $res = json_decode($out[0]);
        
        return $res;
    }
}

