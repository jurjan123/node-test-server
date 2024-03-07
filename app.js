const http = require("http")
const fs = require("fs")
const path = require("path")
const express = require("express")
const session = require("express-session")
const flash = require("express-flash")
const sha1 = require("sha1")
const bodyparser = require("body-parser")
const {body, validationResult} = require("express-validator")
const app = new express();
const {pool, connection} = require("./server/mysql")

const homePage = path.resolve(__dirname, "views", "index.html")
const loginPage = path.resolve(__dirname, "views", "auth", "login.html")
const registerPage = path.resolve(__dirname, "views", "auth", "register.html")
const categoryPage = path.resolve(__dirname, "views", "categories", "index.html")
app.use(express.static(__dirname + "/public"))

app.use(session({
    secret: "harrypotter",
    resave: false,
    saveUninitialized: true,
    cookie: {secure: false}
}))

app.use(flash())
app.use(bodyparser.urlencoded({
    extended: false
}))

app.use(bodyparser.json());

app.get("/", (req,res) => {
   res.sendFile(homePage)
})


app.get("/categories", (req,res) => {

    pool.getConnection(function(err, connection){
        if(err){
            throw err
        } 
    
        connection.query("SELECT * from products", (err, results) => {
            console.log(results)
            res.sendFile(categoryPage)
            res.send(results)
            
            connection.release()
        })
    })
    
    
})
   


app.get("/register", (req,res) => {
    res.sendFile(registerPage);
})

app.get("/login", (req,res) => {
    res.sendFile(loginPage)
})

app.use("*", (req,res, next) => {
    if(req.method != "GET"){
        next()
    } else{
        return res.status(404).send("<h1>Resource not found</h1>")
    }
   
})

app.post('/submit', [
    body('first_name').isLength({ min: 5 }).withMessage('first name must be at least 5 characters long'),
    body("last_name").isLength({min: 5}).withMessage("last name must be at least 5 characters long"),
    body("preposition").isLength({min:2}).withMessage("preposition must be at least 2 characters long"),
    body('email').isEmail().normalizeEmail().withMessage('Email must be valid').custom(async email => {
        const user = await new Promise((resolve,reject) => {
            connection.query("SELECT email from users where email = ?", [email], (err,results,fields) => {
                if(err){
                    reject(new Error("something went wrong"))
                } else{
                    resolve(results.length > 0 ? results[0] : null);
                }
            })
        })
        if (user) {
            throw new Error('Email already in use');
        }
    }),
    body('password').isLength({ min: 5 }).withMessage('Password must be at least 5 characters long'),
    body("password_confirmation").custom((value, { req }) => {
        if (value !== req.body.password) {
          throw new Error('Password confirmation does not match password');
        }
        // Indicates the success of this synchronous custom validator
        return true;
      }),

    
    //body("password_confirmation").matches("password").withMessage("repeated password must be the same as password")
  ], (req, res) => {
   
    const errors = validationResult(req);

    if (!errors.isEmpty()) {
        //req.flash('errors', errors);
        
        //return res.redirect("/register")
      //res.status(301).sendFile(registerPage)
      //return res.redirect(registerPage)
      return res.json({ errors: errors.array() });
    } else{
        const jsonData = JSON.stringify(req.body);

        const userData = {
            first_name: req.body.first_name,
            last_name: req.body.last_name,
            preposition: req.body.preposition,
            email: req.body.email,
            password: sha1(req.body.password)
          };
          
        pool.getConnection(function(err, connection){
            connection.query('INSERT INTO users SET ?', userData, (err, results, fields) => {
                if(err){
                    console.log(err)
                }

                connection.release()
            })
        })
      // Write JSON data to api.json file
        fs.writeFile(path.resolve(__dirname, "server", "api.json"), jsonData, (err) => {
            if(err){
                throw err
            }

            console.log("appended to file")
        });
       
        res.redirect("/")
    }
  });

app.get("/api/data", (req,res) => {
    res.json(res.sendFile(path.resolve(__dirname, "server", "api.json")))
})

app.listen(5000, () => {
    console.log("app listening on port: 5000")
})




