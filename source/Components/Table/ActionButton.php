<?php

namespace Source\Components\Table;

class ActionButton
{
    protected string $label;
    protected string $icon;
    protected $content;
    protected $url;
    protected bool $useModal = false;

    public static function make(): self
    {
        return new self();
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function icon(?string $icon = ''): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function content($content): self
    {
        $this->content = $content;
        $this->useModal = true;
        return $this;
    }

    public function url(callable|string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function render(object $record): string
    {
        $url = is_callable($this->url) ? call_user_func($this->url, $record) : $this->url;

        if ($url) {
            return "<a href=\"{$url}\"><i class=\"{$this->icon} text-decoration-none\"></i> {$this->label}</a>";
        }

        return '';
    }
}
