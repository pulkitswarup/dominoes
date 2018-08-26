## Dominoes Game (Programming Exercise)

Dominoes is a family of games played with rectangular tiles. Each tile is divided into two square ends. Each end is marked with a number (one to
six) of spots or is blank. There are 28 tiles, one for each combination of spots and blanks (see image).

The program allows two players to play Dominoes against each other:

- The 28 tiles are shuffled face down and form the stock. Each player draws seven tiles.
- Pick a random tile to start the line of play.
- The players alternately extend the line of play with one tile at one of its two ends;
- A tile may only be placed next to another tile, if their respective values on the
connecting ends are identical.
- If a player is unable to place a valid tile, they must keep on pulling tiles from the stock
until they can.
- The game ends when one player wins by playing their last tile.

Please note: It is not an interactive application. The code just follows the above rules.

### Requirements
- php >= 7.1
- composer >= 1.6
- git >= 2.x (Used to clone the code from the repository)

### Installation
#### Cloning the repository
```bash
$ git clone https://github.com/pulkitswarup/dominoes.git
```
#### Setting up the dependencies (Optional)
```bash
$ composer install
```

#### Play the game
```bash
$ cd dominoes
$ composer game
```

### Testing
The tests can be run using the following command:
```bash
$ composer test
```

Alternatively, (`phpunit`) can also be run directly inside the code directory.
```bash
$ ./vendor/bin/phpunit
```

### Known Issues/Assumptions
- The code can atmost be played with atmost 3 players
- Since the original statement mentioned nothing about how to handle the code in case of a draw. The game doesn't declares a winner rather marks it as a draw
- Although, the code is binded with concrete implementations in most of the places it can easily be replaced to implement `Dependency Inversion Principle`
