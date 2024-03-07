const mysql = require("mysql")
const fs = require("fs")
const path = require("path")

const connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "leasesystem"
})

const pool = mysql.createPool({
    connectionLimit: 10,
    host: "localhost",
    user: "root",
    password: "",
    database: "leasesystem"
})

/*pool.getConnection(function(err, connection){
    if(err){
        throw err
    } 

    connection.query("SELECT * from products", (err, results) => {
        //console.log(results)
        console.log(pool.host)
        connection.destroy()
        console.log("test")
    })
})

pool.end(() => {
    console.log("pool is closed")
} )*/


module.exports = {pool,connection}



