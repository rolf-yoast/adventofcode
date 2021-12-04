<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D04 extends AbstractController {
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

	public function puzzle1($puzzle){
		$numbers = $this->get_numbers($puzzle);
		$cards = $this->get_cards($puzzle);
		$card = $this->get_winning_line($numbers, $cards);
		dump($card);

		return ($card[0] + $card[1] + $card[2] + $card[3] + $card[4]) * $card['number'];
	}

	private function get_numbers($puzzle){
		$lines = explode( "\r\n", trim( $puzzle ) );

		return explode(',', $lines[0]);
	}

	private function get_cards($puzzle){
		$lines = explode( "\r\n\r\n", trim( $puzzle ) );

		unset($lines[0]);
		$cards = [];
		foreach($lines as $number){
			$number = trim(preg_replace('/\s\s+/', ' ', $number));
			$numbers = explode(' ', $number);

			$card = [];
			$i = 0;
			$c = 0;
			foreach($numbers as $number){
				$bla = floor($c / 5);
				$card['l'][$i][] = $number;
				$card['r'][$bla][$i] = $number;


				$i++;
				if($i === 5){
					$i = 0;
				}

				$c++;
			}

			$card['l'][0]['check'] = 0;
			$card['r'][0]['check'] = 0;
			$card['l'][1]['check'] = 0;
			$card['r'][1]['check'] = 0;
			$card['l'][2]['check'] = 0;
			$card['r'][2]['check'] = 0;
			$card['l'][3]['check'] = 0;
			$card['r'][3]['check'] = 0;
			$card['l'][4]['check'] = 0;
			$card['r'][4]['check'] = 0;
			$cards[] = $card;
		}
		return $cards;
	}

	private function get_winning_line($numbers, $cards){
		foreach($numbers as $number){
			$i = 0;
			foreach($cards as $card){
				$c = 0;
				$d = 0;
				foreach($card['r'] as $rows){
					$r = 0;
					foreach($rows as $rnumber){
						if($r < 5){
							if($rnumber === $number){
								$cards[$i]['r'][$c]['check']++;
							}
						}
						if($cards[$i]['r'][$c]['check'] === 5){
							$cards[$i]['r'][$c]['number'] = $number;
							return $cards[$i]['r'][$c];
						}
						$r++;
					}
					$c++;
				}
				foreach($card['l'] as $rows){
					$r = 0;
					foreach($rows as $rnumber){
						if($r < 5){
							if($rnumber === $number){
								$cards[$i]['l'][$d]['check']++;
							}
						}
						if($cards[$i]['l'][$d]['check'] === 5){
							$cards[$i]['l'][$d]['number'] = $number;
							return $cards[$i]['l'][$d];
						}
						$r++;
					}
					$d++;
				}
				$i++;
			}
		}
	}
}
