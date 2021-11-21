<?php
namespace App\Controller\Y2021;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class D17 extends AbstractController {
	public function puzzle( $puzzle ): Response {

		$answer1 = 'Empty solution 1';
		$answer2 = 'Empty solution 2';

		return $this->json(
			array(
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}
}
