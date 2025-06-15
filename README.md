# Laravel Docker Example

This repository contains a basic Laravel 12 application configured for Docker.

## Usage

1. Build the containers:

```bash
docker-compose build
```

2. Start the application:

```bash
docker-compose up -d
```

Visit http://localhost:8000 to access the app.
The `web` service runs Nginx in front of the PHP-FPM container.

PrimeVue 4 and PrimeIcons are included via Vite. See `resources/js/app.js` for an example setup.

To stop and remove the containers:

```bash
docker-compose down
```

