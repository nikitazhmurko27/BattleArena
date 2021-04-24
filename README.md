# BattleArena

Modeling the game as a console application. Participants are Computer and Human. 
The sequence of moves is determined randomly. 

Each of the players must have the same amount of health (for example, 100) and a choice (also randomly) of the following of the steps:  
- should do moderate damage and has a small range (e.g. 18-25) 
- must have a wide range of damage (e.g. 10-35) 
- must heal in a small range (in the same as in step 1)  

After each action, a message should be printed that tells what happened and how much health the Player and the Computer have. 
When the health of the Computer reaches, for example, 35%, increase its chance of healing.  

The game ends if one of the participants has reached 0 health.

# How to run the application
1. Install PHP if you haven't installed it before. Instruction: https://www.php.net/manual/en/install.php
2. Download the current project.
3. Open "terminal" and go to the root project folder (cd /path/to/project/BattleArena/)
4. Run the application using the next command: php index.php
