<?php
namespace App\Controller\Y2021;

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

	private function puzzle1($puzzle){
		$fishes = explode( ",", trim( $puzzle ) );

		return count($this->generate_fish($fishes, 80));
	}

	private function puzzle2($puzzle){
		$fishes = explode( ",", trim( $puzzle ) );

		$fishes = $this->generate_fish($fishes, 128);

		return 1;
	}

	private function generate_fish($fishes, $days){

		$i = 1;
		while($i <= $days){
			$new = [];
			$c = 0;
			foreach($fishes as $fish){
				if($fish > 0){
					$fishes[$c]--;
				}

				if($fish == 0){
					$fishes[$c] = 6;
					$new[] = 8;
				}

				$c++;
			}

			$fishes = array_merge($fishes, $new);

			$i++;
		}

		return $fishes;
	}
}
