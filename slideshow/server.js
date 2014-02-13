var connect = require('connect')
  , http = require('http')
  , fs   = require('fs')
  , port = process.argv[2] || 3000
  , app = connect()
      .use(connect.static(__dirname))
      .use(function (req, res) {
        fs.readFile(__dirname + req.originalUrl, function (err, buf) {
          if (!err) res.end(buf.toString());
        });
      });

http.createServer(app).listen(port);