<?php

namespace Source\Components\Menu;


class Menu
{
    protected array $items = [];

    public static function schema(array $items): self
    {
        return new self($items);
    }

    protected function __construct(array $items)
    {
        $this->items = $items;
    }

    public function render(): string
    {
        $itemsHtml = array_reduce($this->items, function ($html, Item $item) {
            return $html . $item->render();
        }, '');

        return <<<HTML
            <nav class="bg-white mt-3 shadow-lg rounded-lg p-4">
                <ul class="space-y-2">
                    {$itemsHtml}
                </ul>
            </nav>
        HTML;
    }
}