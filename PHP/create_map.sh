cd ../MAPS/$2
if [ ! -d 'gif' ]; then
    mkdir gif
    chmod 777 gif
fi
grads -pcbx 'run script.gs'
cd gif
ffmpeg -framerate $1 -y -i out%01d.png  output.gif 
rm -r ./*.png
cd ../../../PHP
