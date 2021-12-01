<?php
namespace App\Controller\Y2021;

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
		$puzzles = explode( "\r\n", trim( $puzzle ) );

		$previous = 9999;
		$up = 0;
		foreach($puzzles as $line){
			if($line > $previous){
				$up++;
			}

			$previous = $line;
		}

		return $up;
	}

	private function puzzle2( $puzzle ): string {
		$puzzles = explode( "\r\n", trim( $puzzle ) );

		$previous = 9999;
		$i = 0;
		$count = count( $puzzles );
		$total = 0;

		while( $i < ($count - 2) ){
			$next = $this->get_sum( $puzzles, $i );

			if($previous < $next){
				$total++;
			}

			$previous = $next;
			$i++;

		}

		return $total;
	}

	private function get_sum( $lines, $offset ) {
		$i = 0;
		$sum = 0;
		while( $i < 3 ){
			if( array_key_exists( $offset, $lines ) ) {
				$sum = $sum + $lines[$offset];
				$i++;
				$offset++;
			}
		}

		return $sum;
	}
}
