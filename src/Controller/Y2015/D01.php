<?php
namespace App\Controller\Y2015;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D01 extends AbstractController {
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
		$up   = substr_count( $puzzle, '(' );
		$down = substr_count( $puzzle, ')' );
		return intval( $up ) - intval( $down );
	}

	private function puzzle2( $puzzle ): string {
		$puzzle       = str_replace( '(', '(,', $puzzle );
		$puzzle       = str_replace( ')', '),', $puzzle );
		$puzzle_array = explode( ',', $puzzle );
		$floor        = 0;
		$count        = 1;
		foreach ( $puzzle_array as $something ) {
			if ( $something === '(' ) {
				$floor++;
			}

			if ( $something === ')' ) {
				$floor--;
			}

			if ( $floor < 0 ) {

				break;
			}
			$count++;
		}
		return $count;
	}
}
