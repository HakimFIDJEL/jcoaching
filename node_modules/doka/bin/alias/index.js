var path = require('path')

var src = path.resolve(__dirname,'../../src')

var alias = str=>path.join(src,str)

module.exports = {
    'index':alias('./index')
}