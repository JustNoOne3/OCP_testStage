## Start up Commands for Server Configuration ##

## NODE JS INSTALLATION
# apt install zip
# curl -fsSL https://fnm.vercel.app/install | bash
# source ~/.bashrc
# fnm use --install-if-missing 22

## COPY NGINX AND PHP CONFIG FILES ##
cp /home/site/wwwroot/default /etc/nginx/sites-enabled/default
cp /home/site/wwwroot/php.ini /usr/local/etc/php/conf.d/php.ini

## INSTALL PHP LIBRARIES ##
apt-get update --allow-releaseinfo-change && apt-get install -y libfreetype6-dev \
                libjpeg62-turbo-dev \
                libpng-dev \
                libwebp-dev \
        && docker-php-ext-configure gd --with-freetype --with-webp  --with-jpeg
docker-php-ext-install gd

## INSTALL SUPPORT FOR QUEUE
apt-get install -y supervisor 

## COPY SUPERVISOR'S CONFIG FILE ##
cp /home/site/wwwroot/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

## RESTART SERVICES ##
service nginx restart
service supervisor restart

## INSTALL JAVASCRIPT DEPENDENCIES ##
npm ci
npm run build

## MIGRATE DATABASE ##
php artisan migrate

## OPTIMIZE APPLICATION ##
php artisan filament:optimize