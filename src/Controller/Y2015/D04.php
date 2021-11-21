<?php
namespace App\Controller\Y2015;

ini_set( 'max_execution_time', '0' );

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D04 extends AbstractController {
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

		$i = 0;
		while ( ++$i ) {

			$hash = md5( $puzzle . $i );

			$result = substr( $hash, 0, 5 );

			if ( $result === '00000' ) {
				break;
			}
		}

		return $i;
	}

	private function puzzle2( $puzzle ) {

		$i = 0;
		while ( ++$i ) {

			$hash = md5( $puzzle . $i );

			$result = substr( $hash, 0, 6 );

			if ( $result === '000000' ) {
				break;
			}
		}

		return $i;
	}
}
