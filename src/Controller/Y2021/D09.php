<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D09 extends AbstractController {
	public function puzzle( $puzzle ): Response {

		$answer1 = $this->puzzle1($puzzle);
		$answer2 = 'Empty solution 2';

		return $this->json(
			array(
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}

	private function puzzle1($puzzle){
		$grid = $this->generate_grid($puzzle);

		return $this->check_grid($grid);
	}

	private function generate_grid($puzzle){
		$lines = explode( "\r\n", trim( $puzzle ) );
		$length = strlen($lines[0]);

		$i = 0;
		$extra_line = [];
		while($i < ($length + 2)){
			$extra_line[] = 10;
			$i++;
		}

		$grid = [];
		$grid[] = $extra_line;

		foreach($lines as $line){
			$grid_line = [];
			$grid_line[] = 10;
			$numbers = str_split($line);

			foreach($numbers as $number){
				$grid_line[] = intval($number);
			}

			$grid_line[] = 10;

			$grid[] = $grid_line;
		}

		$grid[] = $extra_line;

		return $grid;
	}

	private function check_grid($grid){
		$total = 0;
		$l = 0;
		foreach($grid as $line){
			$c = 0;
			foreach($line as $number){
				if($number != 10){
					if( ($number < $grid[$l - 1][$c]) && ($number < $grid[$l + 1][$c]) && ($number < $grid[$l][$c - 1]) && ($number < $grid[$l][$c + 1]) ){
						$total += $grid[$l][$c] + 1;
					}
				}

				$c++;

			}
			$l++;
		}

		return $total;
	}
}
