FROM docker.algoritma.it/algoritma/workspace:oro6.1-alpine3.22

USER root

ENV PHP_MEMORY_LIMIT=2G
ENV CHROME_BIN=/usr/bin/chromium-browser

RUN /entrypoint.sh

USER algoritma

WORKDIR /application

RUN composer create-project oro/commerce-crm-application . 6.1.7 -n --no-scripts

COPY --chown=algoritma . lib/app

RUN composer config repositories.app '{"type": "path", "url": "./lib/app"}' \
    && composer req algoritma/oro-dictionary-bundle \
    && composer install --no-interaction
