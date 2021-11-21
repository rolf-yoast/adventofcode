<?php
namespace App\Controller\Y2015;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D02 extends AbstractController {
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
		$puzzles = explode( "\r\n", trim( $puzzle ) );

		$total = 0;
		foreach ( $puzzles as $puzzlepiece ) {
			$sides = explode( 'x', $puzzlepiece );
			$l     = intval( $sides[0] );
			$w     = intval( $sides[1] );
			$h     = intval( $sides[2] );

			$lw = $l * $w;
			$wh = $w * $h;
			$hl = $h * $l;

			$square = ( $lw + $wh + $hl ) * 2;
			$extra  = min( array( $lw, $wh, $hl ) );
			$total  = $total + $extra + $square;
		}

		return $total;
	}

	private function puzzle2( $puzzle ): string {
		$puzzles = explode( "\r\n", trim( $puzzle ) );

		$total = 0;
		foreach ( $puzzles as $puzzlepiece ) {
			$sides = explode( 'x', $puzzlepiece );
			sort( $sides );

			$l = intval( $sides[0] );
			$w = intval( $sides[1] );
			$h = intval( $sides[2] );

			$length = ( $l + $w ) * 2;

			$bow   = $l * $w * $h;
			$total = $total + $bow + $length;
		}

		return $total;
	}
}
