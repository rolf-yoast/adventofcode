<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D09 extends AbstractController {
	public function puzzle( $puzzle ): Response {

		$answer1 = $this->puzzle1( $puzzle );
		$answer2 = $this->puzzle2( $puzzle );

		return $this->json(
			array(
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}

	private function puzzle1( $puzzle ) {
		return $this->check_grid( $puzzle );
	}

	private function puzzle2( $puzzle ) {
		$grid = $this->generate_grid( $puzzle );

		$lows  = $this->get_low( $grid );
		$basin = array();
		foreach ( $lows as $low ) {
			$coords  = explode( ',', $low );
			$v       = $grid[ $coords[0] ][ $coords[1] ];
			$basin[] = count( $this->check_neighbours( $puzzle, $coords[0] - 1, $coords[1] - 1, array(), $v ) );
		}

		rsort( $basin );

		return  $basin[0] * $basin[1] * $basin[2];
	}

	private function generate_grid( $puzzle ) {
		$lines  = explode( "\r\n", trim( $puzzle ) );
		$length = strlen( $lines[0] );

		$i          = 0;
		$extra_line = array();
		while ( $i < ( $length + 2 ) ) {
			$extra_line[] = 10;
			$i++;
		}

		$grid   = array();
		$grid[] = $extra_line;

		foreach ( $lines as $line ) {
			$grid_line   = array();
			$grid_line[] = 10;
			$numbers     = str_split( $line );

			foreach ( $numbers as $number ) {
				$grid_line[] = intval( $number );
			}

			$grid_line[] = 10;

			$grid[] = $grid_line;
		}

		$grid[] = $extra_line;

		return $grid;
	}

	private function check_grid( $puzzle ) {
		$lines = explode( "\r\n", trim( $puzzle ) );
		$count = 0;
		for ( $row = 0; $row < count( $lines ); $row++ ) {
			for ( $col = 0;$col < strlen( $lines[ $row ] );$col++ ) {
				$lowest = true;
				$v      = (int) $lines[ $row ][ $col ];
				if ( $col > 0 && (int) $lines[ $row ][ $col - 1 ] <= $v ) {
					$lowest = false;
				}
				if ( $col < strlen( $lines[ $row ] ) - 1 && (int) $lines[ $row ][ $col + 1 ] <= $v ) {
					$lowest = false;
				}
				if ( $row > 0 && (int) $lines[ $row - 1 ][ $col ] <= $v ) {
					$lowest = false;
				}
				if ( $row < count( $lines ) - 1 && (int) $lines[ $row + 1 ][ $col ] <= $v ) {
					$lowest = false;
				}
				if ( $lowest ) {
					$count += 1 + $v;
				}
			}
		}

		return $count;
	}

	private function get_low( $grid ) {
		$low = array();
		$l   = 0;
		foreach ( $grid as $line ) {
			$c = 0;
			foreach ( $line as $number ) {
				if ( $number !== 10 ) {
					if ( ( $number < $grid[ $l - 1 ][ $c ] ) && ( $number < $grid[ $l + 1 ][ $c ] ) && ( $number < $grid[ $l ][ $c - 1 ] ) && ( $number < $grid[ $l ][ $c + 1 ] ) ) {
						$low[] = $l . ',' . $c;
					}
				}

				$c++;

			}
			$l++;
		}
		return $low;
	}

	function check_neighbours( $puzzle, $row, $col, $neighbours, $v ) {
		$neighbours[] = "{$row},{$col}";
		$lines        = explode( "\r\n", trim( $puzzle ) );
		//left
		if ( $col > 0 ) {
			$c = $col - 1;
			$r = $row;

			$z = (int) $lines[ $r ][ $c ];

			if ( ! in_array( "{$r},{$c}", $neighbours ) && $z > $v && $z !== 9 ) {
				$neighbours = $this->check_neighbours( $puzzle, $r, $c, $neighbours, $v );
			}
		}

		//right
		if ( $col < strlen( $lines[ $row ] ) - 1 ) {
			$c = $col + 1;
			$r = $row;
			$z = (int) $lines[ $r ][ $c ];
			if ( ! in_array( "{$r},{$c}", $neighbours ) && $z > $v && $z !== 9 ) {
				$neighbours = $this->check_neighbours( $puzzle, $r, $c, $neighbours, $v );
			}
		}
		//up
		if ( $row > 0 ) {
			$c = $col;
			$r = $row - 1;
			$z = (int) $lines[ $r ][ $c ];
			if ( ! in_array( "{$r},{$c}", $neighbours ) && $z > $v && $z !== 9 ) {
				$neighbours = $this->check_neighbours( $puzzle, $r, $c, $neighbours, $v );
			}
		}
		//down
		if ( $row < count( $lines ) - 1 ) {
			$c = $col;
			$r = $row + 1;
			$z = (int) $lines[ $r ][ $c ];
			if ( ! in_array( "{$r},{$c}", $neighbours ) && $z > $v && $z !== 9 ) {
				$neighbours = $this->check_neighbours( $puzzle, $r, $c, $neighbours, $v );
			}
		}
		return $neighbours;
	}


}
