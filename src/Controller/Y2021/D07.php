<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D07 extends AbstractController {
	public function puzzle( $puzzle ): Response {

		$answer1 = $this->puzzle1($puzzle);
		$answer2 = $this->puzzle2($puzzle);

		return $this->json(
			array(
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}

	private function puzzle1($puzzle){
		$positions = explode( ",", trim( $puzzle ) );
		return $this->calculate_fuel($positions, 2000);

	}

	private function puzzle2($puzzle){
		$positions = explode( ",", trim( $puzzle ) );
		return $this->expensive_calculate_fuel($positions, 2000);

	}

	private function calculate_fuel($positions, $itirations){
		$total = 1000000000;
		$i = 1;

		while($i <= $itirations){
			$fuel = 0;
			foreach($positions as $position){
				if($position > $i){
					$fuel += $position - $i;
				}

				if($position < $i){
					$fuel += $i - $position;
				}
			}

			$i++;

			if($fuel < $total){
				$total = $fuel;
			}
		}

		return $total;
	}

	private function expensive_calculate_fuel($positions, $itirations){
		$total = 1000000000;
		$i = 1;

		while($i <= $itirations){
			$fuel = 0;
			foreach($positions as $position){
				if($position > $i){
					$moves = $position - $i;
				}

				if($position < $i){
					$moves = $i - $position;
				}

				$fuel += $moves*($moves+1)/2;
			}

			$i++;

			if($fuel < $total){
				$total = $fuel;
			}
		}

		return $total;
	}
}
