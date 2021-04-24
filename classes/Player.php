<?php

    /**
     * Class Player
     */

    class Player
    {
        private $name;
        private $health = 100;

        //Variables which store min and max value of the damage
        private $smallDamageRange = [18,25];
        private $largeDamageRange = [10,35];

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
    }