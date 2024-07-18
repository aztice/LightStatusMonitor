<?php
$json = json_decode(file_get_contents('id.json'),true);
if(isset($json[$_GET['deviceId']])){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $json[$_GET['deviceId']]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        $json=array(
            'status'=>'offline',
            'mem'=>'0MB',
            'total_mem'=>'0MB',
            'tx'=>'0MB',
            'rx'=>'0MB'
            );
        echo json_encode($json);
        exit;
    }
    curl_close($ch);
    echo $response;
}
else{
    $json=array(
        'status'=>'offline',
        'mem'=>'0MB',
        'total_mem'=>'0MB',
        'tx'=>'0MB',
        'rx'=>'0MB'
        );
    echo json_encode($json);
}
