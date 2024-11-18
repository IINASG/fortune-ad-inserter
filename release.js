require('dotenv').config();
const zip = require('zip-a-folder').zip;
const fs = require('fs');
const marked = require('marked');
const jsonFilename = './api/fortune-ad-inserter.json';
const phpFilename = './src/fortune_ad_inserter.php';
const json = JSON.parse(fs.readFileSync(jsonFilename, 'utf8'));
const php = fs.readFileSync(phpFilename, 'utf8') ;
let downloadUrl = 'https://github.com/IINASG/fortune-ad-inserter/releases/download/_new_version_/fortune-ad-inserter.zip';
let changelog = fs.readFileSync('./CHANGELOG.md', 'utf8')
                            .replace(/### \[[0-9]+\.[0-9]+\.[0-9]+].*[\r\n]+/,'')
                            .replaceAll(/ \(\[[0-9a-f]{7}].+\)\)/gi,'');

if( ! process.env.NEW_VERSION ) {
  throw new Error('env NEW_VERSION not set')
}

json.new_version = process.env.NEW_VERSION ;
json.download_url = downloadUrl.replace('_new_version_',process.env.NEW_VERSION);
json.last_updated = process.env.LAST_UPDATE || new Date().toLocaleDateString('sv-SE') ;
json.changelog = marked.parse(changelog);

fs.writeFileSync( jsonFilename , JSON.stringify(json));
fs.writeFileSync( phpFilename , php.replace(/Version:.*[0-9]+\.[0-9]+\.[0-9]+/, 'Version: ' + json.new_version ) );


(async function (){
  await zip('src','fortune-ad-inserter.zip');
})();
