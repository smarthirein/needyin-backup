var mysql = require('mysql');
var exports = module.exports = {};



var con_web = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "N@edy1n.C0m_T",
  database: "needyin_phase2_prod_copy",
  debug: false,
  multipleStatements: true
});
module.exports={"chat":con_web};

