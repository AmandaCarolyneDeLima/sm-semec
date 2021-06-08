FROM php:7.4-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    --no-install-recommends apt-utils \
    libzip-dev \
    libonig-dev \
    default-mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    sudo \
    ssh \
    procps \
    rsync

RUN pecl install xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-enable xdebug

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# NODEJS NVM ---------------------------------------------------------------------------------------------------------------
ARG NODE_VERSION=12.16.3
ARG NVM_DIR=/usr/local/nvm

# https://github.com/creationix/nvm#install-script
RUN mkdir $NVM_DIR && curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.35.3/install.sh | bash

# add node and npm to path so the commands are available
ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
ENV PATH $NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

# update npm
RUN npm install -g npm

# confirm installation
RUN node -v
RUN npm -v
# end NODEJS -----------------------------------------------------------------------------------------------------------


# YARN -----------------------------------------------------------------------------------------------------------------
RUN npm install -g yarn@berry
# end YARN -------------------------------------------------------------------------------------------------------------


# Define environment variables
ENV _USER www
ENV HOME /home/${_USER}/
ENV APP /var/www/
ENV VENDOR_PATH /vendor

# ADD an user called www
# --gecos GECOS
#          Set  the  gecos (information about the user) field for the new entry generated.  adduser will
#          not ask for finger information if this option is given
#
# The users of the group staff can install executables in /usr/local/bin and /usr/local/sbin without root privileges
RUN addgroup --gid $GROUP_ID ${_USER}
RUN adduser  --disabled-password --gecos '' --uid $USER_ID --gid $GROUP_ID ${_USER} \
  && usermod -a -G sudo ${_USER} \
  && usermod -a -G staff ${_USER} \
  && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers \
  && echo "${_USER}:${_USER}" | chpasswd


# Configure the main working directory. This is the base
# directory used in any further RUN, COPY, and ENTRYPOINT commands.
RUN mkdir -p $HOME \
  && mkdir -p $APP \
  && mkdir -p $VENDOR_PATH \
  && chown -R ${_USER}:${_USER} $HOME \
  && chown -R ${_USER}:${_USER} $VENDOR_PATH \
  && chown -R ${_USER}:${_USER} $APP

# Copy existing application directory contents
COPY . $APP

# Cache vendor directo
RUN ln -sf /vendor /var/www/vendor

# Change current user to www
USER ${_USER}:${_USER}

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
