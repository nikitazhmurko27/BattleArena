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
            $result = "**********************************";
            $result .= "*                                *";
            $result .= "*      Welcome to the            *";
            $result .= "*       $this->name              *";
            $result .= "*                                *";
            $result .= "**********************************";
            return $result;
        }

        /**
         * @return array
         * Choose randomly who will start first
         */
        public function startFirst()
        {
            $arr = ['first', 'second'];
            $startFirstIndex = array_rand($arr, 1);
            return $arr[$startFirstIndex];
        }

        public function battleMove($moveNumber, $startFirst)
        {
            //output move number
            echo "Move #$moveNumber:";
            if ($startFirst == 'first'){
                sleep(1);
                $fistPlayerMoveResult = $this->firstPlayer->generateMove($this->secondPlayer);
                echo $fistPlayerMoveResult;
                if ($this->secondPlayer->getHealth() < 0)
                {
                    return $this->firstPlayer->getName() . " - won the battle!\n";
                }

                sleep(1);
                $secondPlayerMoveResult = $this->secondPlayer->generateMove($this->firstPlayer);
                echo $secondPlayerMoveResult;
                if ($this->firstPlayer->getHealth() < 0)
                {
                    return $this->secondPlayer->getName() . " - won the battle!\n";
                }
            }else{
                sleep(1);
                $fistPlayerMoveResult = $this->secondPlayer->generateMove($this->firstPlayer);
                echo $fistPlayerMoveResult;
                if ($this->firstPlayer->getHealth() < 0)
                {
                    return $this->secondPlayer->getName() . " - won the battle!\n";
                }

                sleep(1);
                $secondPlayerMoveResult = $this->firstPlayer->generateMove($this->secondPlayer);
                echo $secondPlayerMoveResult;
                if ($this->secondPlayer->getHealth() < 0)
                {
                    return $this->firstPlayer->getName() . " - won the battle!\n";
                }
            }
            $moveNumber++;
            return $this->battleMove($moveNumber, $startFirst);
        }

        public function startGame()
        {
            $welcomeMessage = $this->welcomeMessage();
            echo $welcomeMessage;
            $startFirst = $this->startFirst();
            $this->battleMove(1,$startFirst);
        }
    }