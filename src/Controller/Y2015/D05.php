<?php
namespace App\Controller\Y2015;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D05 extends AbstractController {
	public function puzzle( $puzzle ): Response {

		$answer1 = $this->puzzle1( $puzzle );
		$answer2 = 'Empty solution 2';

		return $this->json(
			array(
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}

	private function puzzle1( $puzzle ): string {
		$lines = explode( "\r\n", trim( $puzzle ) );

		$vowels    = array( 'a', 'e', 'i', 'o', 'u' );
		$bad_combo = array( 'ab', 'cd', 'pq', 'xy' );

		$total = 0;

		foreach ( $lines as $line ) {
			$letters     = str_split( $line );
			$lettercount = count( $letters );

			$count = preg_match_all( '/[aeiou]/i', $line, $matches );

			$double = 0;
			if ( $count > 2 ) {

				$i = 1;
				foreach ( $letters as $letter ) {
					if ( $lettercount === $i ) {
						break;
					}

					if ( $letter === $letters[ $i ] ) {
						$double = 1;
						break;
					}
					$i++;
				}
			}

			$bad = 0;
			if ( $double === 1 ) {
				foreach ( $bad_combo as $bad_combi ) {
					if ( str_contains( $line, $bad_combi ) ) {
						$bad = 1;
					}
				}
			}

			if ( $bad === 0 && $double === 1 && $count > 2 ) {
				$total++;
			}
		}

		return $total;
	}
}
