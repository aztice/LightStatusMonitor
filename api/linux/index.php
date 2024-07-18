<?php
function getSystemMemoryInfo() {
    $meminfo = shell_exec('cat /proc/meminfo');
    $meminfo = explode("\n", $meminfo);

    $total_memory = 0;
    $used_memory = 0;

    foreach ($meminfo as $line) {
        if (strpos($line, 'MemTotal:') !== false) {
            $line = preg_replace("/[^0-9]/", '', $line);
            $total_memory = $line / 1024;
        }
        if (strpos($line, 'MemFree:') !== false) {
            $line = preg_replace("/[^0-9]/", '', $line);
            $free_memory = $line / 1024;
        }
        if (strpos($line, 'Buffers:') !== false) {
            $line = preg_replace("/[^0-9]/", '', $line);
            $buffer_memory = $line / 1024;
        }
        if (strpos($line, 'Cached:') !== false) {
            $line = preg_replace("/[^0-9]/", '', $line);
            $cache_memory = $line / 1024;
        }
    }

    // 计算已用内存：总内存 - 空闲内存 - 缓冲区内存 - 缓存内存
    $used_memory = $total_memory - $free_memory - $buffer_memory - $cache_memory;

    return [
        'total_memory' => round($total_memory, 2),
        'used_memory' => round($used_memory, 2)
    ];
}

$memory_info = getSystemMemoryInfo();
$ifconfig_output = shell_exec('/sbin/ifconfig');

preg_match_all('/([a-zA-Z0-9]+):.*?RX packets (\d+).*?TX packets (\d+)/s', $ifconfig_output, $matches, PREG_SET_ORDER);

$total_rx = 0;
$total_tx = 0;


foreach ($matches as $match) {
    $interface = $match[1];
    $rx_packets = (int) $match[2];
    $tx_packets = (int) $match[3];
    $total_rx += $rx_packets;
    $total_tx += $tx_packets;
}
$total_tx = number_format($total_tx / 1048576,2);
$total_rx = number_format($total_rx / 1048576,2);

$json['rx']="$total_rx MB";
$json['tx']="$total_tx MB";
$json['total_mem']=$memory_info['total_memory'].'MB';
$json['mem']=$memory_info['used_memory'].'MB';
$json['status']='online';
header('Content-Type: application/json');
echo json_encode($json);
?>
