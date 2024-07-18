<?php
include 'config.php';
?>
<!DOCTYPOE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css?<?php echo time();?>">
    <script src="app.js?<?php echo time();?>" type="text/javascript"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
    <link href="https://cdn.bootcdn.net/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <title><?php echo $config['AppName'];?></title>
</head>
<body>
    <div class="box topbar fadeIn">
        <i class="<?php echo $config['fa-icon']['terminal'];?> icon"></i><?php echo $config['AppName'];?>
    </div>
    <div class="boxFrame box" id="serverList">
        <div class="title"><i class="<?php echo $config['fa-icon']['server'];?> icon"></i>服务器列表</div>
    </div>
    <!--尊重原作者,禁止删除!-->
    <div class="boxFrame box">
        &copy; <a href="https://light.gs">LT 轻雨科技</a> 版权所有
    </div>
</body>
</html>
