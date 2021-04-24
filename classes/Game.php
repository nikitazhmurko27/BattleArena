<?php

    namespace Game;

    include "Player.php";
    use Player\Player;

    class Game
    {
        private $name;

        private $firstPlayer;
        private $secondPlayer;

        function __construct($name)
        {
            $this->name = $name;
            $this->firstPlayer = new Player('Human', 0);
            $this->secondPlayer = new Player('Computer', 35);
        }

        /**
         * @return string
         */
        public function welcomeMessage()
        {
            $result = "**********************************\n";
            $result .= "*                                *\n";
            $result .= "*      Welcome to the            *\n";
            $result .= "*   $this->name         *\n";
            $result .= "*                                *\n";
            $result .= "**********************************\n";
            return $result;
        }

        /**
         * @return string
         * Choose randomly who will start first
         */
        public function startFirst()
        {
            $arr = ['first', 'second'];
            $startFirstIndex = array_rand($arr, 1);
            return $arr[$startFirstIndex];
        }

        /**
         * @param string $startFirst
         * Output the players health after the move
         */
        public function outputPlayersHealth($startFirst)
        {
            sleep(1);
            echo "****** Move Results: *****\n";
            if ($startFirst == 'first') {
                sleep(1);
                echo $this->firstPlayer->getName() . " health=" . $this->firstPlayer->getHealth() . "\n";
                echo $this->secondPlayer->getName() . " health=" . $this->secondPlayer->getHealth() . "\n";
            }else{
                sleep(1);
                echo $this->secondPlayer->getName() . " health=" . $this->secondPlayer->getHealth() . "\n";
                echo $this->firstPlayer->getName() . " health=" . $this->firstPlayer->getHealth() . "\n";
            }
            echo "*********************\n";
        }

        /**
         * @param object $player
         * Output the winners
         */
        public function outputWinner($player)
        {
            echo "*********************\n";
            echo $player->getName() . " - won the battle!\n";
        }

        /**
         * @param int $moveNumber
         * @param string $startFirst
         * @return string
         * Recursive method. If the health of one of the players = 0 -> the game ends, else -> this method is run again.
         */
        public function battleMove($moveNumber, $startFirst)
        {
            //output move number
            if ($moveNumber <= 15){
                sleep(1);
            }
            echo "Move #$moveNumber:\n";
            if ($startFirst == 'first'){
                if ($moveNumber <= 15){
                    sleep(1);
                }
                //Generate move and get result
                $fistPlayerMoveResult = $this->firstPlayer->generateMove($this->secondPlayer);
                echo $fistPlayerMoveResult;
                //Check if the health of enemy = 0 -> the game ends
                if ($this->secondPlayer->getHealth() <= 0)
                {
                    $this->outputWinner($this->firstPlayer);
                    return '';
                }

                if ($moveNumber <= 15){
                    sleep(1);
                }
                $secondPlayerMoveResult = $this->secondPlayer->generateMove($this->firstPlayer);
                echo $secondPlayerMoveResult;
                if ($this->firstPlayer->getHealth() <= 0)
                {
                    $this->outputWinner($this->secondPlayer);
                    return '';
                }
            }else{
                if ($moveNumber <= 15){
                    sleep(1);
                }
                $fistPlayerMoveResult = $this->secondPlayer->generateMove($this->firstPlayer);
                echo $fistPlayerMoveResult;
                if ($this->firstPlayer->getHealth() <= 0)
                {
                    $this->outputWinner($this->secondPlayer);
                    return '';
                }

                if ($moveNumber <= 15){
                    sleep(1);
                }
                $secondPlayerMoveResult = $this->firstPlayer->generateMove($this->secondPlayer);
                echo $secondPlayerMoveResult;
                if ($this->secondPlayer->getHealth() <= 0)
                {
                    $this->outputWinner($this->firstPlayer);
                    return '';
                }
            }
            $this->outputPlayersHealth($startFirst);
            $moveNumber++;
            return $this->battleMove($moveNumber, $startFirst);
        }

        /**
         * Method which will start the game
         */
        public function startGame()
        {
            $welcomeMessage = $this->welcomeMessage();
            //Output welcome message
            echo $welcomeMessage;
            //Get which player will start the game first
            $startFirst = $this->startFirst();
            //Run the first move of battle
            $this->battleMove(1, $startFirst);
        }
    }