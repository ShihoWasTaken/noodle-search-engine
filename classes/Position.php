<?php
	class Position
	{
		private $document;
		private $position;


		public function __construct($document, $position)
		{
			$this->document = $document;
			$this->position = $position;
		}

		public function getDocument()
		{
			return $this->document;
		}

		public function getPosition()
		{
			return $this->position;
		}

	}