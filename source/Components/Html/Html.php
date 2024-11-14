<?php

namespace Source\Components\Html;

class Html
{
    public string $content;
    public function view(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function render(): string
    {
        return $this->content;
    }


}