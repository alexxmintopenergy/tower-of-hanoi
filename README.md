# Tower of Hanoi API

This project implements a simple HTTP API for playing the Tower of Hanoi game.

## Requirements

- **PHP**: ^8.3
- **Laravel**: ^11.9

## Setup

1. Clone the repository

HTTPS: `https://github.com/alexxmintopenergy/tower-of-hanoi.git` 

or

SSH: `git@github.com:alexxmintopenergy/tower-of-hanoi.git`

2. Install dependencies:
   ```
   composer install
   ```
3. Copy `.env.example` to `.env` and configure as needed

4. Generate application key:
   ```
   php artisan key:generate
   ```
5. Start the server:
   ```
   php artisan serve
   ```

## API Endpoints

- **GET /api/state** - Get the current state of the game
- **POST /api/move/{from}/{to}** - Make a move
- **POST /api/reset** - Reset the game to its initial state

## API Examples

### Get Game State

`curl -X GET http://127.0.0.1:8000/api/state`

### Make a Move

`curl -X POST http://127.0.0.1:8000/api/move/0/1`

### Reset the Game

`curl -X POST http://127.0.0.1:8000/api/reset
`

## Code Quality Tools

### Laravel Pint

```
composer pint
```

### PHPStan

```
composer phpstan
```

### Psalm

`vendor/bin/psalm --init`

`vendor/bin/psalm`
