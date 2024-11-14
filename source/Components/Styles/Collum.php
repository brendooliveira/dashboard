<?php

namespace Source\Components\Styles;

class Collum
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
        $colWidth = 12 / $this->columns;
        $fieldsHtml = implode('', array_map(fn($field) => $field->render(), $this->schema));
        $collum = $this->columns > 1 ? $this->columns / 2 : 1;

        return <<<HTML
            <div class="grid sm:grid-cols-1 flex-wrap xl:grid-cols-{$this->columns} md:grid-cols-{$collum} gap-4">
                {$fieldsHtml}
            </div>
        HTML;

        //return sprintf('<div class="grid sm:grid-cols-1 flex-wrap xl:grid-cols-%d md:grid-cols-%d gap-4">%s</div>', $this->columns, $this->columns > 1 ? $this->columns / 2 : 1 ,$fieldsHtml);
    }

    
}