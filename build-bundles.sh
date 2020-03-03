#This script will build latest REACT production and development bundles
#Meant to be run from composer post-install-cm and post-update-cmd
#!/bin/bash
OLD_PWD=$PWD
SCRIPT=`realpath $0`
SCRIPTPATH=`dirname $SCRIPT`
#Add path to vendor/bin/ directory, where npm and node located. it should allready be there, if we run from composer, but, just in case...
export PATH="$PATH:$SCRIPTPATH/../../bin"

cd $SCRIPTPATH

#Build development bundle.
./node_modules/.bin/browserify ./build-react-bundle.js > ./lib/assets/react-bundle.js

#build production bundle.
./node_modules/.bin/browserify  ./build-react-bundle.js -g [ envify --NODE_ENV production ] -g uglifyify | ./node_modules/.bin/terser --compress --mangle > ./lib/assets/react-bundle.min.js
#Going back where we are at launch
cd $PWD