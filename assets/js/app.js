// import app js
import hello from '@js/app/hello.js'
import { helloEN, helloFR } from '@js/app/hello_world.js'

const $ = require('jquery')

require('@js/lib/bootstrap')

// code js
hello('hello ')
helloEN('hello all people')
helloFR('bonjour à tous')

const message = 'hello world'
hello(message)

const [b, , c] = [1, 2, 4, 5]
console.log(b)
console.log(c)

$('p').css('background', 'rgb(52, 58, 64)')
