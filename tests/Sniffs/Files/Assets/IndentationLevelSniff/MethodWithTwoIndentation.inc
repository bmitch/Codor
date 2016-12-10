<?php

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