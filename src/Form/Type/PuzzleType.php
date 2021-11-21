<?php
namespace App\Form\Type;

use App\Entity\Puzzle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PuzzleType extends AbstractType {
	public function buildForm( FormBuilderInterface $builder, array $options ): void {
		$days = array(
			'choices' => array(
				'Day 1'  => 'D01',
				'Day 2'  => 'D02',
				'Day 3'  => 'D03',
				'Day 4'  => 'D04',
				'Day 5'  => 'D05',
				'Day 6'  => 'D06',
				'Day 7'  => 'D07',
				'Day 8'  => 'D08',
				'Day 9'  => 'D09',
				'Day 10' => 'D10',
				'Day 11' => 'D11',
				'Day 12' => 'D12',
				'Day 13' => 'D13',
				'Day 14' => 'D14',
				'Day 15' => 'D15',
				'Day 16' => 'D16',
				'Day 17' => 'D17',
				'Day 18' => 'D18',
				'Day 19' => 'D19',
				'Day 20' => 'D20',
				'Day 21' => 'D21',
				'Day 22' => 'D22',
				'Day 23' => 'D23',
				'Day 24' => 'D24',
				'Day 25' => 'D25',
			),
		);

		$years = array(
			'choices' => array(
				'2015' => 'Y2015',
				'2016' => 'Y2016',
				'2017' => 'Y2017',
				'2018' => 'Y2018',
				'2019' => 'Y2019',
				'2020' => 'Y2020',
				'2021' => 'Y2021',
			),
		);

		$builder
			->add( 'day', ChoiceType::class, $days )
			->add( 'year', ChoiceType::class, $years )
			->add( 'input', TextareaType::class )
			->add( 'save', SubmitType::class );
	}

	public function configureOptions( OptionsResolver $resolver ): void {
		$resolver->setDefaults(
			array(
				'data_class' => Puzzle::class,
			)
		);
	}
}
