<?php
	class Result
	{
		private $title;
		private $filename;
		private $summary;


		public function __construct($title, $filename, $summary)
		{
			$this->title = $title;
			$this->filename = $filename;
			$this->summary = $summary;
		}

		public function getTitle()
		{
			return $this->title;
		}

		public function getFilename()
		{
			return $this->filename;
		}

		public function getSummary()
		{
			return $this->summary;
		}

	}