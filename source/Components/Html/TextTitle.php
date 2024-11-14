<?php

namespace Source\Components\Html;

class TextTitle
{

    public $title = '';
    public $subtitle = '';
    public $align = 'text-start';
    public function __construct(string $title){
        $this->title = $title;
    }

    public static function make(string $title): self
    {
        return new Self($title);
    }

    public function subtitle(string $subtitle)
    {
        $this->subtitle = <<<HTML
            <p class='mb-4 text-lg font-normal text-gray-700 '>{$subtitle}</p>
        HTML;
        return $this;
    }

    public function align(string $align)
    {
        $this->align = "text-{$align}";
        return $this;
    }

    public function render()
    {
        return <<<HTML
            <div class='{$this->align}'>
                <h2 class='text-2xl font-extrabold text-gray-800'>{$this->title}</h2>
                {$this->subtitle}
            </div>
        HTML;
    }
}