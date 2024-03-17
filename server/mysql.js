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
    connectionLimit: 100,
    host: "localhost",
    user: "root",
    password: "",
    database: "leasesystem"
})


const userData = connection.query("SELECT * from users", (err, results) => {
       if(err){
        console.log(err.code)
       }

       //const data = JSON.stringify(results[0])
    });





/*const userDelete = connection.query("DELETE from users", ((err, results) => {
    if(err){
        console.log(err.code)
    }

    connection.destroy()
}))

/*pool.end(() => {
    console.log("pool is closed")
} )*/


module.exports = {pool,connection}


