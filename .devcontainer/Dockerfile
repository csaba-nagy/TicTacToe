ARG VARIANT="8.0-apache-bullseye"
FROM mcr.microsoft.com/vscode/devcontainers/php:0-${VARIANT}

ARG NODE_VERSION="none"
RUN if [ "${NODE_VERSION}" != "none" ]; then su vscode -c "umask 0002 && . /usr/local/share/nvm/nvm.sh && nvm install ${NODE_VERSION} 2>&1"; fi

ARG XDEBUG_LOG_LEVEL=0
RUN echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}" >>/usr/local/etc/php/conf.d/xdebug.ini
