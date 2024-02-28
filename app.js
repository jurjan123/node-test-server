const http = require("http")
const fs = require("fs")
const path = require("path")
const express = require("express")
const bodyparser = require("body-parser")
const {body, validationResult} = require("express-validator")
const app = new express();
const mysql = require("./mysql")
const loginPage = path.resolve(__dirname, "views", "auth", "login.html")
const registerPage = path.resolve(__dirname, "views", "auth", "register.html")
app.use(express.static(__dirname + "/public"))

app.use(bodyparser.urlencoded({
    extended: false
}))

app.use(bodyparser.json());


const stream = fs.createReadStream(path.resolve(__dirname, "views", "index.html"))

app.get("/", (req,res) => {
    //res.sendfile(__dirname)
   
})

app.get("/register", (req,res) => {
    res.sendFile(registerPage);
})

app.get("/login", (req,res) => {
    res.sendFile(loginPage)
})

app.post('/submit', [
    /*
    body('username').isLength({ min: 5 }).withMessage('Username must be at least 5 characters long'),
    body('email').isEmail().withMessage('Email must be valid'),
    body('password').isLength({ min: 5 }).withMessage('Password must be at least 5 characters long'),
    */
  ], (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }
  
    // Process the data
    res.send('Form data is valid!');
  });

app.get("/api/data", (req,res) => {
    res.json(res.sendFile(path.resolve(__dirname, "api.json")))
})



app.listen(5000, () => {
    console.log("app listening on port: 5000")
})




