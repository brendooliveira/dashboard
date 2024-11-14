<?php

namespace Source\Components\Menu;

class Item
{
    protected string $label;
    protected string $url;
    protected ?string $icon = null;

    public static function make(string $label): self
    {
        return new self($label);
    }

    protected function __construct(string $label)
    {
        $this->label = $label;
    }

    public function url(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function render(): string
    {
        $iconHtml = $this->icon ? "<i class=\"{$this->icon} mr-2\"></i>" : '';
        return <<<HTML
            <a href="{$this->url}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-md">
                {$iconHtml}
                {$this->label}
            </a>
        HTML;
    }
}
