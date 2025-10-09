<?php

namespace controllers;
class HeadController
{
    private string $pageTitle;
    private string $description;
    private string $keywords;
    private string $author;
    private array $cssFiles = [];
    
    public function __construct(string $pageTitle, string $description, string $keywords, string $author, array $cssFiles = []){
        $this->pageTitle = $pageTitle;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->author = $author;
        $this->cssFiles = $cssFiles;
    }
    
    public function getPageTitle(): string { return $this->pageTitle; }
    public function getDescription(): string { return $this->description; }
    public function getKeywords(): string { return $this->keywords; }
    public function getAuthor(): string { return $this->author; }
    public function getCssFiles(): array { return $this->cssFiles; }

}
