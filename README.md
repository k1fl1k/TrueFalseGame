# TrueFalseGame

**TrueFalseGame** is a web application that allows users to create and play simple "True or False" games. The game author defines a list of questions with "true" or "false" answers, and players attempt to answer them correctly.

## Features

- Game page with author info, description, and image
- Start game button
- Comments section for each game
- User authentication
- Answer checking and score calculation

## Installation

1. Clone the repository:

```bash
git clone https://github.com/k1fl1k/TrueFalseGame.git
cd TrueFalseGame
```

Install dependencies:

```bash
composer install
npm install && npm run dev
```
Create the .env file:

```bash
cp .env.example .env
php artisan key:generate
```
Configure your database connection in .env, then run migrations:

```bash
php artisan migrate
```
Start the development server:

```bash
php artisan serve
```

## Technologies Used

- PHP 8+
- Laravel
- Livewire / Volt
- Tailwind CSS
- PostgreSQL
- ULID for identifiers

## Roadmap

- Add player rankings
- Support for multiple rounds
- Multiplayer mode
- Game editing by the author

## Author

**k1fl1k**  
[GitHub Profile](https://github.com/k1fl1k)
