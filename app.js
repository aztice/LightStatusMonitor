function fetchJSONFile(path, callback) {
    var xhr = new XMLHttpRequest();
    xhr.overrideMimeType("application/json");
    xhr.open('GET', path, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            callback(xhr.responseText);
        }
    };
    xhr.send(null);
}

let createdDevices = {};
function status(deviceId, name, device) {
    fetch(`./api/status/?deviceId=${deviceId}`)
        .then(response => response.json())
        .then(data => {
            const { rx, tx, mem, total_mem, status: deviceStatus } = data;
            

            let devicePanel = createdDevices[deviceId];

            if (!devicePanel) {

                devicePanel = document.createElement('div');
                devicePanel.className = 'server';
                devicePanel.setAttribute('deviceId', deviceId);


                devicePanel.innerHTML = `
                    <div class="name">${name} (${device})</div>
                    <div class="right">
                        <div class="mem">${mem}/${total_mem}</div>
                        <div class="rx">${rx}</div>
                        <div class="tx">${tx}</div>
                        <div class="${deviceStatus === 'online' ? 'online' : 'offline'}"></div>
                    </div>
                `;


                const serverList = document.getElementById('serverList');
                if (serverList) {
                    serverList.appendChild(devicePanel);
                }


                createdDevices[deviceId] = devicePanel;
            } else {
                devicePanel.querySelector('.mem').textContent = `${mem}/${total_mem}`;
                devicePanel.querySelector('.rx').textContent = rx;
                devicePanel.querySelector('.tx').textContent = tx;
                devicePanel.querySelector('.right > div:last-child').className = deviceStatus === 'online' ? 'online' : 'offline';
            }
            setTimeout(() => {
                status(deviceId, name, device);
            }, 1000);
        })
        .catch(error => {
            console.error('Error fetching device status:', error);
        });
}


document.addEventListener('DOMContentLoaded', function() {
    fetchJSONFile('monitor.json?'+Date.now(), function(response) {
        try {
            var json = JSON.parse(response);
            for (var key in json) {
                if (json.hasOwnProperty(key)) {
                    var item = json[key];
                    var name = item.Name;
                    var device = item.Device;
                    // 调用 status 函数
                    status(key, name, device);
                }
            }
        } catch (e) {
            console.error('解析 JSON 文件时出错：', e.message);
        }
    });
});
