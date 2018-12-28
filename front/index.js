const http = require('http');
const fs = require('fs');

http.createServer((req, res) => {
    fs.readFile('index.html', (err, data) => {
        res.statusCode = 200;
        res.setHeader('Content-Type', 'text/html');
        res.setHeader('Content-Length', data.length);
        res.end(data);
    });
}).listen(3140, '127.0.0.1');