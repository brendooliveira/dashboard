<?php

namespace Source\Components\Tabs;

class Tab
{
    protected string $name;
    protected string $label;
    protected string $icon;
    protected array $components = [];

    public static function make(string $name): self
    {
        $instance = new self();
        $instance->name = $name;
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function schema(array $components): self
    {
        $this->components = $components;
        return $this;
    }

    public function renderTab(int $index): string
    {
        return <<<HTML
            <li class="mr-2">
                <button
                    @click="activeTab = {$index}"
                    :aria-selected="activeTab === {$index}"
                    :class="{'bg-white rounded': activeTab === {$index}, 'text-gray-600 hover:text-gray-800': activeTab !== {$index}}"
                    class="py-2 px-4 focus:outline-none"
                    role="tab">
                    <i class="{$this->icon} mr-2"></i>
                    <span>{$this->label}</span>
                </button>
            </li>
        HTML;
    }

    public function renderPanel(int $index): string
    {
        $componentsHtml = implode('', array_map(fn($component) => $component->render(), $this->components));

        return <<<HTML
            <section
                x-show="activeTab === {$index}"
                role="tabpanel"
                class="pt-4">
                {$componentsHtml}
            </section>
        HTML;
    }
}