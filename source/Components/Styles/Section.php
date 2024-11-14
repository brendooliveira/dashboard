<?php

namespace Source\Components\Styles;

class Section
{
    protected array $schema;

    public static function schema(array $schema): self
    {
        return new self($schema);
    }

    protected function __construct(array $schema)
    {
        $this->schema = $schema;
    }

    public function render(): string
    {
        $fieldsHtml = implode('', array_map(fn($field) => $field->render(), $this->schema));
        return <<<HTML
            <section class="bg-white shadow-lg mt-3 p-5 rounded">
                {$fieldsHtml}
            </section>
        HTML;
        }

    
}