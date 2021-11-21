<?php
namespace App\Controller\Y2015;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D06 extends AbstractController {
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

	private function puzzle1( $puzzle ): string {
		$lines = explode( "\r\n", trim( $puzzle ) );

		$lamps = array();

		for ( $i = 0; $i < 1000; $i++ ) {
			for ( $j = 0; $j < 1000; $j++ ) {
				$lamps[ $i ][ $j ] = 0;
			}
		}

		foreach ( $lines as $line ) {
			if ( str_contains( $line, 'turn on' ) ) {
				$line     = substr( $line, 8 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );

				$x = $min[0] - 1;
				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						$lamps[ $x ][ $y ] = 1;
					}
				}
			}

			if ( str_contains( $line, 'turn off' ) ) {
				$line     = substr( $line, 9 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );

				$x = $min[0];
				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						$lamps[ $x ][ $y ] = 0;
					}
				}
			}

			if ( str_contains( $line, 'toggle' ) ) {
				$line     = substr( $line, 7 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );
				$x        = $min[0];
				$y        = $min[1];

				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						if ( $lamps[ $x ][ $y ] === 1 ) {
							$lamps[ $x ][ $y ] = 0;
						} else {
							$lamps[ $x ][ $y ] = 1;
						}
					}
				}
			}
		}

		$total = 0;
		foreach ( $lamps as $lamprow ) {
			foreach ( $lamprow as $lamp ) {
				if ( $lamp === 1 ) {
					$total++;
				}
			}
		}

		return $total;
	}

	private function puzzle2( $puzzle ): string {
		$lines = explode( "\r\n", trim( $puzzle ) );

		$lamps = array();

		for ( $i = 0; $i < 1000; $i++ ) {
			for ( $j = 0; $j < 1000; $j++ ) {
				$lamps[ $i ][ $j ] = 0;
			}
		}

		foreach ( $lines as $line ) {
			if ( str_contains( $line, 'turn on' ) ) {
				$line     = substr( $line, 8 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );

				$x = $min[0] - 1;
				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						$lamps[ $x ][ $y ]++;
					}
				}
			}

			if ( str_contains( $line, 'turn off' ) ) {
				$line     = substr( $line, 9 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );

				$x = $min[0];
				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						if ( $lamps[ $x ][ $y ] > 0 ) {
							$lamps[ $x ][ $y ]--;
						}
					}
				}
			}

			if ( str_contains( $line, 'toggle' ) ) {
				$line     = substr( $line, 7 );
				$exploded = explode( ' ', $line );
				$min      = explode( ',', $exploded[0] );
				$max      = explode( ',', $exploded[2] );
				$x        = $min[0];
				$y        = $min[1];

				for ( $x = $min[0]; $x <= $max[0]; $x++ ) {
					for ( $y = $min[1]; $y <= $max[1]; $y++ ) {
						$lamps[ $x ][ $y ]++;
						$lamps[ $x ][ $y ]++;
					}
				}
			}
		}

		$total = 0;
		foreach ( $lamps as $lamprow ) {
			foreach ( $lamprow as $lamp ) {
				$total = $total + $lamp;
			}
		}

		return $total;
	}

}
