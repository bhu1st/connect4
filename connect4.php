<?php

/**
**************************************************************

Connect 4, By Bhupal Sapkota, Nov 24th 2015

Ref:
https://en.wikipedia.org/wiki/Connect_Four

Example:
https://www.youtube.com/watch?v=yDWPi1pZ0Po


INSTRUCTIONP
- Please replace <br/> with \n to run in Console!

*****************************************************************/


/***************************************************************
Initializations
*****************************************************************/

$game_board_array = array(); //7x6 board standard

$game_board_rows = 6;

$game_board_columns = 7;

$players = array("x","o"); // player 1: denoted by x, player 2 denoted by o.

$game_current_player = $players[rand(0,1)]; //first player pick randomly from available players

$game_moves = 0; //move number, increment as discs are dropped.
		
//init game board

for($i = 0; $i < $game_board_rows ; $i ++ ){
	
			$game_board_array[$i] = array();
			
			for($j = 0; $j < $game_board_columns ; $j ++ ){

				$game_board_array[$i][$j] = "*"; //using * to represent empty slot in game board
			
			}
	
}


/***************************************************************
Print Board
*****************************************************************/	

function print_game_board(){
		
		global $game_board_array, $game_current_player, $game_moves, $game_board_rows, $game_board_columns; 
		
		echo "Current player: ". $game_current_player;
		echo "<br/>";
		echo "Moves: " .  $game_moves;
		echo "<br/>";
		echo "----------------------------";
		echo "<br/>";
		
		for($i = 0; $i < $game_board_rows ; $i ++ ){
			
			
			
			for($j = 0; $j < $game_board_columns ; $j ++ ){
				
					echo $game_board_array[$i][$j] . "   "; //spaces
					
			}
	
			echo '<br/>';
		
		}
		
		echo "----------------------------";
		echo "<br/>";
		
		

}

//print initial board
//print_game_board();

//play game
game_next_move();
	

/***************************************************************
Moves
*****************************************************************/	

function game_next_move(){
		
		global $game_board_array, $game_current_player, $game_moves, $game_board_rows, $game_board_columns, $players; 
		
		/****
		Game continues until all slots are filled or until win !! 
		*****/
		
		
		if( $game_moves >= ( $game_board_rows * $game_board_columns )) {
			echo '<br/>No winner. All slots filled';
			return false; 
		}
		
		//Let's try to drop a disc on random column if there's empty slot.
		
		$col = rand(0, $game_board_columns - 1 ); 
		
		for( $row = $game_board_rows - 1; $row >= 0 ; $row-- ){ //start checking from top
			
			//Is this slot available ? 
			if( $game_board_array[$row][$col] === "*" ){
				
				$game_board_array[$row][$col] = $game_current_player; //make a turn
				
				$game_moves++; //increase game move count
				
				print_game_board(); //print updated game board
				
				//Is this win ?
				if( game_check_win($row, $col) ){ //check if current move secures win ?
					
					echo '<br/>Player ' . $game_current_player.' wins!!';					
					return false; //end game
					
				}else{
					
					//Toggle turns
					
					if ($game_current_player == "x") {
						
						$game_current_player = $players[1]; //array("x","O");
						
					}else {
						
						$game_current_player = $players[0]; //array("x","O");
						
					}
					
					//Continue the game
					game_next_move();
					
				}
				
				return false; //disc placed successfully. 
			} 
			
		}
		
		//This column is full but there are empty slots.. try next column
		game_next_move();
		
}

/***************************************************************
Check for winner on each move
*****************************************************************/	


function game_check_win($row, $col){
	
	global $game_board_array, $game_current_player, $game_moves, $game_board_rows, $game_board_columns; 
	
	
	/***************************************************************
	check if current move secures 4 consecutives discs horizontally
	*****************************************************************/	

	$player = $game_board_array[$row][$col];
	
	$horizontal_count = 0;
		
	//count left
		for ( $i = $col; $i >= 0; $i-- )
		{
			
			if( $game_board_array[$row][$i] != $player ){
				
				break;
				
			}
			
			$horizontal_count++;
			
		}
		
		//count right
		for ( $i = $col + 1; $i < $game_board_columns; $i++ )
		{
				
			if( $game_board_array[$row][$i] != $player ){
		
				break;
		
			}
				
			$horizontal_count++;
				
		}
		
		//if found 4 discs that's the win !! otherwise keep going.
		if ($horizontal_count >= 4) {
			
			$horizontal_win = true; 
			
		}else {
			
			$horizontal_win = false; 
		}
		
		
		/***************************************************************
		check if current move secures four consecutives discs vertically
		*****************************************************************/	
		
		//TODO:
		$vertical_win = false;
		
		
		$vertical_count = 0;
		
		//count bottom
			for ( $i = $row; $i >= 0; $i-- )
			{
				
				if( $game_board_array[$i][$col] != $player ){
					
					break;
					
				}
				
				$vertical_count++;
				
			}
			
			//count top
			for ( $i = $row + 1; $i < $game_board_rows; $i++ )
			{
					
				if( $game_board_array[$i][$col] != $player ){
			
					break;
			
				}
					
				$vertical_count++;
					
			}
			
			//if found 4 discs that's the win !! otherwise keep going.
			if ($vertical_count >= 4) {
				
				$vertical_win = true; 
				
			}else {
				
				$vertical_win = false; 
			}
		
		
		
		/***************************************************************
		check if current move secures four consecutives discs diagonally
		*****************************************************************/	
		
		//TODO:
		$diagonal_win = false;
		
		$diagonal_count = 0;
		
		$tmp_row = $row; 
		$tmp_col = $col; 
		
		//count down
			for ( $i = $tmp_row; $i >= 0; $i-- )
			{
				
				if ($tmp_col >= $game_board_columns) break; //there is a limit to how high you can go in the sky, John!
				
				if( $game_board_array[$i][$tmp_col] != $player ){
					
					break;
					
				}
				
				$tmp_col++;
				$diagonal_count++;
				
			}
			
			//count up
			for ( $i = $tmp_row + 1; $i < $game_board_rows; $i++ )
			{
				
				if ($tmp_col >= $game_board_columns) break;
				
				if( $game_board_array[$i][$tmp_col] != $player ){
			
					break;
			
				}
					
				$tmp_col++;
				$diagonal_count++;
					
			}
			
			//if found 4 discs that's the win !! otherwise keep going.
			if ($diagonal_count >= 4) {
				
				$diagonal_win = true; 
				
			}else {
				
				$diagonal_win = false; 
			}
			
			
		/***************************************************************
		Let's see if there is a win
		*****************************************************************/	
	
		
		if( $horizontal_win) {
			
			echo "<br/>Horizontal Win";
			return true;
			
		} else if($vertical_win){
			
			echo "<br/>Vertical Win";
			return true;
			
			
		} else if ($diagonal_win){
		
			echo "<br/>Diagonal Win";
			return true;

		}else {
		
			return false;
		
		}
	
}
	


?>
