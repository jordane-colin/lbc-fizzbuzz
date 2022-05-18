# LeBonCoin - Technical Test (FizzBuzz)

This project is running with Lumen, a fast PHP micro-framework, with a mongoDB database. Swagger is used to get a proper API platform (with OpenApi spec)

## Installation

Install and use [docker](https://docs.docker.com/get-docker/)

## Usage with Docker & docker-compose

### Install & build
```bash
make start
```

### Launch tests
```bash
make launch-tests
```
should return
```bash

........                                                            8 / 8 (100%)

OK (8 tests, 17 assertions)
```

## Usage with Swagger interface
Launch web interface http://localhost:8000/api/documentation

![Swagger](storage/static/swagger.png?raw=true "Interface")

## Direct usage
Generate a fizzbuzz string for 3 (with string Michael), 5 (with string Scott) (and both), with limit 100 : 
###[Generate MichaelScott](http://localhost:8000/generate_fizzbuzz?int1=3&int2=5&limit=100&str1=Michael&str2=Scott)

Get the most used request for the fizzbuzz generation call:
###[Most call request](http://localhost:8000/get_most_called_request)

## Important files and directories
**Application** files are present in **app** directory.

**Database** directory contains essentially the migration to create the _**_stats_**_ table in database.

**Routes/web.php** contains all (2) routes.

**Tests** contains all test for the application.
