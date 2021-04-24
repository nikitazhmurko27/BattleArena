<?php

    namespace Player;

    class Player
    {
        private $name;

        private $maxHealth = 100;
        private $health = 100;

        //Variables which store min and max value of the damage/heal
        private $smallRange = [18,25];
        private $largeRange = [10,35];

        //Percent of health in which the chance of heal becomes higher than the chance of hitting
        private $healBoost;

        function __construct($name, $healBoost)
        {
            $this->name = $name;
            $this->healBoost = $healBoost;
        }

        /**
         * @return string player name
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return int player health
         */
        public function getHealth()
        {
            return $this->health;
        }

        /**
         * @return int player health in percent
         */
        public function getHealthPercent()
        {
            return (int)(($this->health * 100)/$this->maxHealth);
        }

        /**
         * Get damage from an enemy
         * @param int $damage - count of damage
         */
        public function getDamage($damage)
        {
            $this->health = $this->health - $damage;
        }

        /**
         * Healing
         * @return array
         */
        public function healing()
        {
            //Get the value of "heal" from a small range
            $healValue = rand($this->smallRange[0], $this->smallRange[1]);
            //health value after the heal
            $healthAfterHeal = $this->health + $healValue;
            //Player health can't be more than 100. Adding the condition and updating player health
            $this->health = $healthAfterHeal > $this->maxHealth ? $this->maxHealth : $healthAfterHeal;

            return [
                'type' => 'heal',
                'count' => $healValue,
            ];
        }

        /**
         * @param string $range  - small/large
         * @param object $enemy
         * @return array
         */
        public function hitEnemy($range, $enemy)
        {
            //Get the damage
            $damage = $range === 'small' ? rand($this->smallRange[0] , $this->smallRange[1]) : rand($this->largeRange[0], $this->largeRange[1]);
            //Enemy get the damage
            $enemy->getDamage($damage);

            return[
                'type' => 'hit',
                'range' => $range,
                'count' => $damage,
                'enemyName' => $enemy->getName(),
                'enemyHealth' => $enemy->getHealth(),
            ];
        }

        /**
         * @param array $params
         * @return string $result
         */
        public function getMoveResult($params)
        {
            $type = $params['type'];
            $result = '';
            switch ($type){
                case 'hit':
                    $range = $params['range'];
                    $damage = $params['count'];
                    $enemyName = $params['enemyName'];
                    $enemyHealth = $params['enemyHealth'];
                    $result = "$this->name dealt $damage damage from a $range range. $enemyName health = $enemyHealth. \n";
                    break;
                case 'heal':
                    $healValue = $params['count'];
                    $result = "$this->name is healed by $healValue units of health. $this->name health = $this->health. \n";
                    break;
            }
            return $result;
        }

        /**
         * @param object $enemy
         * @return string
         */
        public function generateMove($enemy)
        {
            //creating an array with possible moves. If health = 100 exclude "heal" skill.
            $arrayMoves = $this->health == 100 ? ['smallHit', 'largeHit'] : ['smallHit', 'largeHit', 'heal'];
            //adding the condition to healing boost
            if ($this->healBoost !== 0 && $this->getHealthPercent() <= $this->health){
                $arrayMoves = ['smallHit','largeHit','heal', 'heal'];
            }
            //shuffle the array
            shuffle($arrayMoves);
            //get the move index
            $moveIndex = array_rand($arrayMoves, 1);
            $moveType = $arrayMoves[$moveIndex];

            $moveResult = '';
            switch ($moveType){
                case 'smallHit':
                    $moveParams = $this->hitEnemy('small', $enemy);
                    $moveResult = $this->getMoveResult($moveParams);
                    break;
                case 'largeHit':
                    $moveParams = $this->hitEnemy('large', $enemy);
                    $moveResult = $this->getMoveResult($moveParams);
                    break;
                case 'heal':
                    $moveParams = $this->healing();
                    $moveResult = $this->getMoveResult($moveParams);
                    break;
            }
            return $moveResult;
        }

    }