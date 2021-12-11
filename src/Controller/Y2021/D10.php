<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D10 extends AbstractController {
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

	public function puzzle1( $puzzle ) {
		$opening   = array( '{', '[', '(', '<' );
		$closing   = array( '}', ']', ')', '>' );
		$incorrect = array();

		$lines = explode( "\r\n", trim( $puzzle ) );
		foreach ( $lines as $line ) {
			$letters = str_split( $line );
			$array   = array();

			foreach ( $letters as $letter ) {
				if ( in_array( $letter, $opening ) ) {
					$array[] = $letter;
				} elseif ( in_array( $letter, $closing ) ) {
					$position = array_search( $letter, $closing );
					if ( end( $array ) === $opening[ $position ] ) {
						unset( $array[ array_key_last( $array ) ] );
					} else {
						$incorrect[] = $letter;
						break;
					}
				}
			}
		}
		$total = 0;
		foreach ( $incorrect as $thingy ) {
			if ( $thingy === ')' ) {
				$total += 3;
			}
			if ( $thingy === ']' ) {
				$total += 57;
			}
			if ( $thingy === '}' ) {
				$total += 1197;
			}
			if ( $thingy === '>' ) {
				$total += 25137;
			}
		}

		return $total;
	}

	public function puzzle2( $puzzle ) {
		$opening = array( '{', '[', '(', '<' );
		$closing = array( '}', ']', ')', '>' );
		$correct = array();

		$lines = explode( "\r\n", trim( $puzzle ) );

		$i = 0;
		foreach ( $lines as $line ) {
			$letters = str_split( $line );
			$array   = array();
			$wrong   = 0;

			foreach ( $letters as $letter ) {
				if ( in_array( $letter, $opening ) ) {
					$array[] = $letter;
				} elseif ( in_array( $letter, $closing ) ) {
					$position = array_search( $letter, $closing );
					if ( end( $array ) === $opening[ $position ] ) {
						unset( $array[ array_key_last( $array ) ] );
					} else {
						$wrong = 1;
						break;
					}
				}
			}

			if ( $wrong === 0 ) {
				$correct[] = $array;
			}

			$i++;
		}

		$scores = array();

		foreach ( $correct as $line ) {
			$total = 0;
			$line  = array_reverse( $line );

			foreach ( $line as $thingy ) {
				if ( $thingy === '(' ) {
					$total = ( $total * 5 ) + 1;
				}
				if ( $thingy === '[' ) {
					$total = ( $total * 5 ) + 2;
				}
				if ( $thingy === '{' ) {
					$total = ( $total * 5 ) + 3;
				}
				if ( $thingy === '<' ) {
					$total = ( $total * 5 ) + 4;
				}
			}

			$scores[] = $total;
		}

		rsort( $scores );
		return $scores[ floor( ( count( $scores ) - 1 ) / 2 ) ];
	}
}
