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

pool.getConnection(function(err, connection){
    if(err){
        throw err
    } 

    connection.query("SELECT * from users", (err, results) => {
       if(err){
        console.log(err.code)
       }

       const userData = JSON.stringify(results)

       fs.writeFile(path.resolve(__dirname, "server", "api.json"), userData, (err) => {
        if(err){
            console.log(err.code)
        }

        console.log("appended to file")
        connection.release()
    });
   
    }) 
})

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



