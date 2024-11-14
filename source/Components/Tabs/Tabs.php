<?php

namespace Source\Components\Tabs;

class Tabs
{
    protected array $tabs = [];

    public static function schema(array $tabs): self
    {
        $instance = new self();
        $instance->tabs = $tabs;
        return $instance;
    }

    public function render(): string
    {
        $tabsHtml = '';
        $panelsHtml = '';

        foreach ($this->tabs as $index => $tab) {
            $tabsHtml .= $tab->renderTab($index);
            $panelsHtml .= $tab->renderPanel($index);
        }

        return <<<HTML
            <div x-data="{ activeTab: 0 }">
                <!-- Tab List -->
                <ul class="flex my-3 bg-gray-100 rounded-lg p-0.5" role="tablist">
                    {$tabsHtml}
                </ul>

                <!-- Panels -->
                <div role="tabpanels" class="mt-4">
                    {$panelsHtml}
                </div>
            </div>
        HTML;
    }
}
