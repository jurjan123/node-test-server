const http = require("http")
const fs = require("fs")
const path = require("path")


server = http.createServer((req,res) => {
    const url = req.url
    
    if(url == "/about"){
        fs.readFile(path.resolve(__dirname, "test.txt"), (err, data) => {
            if(err){
                console.log(err)
                return
            } else{
                res.write(data)
            }
        })

        res.write("this is the about page")
    }
    else if(url == "/register"){
        res.write(registerPage)
    }
    else if(url == "/data"){
        res.statusCode = 301
        res.write(registerData)
    }

    res.end("end of content")
})


server.listen(5000, () => {
    console.log("server running on port:5000")
})

server.on("error", (error) => {
    console.error(`An error occurred: ${error}`)
})

server.on("close", () => {
    console.log("server closed")
})

