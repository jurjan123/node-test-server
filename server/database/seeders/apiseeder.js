const fs = require("fs")
const {pool, connection} = require("../../mysql")

pool.getConnection((err, connection) => {

    connection.query("se")
})