# Atacames

A website about Atacames, the beach town on the Pacific coast of Esmeraldas, Ecuador, with a large
webcam image on the home page.

Live: https://atacames.elkuku.dev

Built from the [Symfony Playground "two"](https://github.com/elkuku/symfony-playground-two) template:
Symfony 8, PostgreSQL in Docker, Bootstrap, social login in `prod`, a form login in `dev`.

## Installation

```shell
bin/install
```

It needs Composer, the [Symfony CLI](https://symfony.com/download) and Docker with Compose v2.

```shell
bin/start
bin/stop
```

## Webcam

The home page shows the image at `WEBCAM_IMAGE_URL`. Set it in `.env.local` (on the server too);
while it is empty, the page shows a placeholder of the same size (16:9, full width).

```dotenv
WEBCAM_IMAGE_URL=https://example.com/webcam/current.jpg
```

## Deployment

The site runs on Plesk at `atacames.elkuku.dev` (document root `public`), deployed by pushing to the
Plesk git remote; `bin/deploy` runs on the server after each pull. Create `.env.local` on the server
before the first deploy (`APP_ENV=prod`, `APP_SECRET`, `DATABASE_URL`, `DEFAULT_URI`, the OAuth keys,
`WEBCAM_IMAGE_URL`), and `bin/deploy.env` if Plesk's PHP and Composer are not on the `PATH`:

```shell
PHP_BIN=/opt/plesk/php/8.5/bin/php
COMPOSER_BIN=/usr/lib/plesk-9.0/composer.phar
```

## Testing

```shell
make tests
```
