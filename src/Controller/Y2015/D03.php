<?php
namespace App\Controller\Y2015;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D03 extends AbstractController {
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
		$puzzle = str_replace( '^', '^,', $puzzle );
		$puzzle = str_replace( 'v', 'v,', $puzzle );
		$puzzle = str_replace( '>', '>,', $puzzle );
		$puzzle = str_replace( '<', '<,', $puzzle );
		$puzzle = substr( $puzzle, 0, -1 );
		$moves  = explode( ',', $puzzle );

		$horizontal  = 0;
		$vertical    = 0;
		$coordinates = array( $horizontal . ',' . $vertical );
		foreach ( $moves as $move ) {
			if ( $move === '^' ) {
				$horizontal++;
			}

			if ( $move === 'v' ) {
				$horizontal--;
			}

			if ( $move === '>' ) {
				$vertical++;
			}

			if ( $move === '<' ) {
				$vertical--;
			}

			$coordinates[] = $horizontal . ',' . $vertical;
		}

		$coordinates = array_unique( $coordinates );

		return count( $coordinates );
	}

	private function puzzle2( $puzzle ) {
		$puzzle = str_replace( '^', '^,', $puzzle );
		$puzzle = str_replace( 'v', 'v,', $puzzle );
		$puzzle = str_replace( '>', '>,', $puzzle );
		$puzzle = str_replace( '<', '<,', $puzzle );
		$puzzle = substr( $puzzle, 0, -1 );
		$moves  = explode( ',', $puzzle );

		$horizontal_santa = 0;
		$vertical_santa   = 0;

		$horizontal_robot = 0;
		$vertical_robot   = 0;

		$coordinates_santa = array( $horizontal_santa . ',' . $vertical_santa );
		$coordinates_robot = array( $horizontal_robot . ',' . $vertical_robot );

		$i = 0;
		foreach ( $moves as $move ) {
			if ( $i % 2 === 0 ) {
				if ( $move === '^' ) {
					$horizontal_santa++;
				}

				if ( $move === 'v' ) {
					$horizontal_santa--;
				}

				if ( $move === '>' ) {
					$vertical_santa++;
				}

				if ( $move === '<' ) {
					$vertical_santa--;
				}

				$coordinates_santa[] = $horizontal_santa . ',' . $vertical_santa;

			} else {

				if ( $move === '^' ) {
					$horizontal_robot++;
				}

				if ( $move === 'v' ) {
					$horizontal_robot--;
				}

				if ( $move === '>' ) {
					$vertical_robot++;
				}

				if ( $move === '<' ) {
					$vertical_robot--;
				}

				$coordinates_robot[] = $horizontal_robot . ',' . $vertical_robot;

			}

			$i++;
		}

		$coordinates = array_merge( $coordinates_robot, $coordinates_santa );

		$coordinates = array_unique( $coordinates );

		return count( $coordinates );
	}
}
