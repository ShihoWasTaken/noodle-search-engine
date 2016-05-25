<?php
	class Result
	{
		private $title;
		private $filename;
		private $summary;
		private $TFIDF;


		public function __construct($title, $filename, $summary, $TFIDF)
		{
			$this->title = $title;
			$this->filename = $filename;
			$this->summary = $summary;
			$this->TFIDF = $TFIDF;
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

		public function getTFIDF()
		{
			return $this->TFIDF;
		}
	}