<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D08 extends AbstractController {
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
		return $this->detect_digits( $puzzle );
	}

	private function puzzle2( $puzzle ) {
		return $this->part2( $puzzle );
	}

	private function detect_digits( $puzzle ) {
		$lines = explode( "\r\n", trim( $puzzle ) );
		$total = 0;

		foreach ( $lines as $line ) {
			$words   = explode( ' | ', $line );
			$pattern = explode( ' ', $words[0] );
			$count   = count( $pattern );
			$digits  = explode( ' ', $words[1] );

			$i = 0;
			while ( $i < $count ) {
				$stringParts = str_split( $pattern[ $i ] );
				sort( $stringParts );
				$pattern[ $i ] = implode( $stringParts );

				$i++;
			}

			$second_pattern = array();
			foreach ( $pattern as $something ) {
				$length = strlen( $something );
				if ( $length == 2 ) {
					$second_pattern[1] = $something;
				}
				if ( $length == 4 ) {
					$second_pattern[4] = $something;
				}
				if ( $length == 3 ) {
					$second_pattern[7] = $something;
				}
				if ( $length == 7 ) {
					$second_pattern[8] = $something;
				}
			}

			foreach ( $digits as $letters ) {
				$stringParts = str_split( $letters );
				sort( $stringParts );
				$letters = implode( $stringParts );

				$number = array_search( $letters, $second_pattern, true );

				if ( ( $number === 1 ) || ( $number === 4 ) || ( $number === 7 ) || ( $number === 8 ) ) {
					$total++;
				}
			}
		}

		return $total;
	}

	private function part2( $puzzle ) {
		$lines = explode( "\r\n", trim( $puzzle ) );

		$sum = 0;
		foreach ( $lines as $i ) {
			$seg = array();

			$line = explode( ' | ', $i );

			$w = array();
			foreach ( explode( ' ', $line[0] ) as $number ) {
				$w[ strlen( $number ) ][] = $number;
			}

			for ( $j = 0;$j < strlen( $w[3][0] );$j++ ) {
				if ( ! stristr( $w[2][0], $w[3][0][ $j ] ) ) {
					$seg['top'] = $w[3][0][ $j ];
				}
			}

			foreach ( $w[6] as $s ) {
				for ( $j = 0; $j < strlen( $w[7][0] ); $j++ ) {
					if ( ! stristr( $s, $w[7][0][ $j ] ) && stristr( $w[2][0], $w[7][0][ $j ] ) ) {
						$seg['right-top'] = $w[7][0][ $j ];
					}
				}
			}

			for ( $j = 0;$j < strlen( $w[2][0] );$j++ ) {
				if ( ! stristr( $w[2][0][ $j ], $seg['right-top'] ) ) {
					$seg['right-bot'] = $w[2][0][ $j ];
				}
			}

			$a          = count_chars( implode( '', $w[5] ) . $w[4][0] );
			$seg['mid'] = chr( array_search( max( $a ), $a ) );

			for ( $j = 0;$j < strlen( $w[4][0] );$j++ ) {
				if ( ! in_array( $w[4][0][ $j ], $seg ) ) {
					$seg['left-top'] = $w[4][0][ $j ];
				}
			}

			$count = array();
			foreach ( $w[5] as $c ) {
				$count2 = 0;
				for ( $j = 0;$j < strlen( $c );$j++ ) {
					if ( ! in_array( $c[ $j ], $seg ) ) {
						$count2++;
					}
				}
				$count[ $count2 ][] = $c;
			}
			$seg['bot'] = str_replace( $seg, '', $count[1][0] );

			$seg['left-bot'] = str_replace( $seg, '', 'abcdefg' );

			$s = '';
			foreach ( explode( ' ', $line[1] ) as $n ) {
				if ( strlen( $n ) == 3 ) {
					$s .= 7;
				} elseif ( strlen( $n ) == 2 ) {
					$s .= 1;
				} elseif ( strlen( $n ) == 4 ) {
					$s .= 4;
				} elseif ( strlen( $n ) == 7 ) {
					$s .= 8;
				} elseif ( strlen( $n ) == 5 ) {
					if ( stristr( $n, $seg['top'] ) && stristr( $n, $seg['right-top'] ) && stristr( $n, $seg['mid'] ) && stristr( $n, $seg['left-bot'] ) && stristr( $n, $seg['bot'] ) ) {
						$s .= 2;
					} elseif ( stristr( $n, $seg['top'] ) && stristr( $n, $seg['right-top'] ) && stristr( $n, $seg['mid'] ) && stristr( $n, $seg['right-bot'] ) && stristr( $n, $seg['bot'] ) ) {
						$s .= 3;
					} else {
						$s .= 5;
					}
				} elseif ( stristr( $n, $seg['top'] ) && stristr( $n, $seg['right-top'] ) && stristr( $n, $seg['right-bot'] ) && stristr( $n, $seg['bot'] ) && stristr( $n, $seg['left-bot'] ) && stristr( $n, $seg['left-top'] ) ) {
					$s .= 0;
				} elseif ( stristr( $n, $seg['top'] ) && stristr( $n, $seg['right-top'] ) && stristr( $n, $seg['mid'] ) && stristr( $n, $seg['right-bot'] ) && stristr( $n, $seg['bot'] ) && stristr( $n, $seg['left-top'] ) ) {
					$s .= 9;
				} else {
					$s .= 6;
				}
			}
				$sum += $s;
		}

		return $sum;
	}
}
