<?php
namespace App\Entity;

class Puzzle {
	public $year;
	public $day;
	public $input;

	public function get_year(): string {
		return $this->year;
	}

	public function set_year( string $year ): void {
		$this->year = $year;
	}

	public function get_day(): string {
		return $this->day;
	}

	public function set_day( string $day ): void {
		$this->day = $day;
	}

	public function get_input(): string {
		return $this->input;
	}

	public function set_input( string $input ): void {
		$this->input = $input;
	}
}
