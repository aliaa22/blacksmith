<?php
session_start();
/**
 * createGameData
 * Creates a new session data
 * 
 * @return bool
 */

 function createGameData () {
   $_SESSION['blacksmith'] = [
     'response' => [],
     'gold' => 15,
     'wood' => 0,
     'ore' => 0,
     'swords' => 0,
     'axes' => 0,
     'staffs' => 0,
     'fire' => false
  ];

  return isset($_SESSION['blacksmith']);
 }


/**
 * getResponse
 * Gets the response history array from the session and converts to a string
 * 
 * @return string
 */
function getResponse () {
  return implode('<br><br>', $_SESSION['blacksmith']['response']);
}

/**
 * updateResponse
 * Adds a new response to the response history array found in session
 * Get the full response history from getResponse
 * 
 * @param [string] $response
 * @return string
 */
function updateResponse ($response) {
  if (!isset($_SESSION['blacksmith'])) {
    createGameData();
  } 

  array_push($_SESSION['blacksmith']['response'], $response);

  return getResponse();
}

/**
 * fire
 * Used to start/stop the fire
 * Updates the Session data
 * 
 * @return string
 */

 function fire () {
   if ($_SESSION['blacksmith']['fire']) {
     $_SESSION['blacksmith']['fire'] = false;
     return "You ruined the fire by putting it out.";
   } else {
     if ($_SESSION['blacksmith']['wood'] > 0) {
       $_SESSION['blacksmith']['wood']--;
       $_SESSION['blacksmith']['fire'] = true;

       return "You brought the fire back to life.";
     } else {
       return "You don't have enough wood to make a fire.";
     }
   }
 }

/**
 * buy
 * Used to buy items (wood or ore)
 * Updates the session data
 * 
 * @param [string] $item
 * @return string
 */

 function buy ($item) {
   if ($_SESSION['blacksmith']['fire']) {
     return "You have to put out the fire first.";
   } else {
     if (isset($item)) {
       if (isset(SETTINGS[$item])) {
         if ($_SESSION['blacksmith']['gold'] >= SETTINGS[$item]['gold']) {
           $_SESSION['blacksmith'][$item]++;
           $_SESSION['blacksmith']['gold'] -= SETTINGS[$item]['gold'];
           return "You have bought one {$item}.";
         } else {
           return "You're too broke to buy this.";
         }
       } else {
         return "You cannot buy a {$item}.";
       }

     } else {
       return "You must choose an item to buy.";
     }
   }
 }

/**
 * make
 * Used to make new items (swords, axes, or staffs)
 * Updates the session data
 * 
 * @param [string] $item
 * @return string
 */


/**
 * sell
 * Used to sell items (wood, ore, swords, axes, or staffs)
 * Updates the session data
 *
 * @param [string] $item
 * @return string
 */


/**
 * inventory
 * Used to return session data (formatted)
 * 
 * @return string
 */


/**
 * restart
 * Used to clear session data and start over
 * Updates the session data
 *  
 * @return string
 */


/**
 * help
 * Returns a formatted string of game instructions
 * 
 * @return string
 */
function help () {
  return 'Welcome to Blacksmith, the text based blacksmith game. Use the following commands to play the game: <span class="red">buy <em>item</em></span>, <span class="red">sell <em>item</em></span>, <span class="red">make <em>item</em></span>, <span class="red">fire</span>. To restart the game use the <span class="red">restart</span> command For these instruction again use the <span class="red">help</span> command';
}

/**
 * Create a response based on the players commands
 * - If the player has entered a command 
 *    - extract the command from the player's input
 *      - the explode function will split the input on the space separate the 
 *        command from the option
 *    - check if the entered command is a valid function using function_exists
 *      - check for a command option
 *        - execute command with option using the variable function technique
 *        - updateResponse with function's results
 *      - else
 *        - execute command using the variable function technique
 *        - updateResponse with function's results
 *    - else
 *      - updateResponse with invalid command  
 */

 if (isset($_POST['command'])) {
   // splits command and options, returns array
   $command = explode(' ', strtolower($_POST['command']));
   if (function_exists($command[0])) {
     if (isset($command[1])) {
       $response = $command[0]($command[1]);
       updateResponse($response);
     } else {
       $response = $command[0]();
       updateResponse($response);
     }
   } else {
     updateResponse("{$_POST['command']} is not a valid command.");
   }
 }

