const mysql = require("mysql")

const connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "leasesystem"
})

connection.connect(error => {
    if(error){
        throw error;
    } else{
        console.log("Succesfully connected to the database")
    }
})

connection.end()