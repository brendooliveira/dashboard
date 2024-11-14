<?php

namespace Source\Components\Card;

class Card
{
    public $icon = '';
    public $value = '';
    public $description = '';
    public $colorIcon = 'gray-100';
    public $color = 'gray-100';
    public $id = '';

    public static function make(?string $id = ''): self
    {
        $instance = new self();
        $instance->id = $id;
        return $instance;
    }

    public function icon(string $icon, ?string $color = 'gray-100')
    {
        $this->colorIcon = $color;
        $this->icon = "<i class='$icon text-$color'></i>";
        return $this;
    }

    public function value(string $value)
    {
        $this->value = $value;
        return $this;
    }

    public function color(string $color)
    {
        $this->color = $color;
        return $this;
    }

    public function description(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function render()
    {
        return <<<HTML
            <div class="w-full mt-3 {$this->id}">
                <div class="flex items-center border-b-2 border-b-{$this->color} px-5 py-6 bg-white rounded-md shadow">
                    <div class="py-3 {$this->colorIcon} bg-opacity-75 rounded">
                        {$this->icon}
                    </div>
                    <div class="mx-5">
                        <h4 class="text-2xl font-semibold text-gray-700">{$this->value}</h4>
                        <div class="text-gray-500">{$this->description}</div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
