<?php
namespace App\Controller\Y2021;

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

	public function puzzle1( $puzzle ) {
		$numbers = $this->get_numbers( $puzzle );
		$cards   = $this->get_cards( $puzzle );
		return $this->fill_card( $numbers, $cards );
	}

	public function puzzle2( $puzzle ) {
		$numbers = $this->get_numbers( $puzzle );
		$cards   = $this->get_cards( $puzzle );
		return $this->fill_cards( $numbers, $cards );

	}

	private function get_numbers( $puzzle ) {
		$lines = explode( "\r\n", trim( $puzzle ) );

		return explode( ',', $lines[0] );
	}

	private function get_cards( $puzzle ) {
		$lines = explode( "\r\n\r\n", trim( $puzzle ) );

		unset( $lines[0] );
		$cards = array();
		foreach ( $lines as $number ) {
			$number  = trim( preg_replace( '/\s\s+/', ' ', $number ) );
			$numbers = explode( ' ', $number );

			$card = array();
			$i    = 0;
			$c    = 0;
			foreach ( $numbers as $number ) {
				$bla                          = floor( $c / 5 );
				$card[ $bla ][ $i ]['number'] = $number;
				$card[ $bla ][ $i ]['value']  = 0;

				$i++;
				if ( $i === 5 ) {
					$i = 0;
				}

				$c++;
			}

			$cards[] = $card;
		}
		return $cards;
	}

	private function fill_card( $numbers, $cards ) {
		foreach ( $numbers as $number ) {
			$i = 0;
			foreach ( $cards as $card ) {
				$c = 0;
				foreach ( $card as  $row ) {
					$d = 0;
					foreach ( $row as $value ) {
						if ( $number === $value['number'] ) {
							$cards[ $i ][ $c ][ $d ]['value'] = 1;

							$winner = $this->check_if_winner( $cards[ $i ] );

							if ( $winner == 1 ) {
								return $this->calculate_score( $cards[ $i ], $number );
							}
						}
						$d++;
					}
					$c++;
				}
				$i++;
			}
		}

		return 1;
	}

	private function fill_cards( $numbers, $cards ) {
		$i = 0;
		foreach ( $cards as $card ) {
			$cards[ $i ]['full'] = 0;
			$i++;
		}
		$amount_cards = count( $cards );

		foreach ( $numbers as $number ) {
			$i = 0;
			foreach ( $cards as $card ) {

				$c = 0;

				unset( $card['full'] );

				foreach ( $card as  $row ) {
					$d = 0;
					foreach ( $row as $value ) {
						if ( $number === $value['number'] ) {
							$cards[ $i ][ $c ][ $d ]['value'] = 1;

							$winner = $this->check_if_winner( $cards[ $i ] );
							if ( $winner === 1 ) {
								$cards[ $i ]['full'] = 1;

							}
							$count = 0;
							foreach ( $cards as $something ) {
								if ( $something['full'] === 1 ) {
									$count++;
								}
							}

							if ( $count == $amount_cards ) {

								return $this->calculate_score( $cards[ $i ], $number );
							}
						}
						$d++;
					}
					$c++;
				}

				$i++;
			}
		}
		return 'found nothing';
	}

	private function check_if_winner( $card ) {

		if ( isset( $card['full'] ) ) {
			unset( $card['full'] );
		}

		foreach ( $card as $row ) {
			$count = 0;
			foreach ( $row as $value ) {

				if ( $value['value'] === 1 ) {

					$count++;
				}
				if ( $count === 5 ) {
					return 1;
				}
			}
		}

		$i = 0;
		while ( $i < 5 ) {
			$c     = 0;
			$count = 0;
			while ( $c < 5 ) {
				if ( $card[ $c ][ $i ]['value'] === 1 ) {
					$count++;
				}
				$c++;
			}
			if ( $count === 5 ) {
				return 1;
			}

			$i++;
		}

		return 0;
	}

	private function calculate_score( $card, $number ) {
		if ( isset( $card['full'] ) ) {
			unset( $card['full'] );
		}

		$total = 0;
		foreach ( $card as $row ) {
			foreach ( $row as $item ) {
				if ( $item['value'] == 0 ) {
					$total = $total + intval( $item['number'] );
				}
			}
		}

		return $total * intval( $number );
	}
}
