const http = require("http")
const fs = require("fs")
const path = require("path")
const express = require("express")
const bodyparser = require("body-parser")
const app = new express();

app.use(express.static(__dirname + "/public"))

app.use(bodyparser.urlencoded({
    extended: false
}))

app.use(bodyparser.json());


app.get("/test", (req,res) => {
    res.end("it works")
})

app.get("/register", (req,res) => {
    res.sendFile(path.resolve(__dirname, "test.html"));
    
})

app.post('/', function(req,res){
    var first_name = req.body.first_name;
    var preposition = req.body.preposition
    var last_name = req.body.last_name
    var email = req.body.email
    var password = req.body.password
    var htmlData = [
        first_name,
        last_name,
        preposition,
        email,
        password
    ]

    fs.createWriteStream(path.resolve(__dirname, "api.js"), htmlData)
    res.send(htmlData);
    console.log(htmlData);
});

app.get("/api/data", (req,res) => {
    res.json(res.sendFile(path.resolve(__dirname, "api.json")))
})



app.listen(5000, () => {
    console.log("app listening on port: 5000")
})




