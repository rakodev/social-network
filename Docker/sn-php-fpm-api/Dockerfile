FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.2-mysql php-redis php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Yarn
#RUN curl -sL https://deb.nodesource.com/setup_10.x | -E bash -  \ # Nodejs
#    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -  \ # Yarn
#    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list  \ # Yarn
#    && apt-get -y install nodejs build-essential yarn