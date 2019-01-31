# Tic Tac Toe + DDD + Symfony

This repository contains an example of how to use or integrate DDD with a working PHP framework (Symfony).
Using a simple Tic tac toe game as reference.

# How to run

1. Clone repository
2. Install dependencies `composer install`
3. Configure `.env` file with a new database connection.
`DATABASE_URL=mysql://user:password@127.0.0.1:3306/tic-tac-toe`
4. Import database schema, execute `schema.sql` from `database` directory. 
2. Run `game:start`
3. Follow game instructions.

# Available commands

1. `user:create <username>` : Creates an user
2. `user:delete <username>` : Deletes an user
3. `game:start` : Starts a tic tac toe game
4. `scores:show` : Shows leaderboards

# Warning

Alpha testing only.

# Testing

Pending to integrate.
