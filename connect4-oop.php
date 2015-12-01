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

class Connect4 {

/***************************************************************
Initializations
*****************************************************************/

	private $game_board_array; //7x6 board standard

	private $game_board_rows;

	private $game_board_columns;

	private $players; // player 1: denoted by x, player 2 denoted by o.

	private $game_current_player; //first player pick randomly from available players

	private $game_moves; //move number, increment as discs are dropped.
			


public function __construct() {



	$this->game_board_array = array(); //7x6 board standard

	$this->game_board_rows = 6;

	$this->game_board_columns = 7;

	$this->players = array("x","o"); // player 1: denoted by x, player 2 denoted by o.

	$this->game_current_player = $this->players[rand(0,1)]; //first player pick randomly from available players

	$this->game_moves = 0; //move number, increment as discs are dropped.


	//init game board

	for($i = 0; $i < $this->game_board_rows ; $i ++ ){
		
				$this->game_board_array[$i] = array();
				
				for($j = 0; $j < $this->game_board_columns ; $j ++ ){

					$this->game_board_array[$i][$j] = "*"; //using * to represent empty slot in game board
				
				}
		
	}
	
	//print initial board
	//print_game_board();

	//play game
	$this->game_next_move();

}


/***************************************************************
Print Board
*****************************************************************/	

private function print_game_board(){
		
		echo "Current player: ". $this->game_current_player;
		echo "<br/>";
		echo "Moves: " .  $this->game_moves;
		echo "<br/>";
		echo "----------------------------";
		echo "<br/>";
		
		for($i = 0; $i < $this->game_board_rows ; $i ++ ){
			
			
			
			for($j = 0; $j < $this->game_board_columns ; $j ++ ){
				
					echo $this->game_board_array[$i][$j] . "   "; //spaces
					
			}
	
			echo '<br/>';
		
		}
		
		echo "----------------------------";
		echo "<br/>";
		
		

}


/***************************************************************
Moves
*****************************************************************/	

private function game_next_move(){
		
		/****
		Game continues until all slots are filled or until win !! 
		*****/
		
		
		if( $this->game_moves >= ( $this->game_board_rows * $this->game_board_columns )) {
			echo '<br/>No winner. All slots filled';
			return false; 
		}
		
		//Let's try to drop a disc on random column if there's empty slot.
		
		$col = rand(0, $this->game_board_columns - 1 ); 
		
		for( $row = $this->game_board_rows - 1; $row >= 0 ; $row-- ){ //start checking from top
			
			//Is this slot available ? 
			if( $this->game_board_array[$row][$col] === "*" ){
				
				$this->game_board_array[$row][$col] = $this->game_current_player; //make a turn
				
				$this->game_moves++; //increase game move count
				
				$this->print_game_board(); //print updated game board
				
				//Is this win ?
				if( $this->game_check_win($row, $col) ){ //check if current move secures win ?
					
					echo '<br/>Player ' . $this->game_current_player.' wins!!';					
					return false; //end game
					
				}else{
					
					//Toggle turns
					
					if ($this->game_current_player == "x") {
						
						$this->game_current_player = $this->players[1]; //array("x","O");
						
					}else {
						
						$this->game_current_player = $this->players[0]; //array("x","O");
						
					}
					
					//Continue the game
					$this->game_next_move();
					
				}
				
				return false; //disc placed successfully. 
			} 
			
		}
		
		//This column is full but there are empty slots.. try next column
		$this->game_next_move();
		
}

/***************************************************************
Check for winner on each move
*****************************************************************/	


private function game_check_win($row, $col){
	

	/***************************************************************
	check if current move secures 4 consecutives discs horizontally
	*****************************************************************/	

	$player = $this->game_board_array[$row][$col];
	
	$horizontal_count = 0;
		
	//count left
		for ( $i = $col; $i >= 0; $i-- )
		{
			
			if( $this->game_board_array[$row][$i] != $player ){
				
				break;
				
			}
			
			$horizontal_count++;
			
		}
		
		//count right
		for ( $i = $col + 1; $i < $this->game_board_columns; $i++ )
		{
				
			if( $this->game_board_array[$row][$i] != $player ){
		
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
				
				if( $this->game_board_array[$i][$col] != $player ){
					
					break;
					
				}
				
				$vertical_count++;
				
			}
			
			//count top
			for ( $i = $row + 1; $i < $this->game_board_rows; $i++ )
			{
					
				if( $this->game_board_array[$i][$col] != $player ){
			
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
				
				if ($tmp_col >= $this->game_board_columns) break; //there is a limit to how high you can go in the sky, John!
				
				if( $this->game_board_array[$i][$tmp_col] != $player ){
					
					break;
					
				}
				
				$tmp_col++;
				$diagonal_count++;
				
			}
			
			//count up
			for ( $i = $tmp_row + 1; $i < $this->game_board_rows; $i++ )
			{
				
				if ($tmp_col >= $this->game_board_columns) break;
				
				if( $this->game_board_array[$i][$tmp_col] != $player ){
			
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

}	

//run game 
$runGame = new Connect4();



?>
