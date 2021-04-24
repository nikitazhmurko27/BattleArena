<?php

    /**
     * Class Player
     */

    class Player
    {
        private $name;
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
            $this->health = $healthAfterHeal > 100 ? 100 : $healthAfterHeal;

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
        public function outputMoveResult($params)
        {
            $type = $params['type'];
            $result = '';
            switch ($type){
                case 'hit':
                    $range = $params['range'];
                    $damage = $params['count'];
                    $enemyName = $params['enemyName'];
                    $enemyHealth = $params['enemyHealth'];
                    $result = "$this->name dealt damage from a $range range equal to $damage. $enemyName health = $enemyHealth. \n";
                    break;
                case 'heal':
                    $healValue = $params['count'];
                    $result = "$this->name is healed by $healValue units of health. $this->name health = $this->health. \n";
                    break;
            }
            return $result;
        }

    }