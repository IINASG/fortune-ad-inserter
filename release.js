require('dotenv').config();
const zip = require('zip-a-folder').zip;
const fs = require('fs');
const jsonFilename = './api/fortune-ad-inserter.json';
const phpFilename = './src/fortune_ad_inserter.php';
const json = JSON.parse(fs.readFileSync(jsonFilename, 'utf8'));
const php = fs.readFileSync(phpFilename, 'utf8') ;

if( ! process.env.NEW_VERSION ) {
  throw new Error('env NEW_VERSION not set')
}

json.new_version = process.env.NEW_VERSION ;
json.last_updated = process.env.LAST_UPDATE || new Date().toLocaleDateString('sv-SE') ;
json.changelog = process.env.CHANGELOG ;

fs.writeFileSync( jsonFilename , JSON.stringify(json));
fs.writeFileSync( phpFilename , php.replace(/Version:.*[0-9]+\.[0-9]+\.[0-9]+/, 'Version: ' + json.new_version ) );


(async function (){
  await zip('src','fortune-ad-inserter.zip');
})();
