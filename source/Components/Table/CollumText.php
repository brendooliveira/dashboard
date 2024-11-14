<?php

namespace Source\Components\Table;

class CollumText
{
    protected string $key;
    protected string $label = '';
    protected $class;
    protected $recordCallback;
    protected $badge;

    public static function make(string $key): self
    {
        $instance = new self();
        $instance->key = $key;
        return $instance;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function class(callable|string $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function record(callable $callback): self
    {
        $this->recordCallback = $callback;
        return $this;
    }

    public function badge(string|callable $badge): self
    {
        $this->badge = $badge;
        return $this;
    }

    public function render($record)
    {
        $value = $record->{$this->key};
        $class = is_callable($this->class) ? call_user_func($this->class, $record) : $this->class;
        $badge = is_callable($this->badge) ? call_user_func($this->badge, $record) : $this->badge ?? '';

        $badgeClasses = [
            'success' => 'bg-green-100 text-green-800',
            'danger'  => 'bg-red-100 text-red-800',
            'primary' => 'bg-blue-100 text-blue-800',
        ];
    
        $badgeClass = $badgeClasses[$badge] ?? '';

        if ($this->recordCallback) {
            $value = call_user_func($this->recordCallback, $record);
        }
        
        $badgeElement = $badgeClass ? "inline-block px-2 py-1 text-xs font-semibold rounded-full {$badgeClass}" : '';

        return <<<HTML
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 {$class}">
                <span class="{$badgeElement}">{$value}</span>
            </td>
        HTML;
    }


    public function getLabel(): string
    {
        return $this->label;
    }
}