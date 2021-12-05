<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D05 extends AbstractController {
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
		$lines = explode( "\r\n", trim( $puzzle ) );

		$grid = $this->generate_grid( 1000 );

		$filled_grid = $this->fill_lines( $grid, $lines );

		return $this->calculate_overlaps( $filled_grid );
	}

	public function puzzle2( $puzzle ) {
		$lines = explode( "\r\n", trim( $puzzle ) );

		$grid = $this->generate_grid( 1000 );

		$filled_grid = $this->fill_lines( $grid, $lines, 1 );

		return $this->calculate_overlaps( $filled_grid );
	}

	private function generate_grid( $size ) {
		$grid = array();

		for ( $i = 0; $i < $size; $i++ ) {
			for ( $j = 0; $j < $size; $j++ ) {
				$grid[ $i ][ $j ] = 0;
			}
		}

		return $grid;
	}

	private function fill_lines( $grid, $lines, $diagonal = 0 ) {
		foreach ( $lines as $line ) {
			$line  = explode( ' ', $line );
			$part1 = explode( ',', $line[0] );
			$part2 = explode( ',', $line[2] );

			if ( $part1[0] === $part2[0] ) {
				$x = $part1[0];
				if ( $part1[1] < $part2[1] ) {
					$ybig   = $part2[1];
					$ysmall = $part1[1];
				}

				if ( $part1[1] > $part2[1] ) {
					$ybig   = $part1[1];
					$ysmall = $part2[1];
				}

				for ( $y = $ysmall; $y <= $ybig; $y++ ) {
					$grid[ $y ][ $x ]++;
				}
			}

			if ( $part1[1] === $part2[1] ) {
				$y = $part1[1];
				if ( $part1[0] < $part2[0] ) {
					$xbig   = $part2[0];
					$xsmall = $part1[0];
				}

				if ( $part1[0] > $part2[0] ) {
					$xbig   = $part1[0];
					$xsmall = $part2[0];
				}

				for ( $x = $xsmall; $x <= $xbig; $x++ ) {
					$grid[ $y ][ $x ]++;
				}
			}

			if ( $diagonal === 1 ) {

				if ( ( $part1[0] !== $part2[0] ) && ( $part1[1] !== $part2[1] ) ) {
					$x1 = $part1[0];
					$x2 = $part2[0];
					$y1 = $part1[1];
					$y2 = $part2[1];

					if ( $y1 < $y2 ) {
						$way = 1;
						$y   = $y1;
					} else {
						$way = 0;
						$y   = $y1;
					};

					$run = 1;
					if ( $x1 < $x2 ) {
						$run = 0;
					}

					if ( $run === 0 ) {

						for ( $x1 = $x1; $x1 <= $x2; $x1++ ) {
							$grid[ $y ][ $x1 ]++;

							if ( $way === 1 ) {
								$y++;
							} else {
								$y--;
							}
						}
					}

					if ( $run === 1 ) {
						for ( $x1 = $x1; $x1 >= $x2; $x1-- ) {
							$grid[ $y ][ $x1 ]++;
							if ( $way === 1 ) {
								$y++;
							} else {
								$y--;
							}
						}
					}
				}
			}
		}

		return $grid;
	}

	private function calculate_overlaps( $grid ) {
		$count = 0;
		foreach ( $grid as $line ) {
			foreach ( $line as $number ) {
				if ( intval( $number ) > 1 ) {
					$count++;
				}
			}
		}

		return $count;
	}
}
