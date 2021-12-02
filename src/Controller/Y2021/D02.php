<?php
namespace App\Controller\Y2021;

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

	private function puzzle1($puzzle){
		$lines = explode( "\r\n", trim( $puzzle ) );

		$horizontal = 0;
		$vertical = 0;

		foreach ( $lines as $line ) {
			if ( str_contains( $line, 'forward' ) ) {
				$line     = substr( $line, -1);
				$horizontal = $horizontal + $line;
			}

			if ( str_contains( $line, 'down' ) ) {
				$line     = substr( $line, -1);
				$vertical = $vertical + $line;
			}

			if ( str_contains( $line, 'up' ) ) {
				$line     = substr( $line, -1);
				$vertical = $vertical - $line;
			}
		}

		return $vertical * $horizontal;
	}

	private function puzzle2($puzzle){
		$lines = explode( "\r\n", trim( $puzzle ) );

		$depth = 0;
		$aim = 0;
		$horizontal = 0;

		foreach ( $lines as $line ) {
			if ( str_contains( $line, 'forward' ) ) {
				$line     = substr( $line, -1);
				$horizontal = $horizontal + $line;
				if($aim !== 0){
					$depth = $depth + ($aim * $line);
				}
			}

			if ( str_contains( $line, 'down' ) ) {
				$line     = substr( $line, -1);
				$aim = $aim + $line;
			}

			if ( str_contains( $line, 'up' ) ) {
				$line     = substr( $line, -1);
				$aim = $aim - $line;
			}
		}

		return $depth * $horizontal;
	}
}
