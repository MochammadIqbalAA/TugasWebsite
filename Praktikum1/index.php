<?php

namespace Library;


abstract class Book {
    protected $title;   
    protected $author;

    public function __construct($title, $author) {
        $this->title = $title;
        $this->author = $author;
    }

    abstract public function getCategory();

    public function __toString() {
        return "Title: $this->title, Author: $this->author";
    }
}


    trait BookDetails {
        public $year;
        public $pages;

        public function setDetails($year, $pages) {
            $this->year = $year;
            $this->pages = $pages;
        }

        public function getDetails() {
            return "Year: $this->year, Pages: $this->pages";    
        }
    }


class Novel extends Book {
    use BookDetails;

    public function getCategory() {
        return "Fiction";
    }

    public function __toString() {
        return parent::__toString() . ", " . $this->getDetails() . ", Category: " . $this->getCategory();
    }
}


$novel = new Novel("Bumi ", "Tere Liye ");
$novel->setDetails(2014, 440);

// Display novel information using __toString magic method
echo $novel;
?>
