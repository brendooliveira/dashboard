<?php

namespace Source\Dash;

class Page
{
    protected string $title = '';
    protected string $url = '';
    protected string $icon = '';
    protected static string|array $content;

    public static function init(): self
    {
        return new static();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public static function render(string|array $content, ?string $title = ''): string
    {
        $content = is_array($content) ? implode($content) : $content;
        return Dash::render(
            <<<HTML
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">{$title}</h2>
                    {$content}
                </div>
            HTML
        );
    }
}
 