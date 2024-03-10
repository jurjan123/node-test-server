
    app.route("/register")
.get((req,res) => {
    res.sendFile(registerPage);
})
.post([
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
        req.flash('errors', errors);
        
        //return res.redirect("/register")
    
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

        req.session.user = userData
          
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


