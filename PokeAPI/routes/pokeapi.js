/**
 * Created by vipulkanade on 11/28/16.
 */
var express = require('express');
var parseJson = require('parse-json');
var router = express.Router();

const fs = require('fs');
const escapeJSON = require('escape-json-node');
const http = require('http');

var Pokedex = require('pokedex-promise-v2');
var P = new Pokedex();

var poke_api_url_array = [];
var poke_data = [];

const async = require('async');
const request = require('request');

function httpGet(url, callback) {
    console.log("```````````````````````````````````````");
    console.log(url);
    const options = {
        url :  url
    };
    request(options,
        function(err, res, body) {
            console.log(res);
            console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
            console.log(body);
            callback(err, body);
        }
    );
}

function synchAPICalls (urls) {
    console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~");
    var url = urls.pop();
    console.log(url);
    setTimeout(function(){
        http.get(url, function(res){
            // console.log(res.data);
            // console.log(res.body);
            var chunks = '';
            res.on('data', function(d){
                // console.log(res);
                chunks += d;
            });
            res.on('end',function(){
                //do stuffed with chunked result
                var escaped_json = escapeJSON(chunks);
                escaped_json = JSON.parse(escaped_json);

                // console.log(escaped_json);
                // console.log(escaped_json.weight);
                // console.log(escaped_json.height);
                // console.log(escaped_json.types[0].type.name);
                // console.log(escaped_json.types[1].type.name);
                // console.log(escaped_json.base_experience);
                // console.log(escaped_json.order);

                // console.log({'name': escaped_json.name, 'weight': escaped_json.weight, 'height': escaped_json.height, 'type_slot_0': escaped_json.types[0].type.name, 'type_slot_1': escaped_json.types[1].type.name, 'strength': JSON.parse(escaped_json.base_experience), 'order': escaped_json.order});

                // console.log(escaped_json.types.length);

                if (escaped_json.types.length == 2) {
                    console.log({'name': escaped_json.name, 'weight': escaped_json.weight, 'height': escaped_json.height, 'type_slot_0': escaped_json.types[0].type.name, 'type_slot_1': escaped_json.types[1].type.name, 'strength': JSON.parse(escaped_json.base_experience), 'order': escaped_json.order});

                    poke_data.push({'name': escaped_json.name, 'weight': escaped_json.weight, 'height': escaped_json.height,
                        'type_slot_0': escaped_json.types[0].type.name, 'type_slot_1': escaped_json.types[1].type.name, 'strength': escaped_json.base_experience, 'order': escaped_json.order});
                } else if (escaped_json.types.length == 1) {
                    console.log({'name': escaped_json.name, 'weight': escaped_json.weight, 'height': escaped_json.height, 'type_slot_0': escaped_json.types[0].type.name, 'strength': JSON.parse(escaped_json.base_experience), 'order': escaped_json.order});

                    poke_data.push({'name': escaped_json.name, 'weight': escaped_json.weight, 'height': escaped_json.height,
                        'type_slot_0': escaped_json.types[0].type.name, 'strength': escaped_json.base_experience, 'order': escaped_json.order});
                }

                fs.writeFile("./routes/pokemon_data.json", JSON.stringify(poke_data), "utf8", function (err) {
                    if (err) return console.log(err);
                    console.log('File Write Success');
                });

                if(urls.length){
                    synchAPICalls(urls);
                } else {
                    console.log('all done!');
                    // console.log(JSON.stringify(poke_data));
                    fs.writeFile("./routes/pokemon_data.json", JSON.stringify(poke_data), "utf8", function (err) {
                        if (err) return console.log(err);
                        console.log('File Write Success');
                    });
                }
            })
        })
    }, 750);
}

/* GET PokeAPI listing. */
router.get('/', function(req, res, next) {

    P.getPokemonsList()
        .then(function(response) {

            fs.writeFile( "./routes/poke_api_all.json", JSON.stringify(response), "utf8", function (err) {
                if (err) return console.log(err);
                console.log('File Write Success');
            });

            res.send(response);
        }).catch(function(error) {
        console.log('There was an ERROR: ', error);
    });

});

/* GET PokeAPI listing. */
router.get('/all', function(req, res, next) {

    var obj;

    fs.readFile('./routes/poke_api_all.json', 'utf8', function (err, data) {
        if (err) throw err;

        obj = JSON.parse(data);

        for (var x in obj.results) {
            poke_api_url_array.push(obj.results[x].url);
        }

        synchAPICalls(poke_api_url_array);

        res.send("Success");
    });

    // res.send("Success");
});

module.exports = router;
