<?php

class HeadController
{
    private string $pageTitle;
    private string $description;
    private string $keywords;
    private string $author;
    private array $cssFiles = [];
    private array $jsFiles = [];

    public function __construct(
        string $pageTitle = "Mon Site",
        string $description = "",
        string $keywords = "",
        string $author = "Fan2Jul",
        array $cssFiles = ["style.css"],
        array $jsFiles = []
    ) {
        $this->pageTitle = $pageTitle;
        $this->description = $description;
        $this->keywords = $keywords;
        $this->author = $author;
        $this->cssFiles = $cssFiles;
        $this->jsFiles = $jsFiles;
    }

    public function getPageTitle(): string { return $this->pageTitle; }
    public function getDescription(): string { return $this->description; }
    public function getKeywords(): string { return $this->keywords; }
    public function getAuthor(): string { return $this->author; }
    public function getCssFiles(): array { return $this->cssFiles; }
    public function getJsFiles(): array { return $this->jsFiles; }
}
