<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D08 extends AbstractController {
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
		return $this->detect_digits($puzzle);
	}

	private function puzzle2($puzzle){
		return 2;
	}

	private function detect_digits($puzzle){
		$lines = explode( "\r\n", trim( $puzzle ) );
		$total = 0;

		foreach($lines as $line){
			$words = explode(' | ', $line);
			$pattern = explode(' ', $words[0]);
			$count = count($pattern);
			$digits = explode(' ', $words[1]);

			$i = 0;
			while($i < $count){
				$stringParts = str_split($pattern[$i]);
				sort($stringParts);
				$pattern[$i] = implode($stringParts);

				$i++;
			}

			$second_pattern = [];
			foreach($pattern as $something){
				$length = strlen($something);
				if($length == 2){
					$second_pattern[1] = $something;
				}
				if($length == 4){
					$second_pattern[4] = $something;
				}
				if($length == 3){
					$second_pattern[7] = $something;
				}
				if($length == 7){
					$second_pattern[8] = $something;
				}
			}

			foreach($digits as $letters){
				$stringParts = str_split($letters);
				sort($stringParts);
				$letters = implode($stringParts);

				$number = array_search($letters, $second_pattern, true);

				if( ($number === 1) || ($number === 4) || ($number === 7) || ($number === 8) ){
					$total++;
				}
			}
		}

		return $total;
	}
}
