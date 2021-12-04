<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D03 extends AbstractController {

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

		$amount = strlen($lines[0]);

		$array = [];

		foreach($lines as $line){
			$letters = str_split($line);

			$i = 0;
			while($i < $amount){
				$array[$i][] = $letters[$i];
				$i++;
			}
		}

		$high = '';
		$low = '';

		foreach($array as $rows){
			$h = 0;
			$l = 0;

			foreach($rows as $row){
				if($row == 0){
					$l++;
				}

				if($row == 1){
					$h++;
				}
			}

			if($h > $l){
				$high .= '1';
				$low .= '0';
			}

			if($h < $l){
				$high .= '0';
				$low .= '1';
			}
		}

		return bindec($high) * bindec($low);
	}

	public function puzzle2($puzzle) {
		$lines = explode( "\r\n", trim( $puzzle ) );
		$solver = new RatingGenerator();
		$oxyBit = bindec( $solver->getOxyGenBit( $lines ) );
		$co2    = bindec( $solver->getCo2GenBit( $lines ) );
		return ( $oxyBit * $co2 );
	}
}


class RatingGenerator {

	public function getOxyGenBit( array $bits ): string {
		$bitAmounts = $this->countBitAmount($bits);
		return $this->calculateOxyArray($bits,$bitAmounts,0);
	}

	private function calculateOxyArray(array $bits, array $bitAmounts, int $index): string{
		if(count($bits) === 1){
			return $bits[0];
		}
		$bitToKeep =  $bitAmounts[$index][0] > $bitAmounts[$index][1] ? '0' : '1';
		$keep = [];

		foreach ($bits as $bit){
			if($bit[$index] === $bitToKeep){
				$keep[] = $bit;
			}
		}

		$index++;
		return $this->calculateOxyArray($keep,$this->countBitAmount($keep),$index );
	}
	public function getCo2GenBit( array $bits ): string {
		$bitAmounts = $this->countBitAmount($bits);
		return $this->calculateCo2Array($bits,$bitAmounts,0);
	}

	private function calculateCo2Array(array $bits, array $bitAmounts, int $index): string{
		if(count($bits) === 1){
			return $bits[0];
		}
		$bitToKeep =  $bitAmounts[$index][0] <= $bitAmounts[$index][1] ? '0' : '1';
		$keep = [];

		foreach ($bits as $bit){
			if($bit[$index] === $bitToKeep){
				$keep[] = $bit;
			}
		}

		$index++;
		return $this->calculateCo2Array($keep,$this->countBitAmount($keep),$index );
	}
	private function countBitAmount($bits): array {
		for($i = 0; $i <= 11; $i++){
			$map[ $i ] = [];
			$map[ $i ][] = 0;
			$map[ $i ][] = 0;
			foreach ( $bits as $bit ) {
				if ( $bit[$i] == 1 ) {
					$map[ $i ][1] ++;
				} else {
					$map[ $i ][0] ++;
				}
			}
		}
		return $map;
	}
}
