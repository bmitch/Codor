<?php declare(strict_types = 1);

class foo
{
	public function bar()
	{
		$oneIndentation;
		if (true) {
			$twoIndentation;
			if (true) {
				$threeIndentation;
			}
		}
	}
}