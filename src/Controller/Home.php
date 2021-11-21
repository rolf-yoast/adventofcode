<?php
namespace App\Controller;

use App\Entity\Puzzle;
use App\Form\Type\PuzzleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class Home extends AbstractController {
	/**
	 * @Route("/")
	 */
	public function new( Request $request ): Response {
		$puzzle = new Puzzle();

		$answer1 = '';
		$answer2 = '';

		$form = $this->createForm( PuzzleType::class, $puzzle );

		$form->handleRequest( $request );
		if ( $form->isSubmitted() && $form->isValid() ) {
			// $form->getData() holds the submitted values
			// but, the original `$task` variable has also been updated
			$puzzle = $form->getData();

			$response  = $this->forward( 'App\Controller\\' . $puzzle->year . '\\' . $puzzle->day . '::puzzle', array( 'puzzle' => $puzzle->input ) );
			$solutions = json_decode( $response->getContent(), true );

			$answer1 = $solutions['answer1'];
			$answer2 = $solutions['answer2'];
		}

		return $this->renderForm(
			'base.html.twig',
			array(
				'form'    => $form,
				'answer1' => $answer1,
				'answer2' => $answer2,
			)
		);
	}
}
