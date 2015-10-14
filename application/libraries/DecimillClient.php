<?php

class DecimillClient {

    private $curl = NULL;

    public function __construct() {
        $this->curl = curl_init();
    }

    public function compileModel($id, $namespace, $text) {

        $request = [
            'action' => 'model',
            'model' => [
                'id' => $id,
                'namespace' => $namespace,
                'text' => $text
            ]
        ];
        
        $requestBody = json_encode($request);

        curl_setopt($this->curl, CURLOPT_URL, 'http://localhost/compile');
        curl_setopt($this->curl, CURLOPT_PORT, 88);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, 88);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Content-Type: text/plain',
            'Content-Length: ' . strlen($requestBody)
        ]);
        
        $rawResponse = curl_exec($this->curl);
        $response = json_decode($rawResponse, TRUE);
        
        curl_close($this->curl);
        
        if ($response['status'] == 'OK') {
            echo $response['body'] . '<br />';
            foreach ($response['paths'] AS $path) {
                echo '<img src="http://localhost:88' . $path . '" />';
            }
        } else {
            echo "Model must be broken!";
        }
    }

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
