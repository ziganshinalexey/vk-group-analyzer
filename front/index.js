const http = require('http');
const fs = require('fs');
const path = require('path');

http.createServer((req, res) => {
    let url = req.url.split('?')[0];

    if ('/' === url) {
        url = '/index.html';
    }

    const filePath = './dist' + url;

    const extname = path.extname(filePath);
    let contentType = 'text/html';

    switch (extname) {
        case '.js':
            contentType = 'text/javascript';
            break;
        case '.css':
            contentType = 'text/css';
            break;
        case '.json':
            contentType = 'application/json';
            break;
        case '.png':
            contentType = 'image/png';
            break;
        case '.ico':
            contentType = 'image/x-icon';
            break;
    }

    fs.readFile(filePath, (err, data) => {
        if (!err && data) {
            res.writeHead(200, {'Content-Type': contentType});
            res.end(data, 'utf-8');
        }
    });
}).listen(3140, '127.0.0.1');