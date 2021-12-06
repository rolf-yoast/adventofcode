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

		return $this->place_fishes($fishes, 80);
	}

	private function puzzle2($puzzle){
		$fishes = explode( ",", trim( $puzzle ) );

		$fishes = $this->place_fishes($fishes, 256);
		return $fishes;
	}

	private function place_fishes($puzzle, $days){
		$pond = [0,0,0,0,0,0,0,0,0];

		foreach($puzzle as $fish){
			$pond[intval($fish)]++;
		}

		$i = 1;
		while($i <= $days){
			$bucket = [];

			$bucket[7] = $pond[8];
			$bucket[6] = $pond[7];
			$bucket[5] = $pond[6];
			$bucket[4] = $pond[5];
			$bucket[3] = $pond[4];
			$bucket[2] = $pond[3];
			$bucket[1] = $pond[2];
			$bucket[0] = $pond[1];
			$bucket[6] += $pond[0];
			$bucket[8] = 0 + $pond[0];

			$pond = $bucket;

			$i++;
		}

		$total = 0;
		foreach($pond as $fish){
			$total = $total + $fish;
		}

		return $total;
	}
}
