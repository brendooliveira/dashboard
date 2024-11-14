<?php

namespace Source\Components\Form;

class Form
{
    protected string $action;
    protected string $method;
    protected array $content = [];
    protected string $buttom = 'Enviar';
    protected string $formClasses = 'space-y-6';

    public function __construct(string $action = '', string $method = 'POST')
    {
        $this->action = $action;
        $this->method = $method;
    }

    public static function make(string $action = '', string $method = 'POST'): self
    {
        return new self($action, $method);
    }


    public function add($element): self
    {
        $this->content[] = $element;
        return $this;
    }

    public function buttom(string $buttom)
    {
        $this->buttom = $buttom;
        return $this;
    }

    public function setFormClasses(string $classes): self
    {
        $this->formClasses = $classes;
        return $this;
    }

    public function render(): string
    {
        $contentHtml = implode('', array_map(fn($element) => $element->render(), $this->content));
        
        return <<<HTML
            <form action="{$this->action}" method="{$this->method}" class="{$this->formClasses}">
                {$contentHtml}
                <div class="mt-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {$this->buttom}
                    </button>
                </div>
            </form>
        HTML;
    }
}