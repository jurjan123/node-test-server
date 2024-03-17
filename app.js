const http = require("http")
const fs = require("fs")
const path = require("path")
const express = require("express")
const session = require("express-session")
const flash = require("express-flash")
const bcrypt = require("bcrypt")
const bodyparser = require("body-parser")
const {body, validationResult} = require("express-validator")
const app = new express();
const {pool, connection, userData} = require("./server/mysql")
const process = require("process")

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

app.use((req,res,next) => {
  console.log("user ip is " + req.hostname)
  next()
})

app.get("/api/users", ((req,res) => {
  connection.query("SELECT * from users", (err, results) => {
    if(err){
     console.log(err)
    }

    res.json(results)
    
 });
  
}))

app.get("/api/users/:uservalue", ((req,res) => {
  let searchTerm = req.params.uservalue

    // To prevent SQL injection, use placeholder '?' for parameters in your query
    let sqlquery = "SELECT * FROM users WHERE first_name LIKE" + " '%" + searchTerm + "%' " + " OR preposition LIKE" + " '%" + searchTerm + "%'" + " OR last_name LIKE" + " '%" + searchTerm + "%'" + " OR email LIKE" + " '%" + searchTerm + "%'"  + " OR phone_number LIKE" + " '%" + searchTerm + "%'" ;

    // '%' symbols are wildcards in SQL LIKE queries, surrounding the search term

    pool.query(sqlquery, (err, results) => {
        if (err) {
            // Handle the error appropriately
            console.log(err)
        } else {
            // Send the results back to the client
            res.json(results);
        }
    });
}))

app.get("/test/:specificvalue", ((req,res) => {
  let specificvalue = req.params.specificvalue
  let variable = specificvalue.split("=")
  console.log(variable[0])

  //let sqlquery = "SELECT * FROM users WHERE " + LIKE" + " '%" + specificvalue + "%' "
  
 // connection.query()

}))

app.use(bodyparser.json());


app.get("/", (req,res) => {
   res.sendFile(homePage)
   //res.send(req.session.user)
})

app.get("/session", ((req,res) => {
  res.send(req.session)
}))

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
   
app.get("/login", (req,res) => {
    res.sendFile(loginPage)
})

app.route('/login')
  .get((req, res) => {
    res.sendFile(loginPage)
  })
  app.post('/login', [
    body('email').isEmail().withMessage('Enter a valid email address'),
    body('password').notEmpty().withMessage('Password is required')
  ], (req, res) => {
    const errors = validationResult(req);
    if (!errors.isEmpty()) {
      return res.status(400).json({ errors: errors.array() });
    }
  
    const { email, password } = req.body;
  
    pool.query('SELECT * FROM users WHERE email = ?', [email], async (err, results) => {
      if (err) {
        return res.status(500).send('Database error');
      }
  
      if (results.length === 0) {
        return res.status(401).send('No user found with that email address');
      }
  
      const user = results[0];
      const passwordMatch = await bcrypt.compare(password, user.password);
  
      if (!passwordMatch) {
        return res.status(401).send('Incorrect password');
      }

      req.session.regenerate(function(err){
        if(err){
          console.log(err)
        }

        var hour = 3600000
        req.session.cookie.expires = new Date(Date.now() + hour)
        req.session.cookie.maxAge = hour
        req.session.user = user
      })

      req.session.save(function(err){
        if(err){
          console.log(err)
        }
        res.redirect('/');
      })
      // Redirect to a profile or another internal page
    });

    
  });

  app.get("/register", (req,res) => {
    res.sendFile(registerPage);
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
       
        return true;
      }),
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
        const saltRounds = 10;
        const hashedPassword = bcrypt.hashSync(req.body.password, saltRounds);
        
        const userData = {
            first_name: req.body.first_name,
            last_name: req.body.last_name,
            preposition: req.body.preposition,
            email: req.body.email,
            password: hashedPassword
        }

        pool.getConnection(function(err, connection){
            connection.query('INSERT INTO users SET ?', userData, (err, results, fields) => {
                if(err){
                    console.log(err)
                }

                
      req.session.regenerate(function(err){
        if(err){
          console.log(err)
        }

        var hour = 3600000
        req.session.cookie.expires = new Date(Date.now() + hour)
        req.session.cookie.maxAge = hour
        req.session.user = userData
      })

      req.session.save(function(err){
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

      })

        
    }
  });


app.get("/userdata", ((req,res) => {
  
}))

app.get("/logout",  ((req,res) => {
  req.session.destroy((err) => {
    if(err){
      console.log(err)
    }
  })

  res.clearCookie()

  res.redirect("/")

}))

app.use("*", (req,res) => {
    return res.status(404).send("<h1>Resource not found</h1>")
})

app.use((err,req,res,next) => {
  if(err){
    res.status(500).send("err: " + err)
  }
})

app.listen(5000, () => {
    console.log("app listening on port: 5000")
})

