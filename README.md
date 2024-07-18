# LightStatusMonitor
> 一个搭建简单的Monitor系统

目前仅支持Linux的API (监听节点,面板支持Win以及Linux)
# 搭建方法
1. 修改`monitor.json`,修改为
```
{
    "$设备ID": {
        "Name": $设备名,
        "Device": $设备机型
    }
}
```
2. 修改`/api/status/id.json`,修改为
```
{
    "$设备ID": $API地址
}
```
> 本面板支持多设备监听!
