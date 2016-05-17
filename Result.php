<?php
	class Result
	{
		private $title;
		private $link;
		private $summary;

		public function __construct($title, $link, $summary)
		{
			$this->title = $title;
			$this->link = $link;
			$this->summary = $summary;
		}

		public function getTitle()
		{
			return $this->title;
		}

		public function getLink()
		{
			return $this->link;
		}

		public function getSummary()
		{
			return $this->summary;
		}
	}