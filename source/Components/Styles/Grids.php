<?php

namespace Source\Components\Styles;

class Grids
{
    protected array $grids;

    public static function schema(array $grids): self
    {
        return new self($grids);
    }

    protected function __construct(array $grids)
    {
        $this->grids = $grids;
    }

    public function render(): string
    {
        $gridsHtml = implode('', array_map(fn($grid) => $grid, $this->grids));

        return <<<HTML
            <div class="grid grid-cols-12 gap-4">
                {$gridsHtml}
            </div>
        HTML;
    }
}
