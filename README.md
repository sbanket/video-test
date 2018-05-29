## Local setup

This project uses [Docker](https://docs.docker.com/install/) 
and [Docker Compose](https://docs.docker.com/compose/install/). 
Ensure you have both installed.

#### Setup steps

**1. .env file deployment**
Copy `.env.dist` file into `.env` file. Update parameters if needed. 
This will prepare env variables required for installation 

**2. Environment setup**
Run `docker-compose up -d` within project's root directory.

This will deploy all necessary containers to run application

**4. Application shutdown**
To shutdown application and deployed environment run `docker-compose down`
within project's root directory

## Run application
After setup is finished your application can be reached from the localhost: 
[http://localhost:8011] - the main application entrypoint.

## Useful scripts
`.phpdocker` directory contains some useful scripts:

**Proxy scripts:**

- `composer.sh` Proxy to `composer` executable, you can call with any valid composer arguments and options