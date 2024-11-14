<?php

namespace Source\Components\Styles;

class Grid
{
    protected array $schema;
    protected int $columns;

    public static function schema(array $schema): self
    {
        return new self($schema);
    }

    protected function __construct(array $schema)
    {
        $this->schema = $schema;
    }

    public function collum(int $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function render(): string
    {
        $fieldsHtml = implode('', array_map(fn($field) => $field->render(), $this->schema));

        // Definindo as classes responsivas para diferentes tamanhos de tela
        $responsiveClasses = "col-span-12 sm:col-span-12 md:col-span-{$this->columns} lg:col-span-{$this->columns} xl:col-span-{$this->columns}";

        return <<<HTML
            <div class="{$responsiveClasses}">
                {$fieldsHtml}
            </div>
        HTML;
    }
}
