<?php

namespace Source\Components\Table;

class Table
{
    protected array $data = [];
    protected array $columns = [];
    protected array $actions = [];
    protected string $headerContent = '';
    protected $rowClass;
    protected string $footerContent = '';
    protected string $tailwindCdn = '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
    protected string $alpineCdn = '<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js" defer></script>';
    protected string $fontAwesomeCdn = '<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">';
    protected string $font = ''; // Classe para definir a fonte

    public function __construct()
    {
        echo $this->tailwindCdn;
        echo $this->alpineCdn;
        echo $this->fontAwesomeCdn; // Inclui o CDN do Font Awesome
    }

    public static function make(): self
    {
        return new self();
    }


    public function data(array|object $data): self
    {
        if (is_array($data)) {
            $this->data = array_map(fn($item) => (object) $item, $data);
        } else {
            $this->data = [$data];
        }
        return $this;
    }

    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function actions(array $actions): self
    {
        $this->actions = $actions;
        return $this;
    }

    public function headerContent(string $content): self
    {
        $this->headerContent = $content;
        return $this;
    }

    public function footerContent(string $content): self
    {
        $this->footerContent = $content;
        return $this;
    }

    public function font(string $font): self
    {
        $this->font = "font-family: '{$font}', sans-serif;";
        return $this;
    }

    public function rowClass(string|callable $class)
    {
        $this->rowClass = $class;
        return $this;
    }

    public function render() {
        // Gera o HTML da tabela com o novo estilo
        return <<<HTML
        <div class="flex flex-col mt-3" style="{$this->font}">
            {$this->headerContent}
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                {$this->renderHeaders()}
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            {$this->renderRows()}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{$this->getColumnCount()}" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    {$this->footerContent}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        HTML;
    }

    protected function renderHeaders() {
        $headersHtml = '';
        foreach ($this->columns as $column) {
            $label = htmlspecialchars($column->getLabel());
            $headersHtml .= <<<HTML
                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                    {$label}
                </th>
            HTML;
        }

        if (!empty($this->actions)) {
            $headersHtml .= <<<HTML
                <th class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                    Actions
                </th>
            HTML;
        }

        return $headersHtml;
    }
    

    protected function renderRows() {
        $rowsHtml = '';
        foreach ($this->data as $row) {
            $class = $this->rowClass ? call_user_func($this->rowClass, $row) : '';
            $rowsHtml .= <<<HTML
                <tr class="{$class}">
                    {$this->renderRow($row)}
                </tr>
            HTML;
        }
        return $rowsHtml;
    }

    protected function renderRow($row) {
        $rowHtml = '';
        foreach ($this->columns as $column) {
            $rowHtml .= $column->render($row);
        }

        if (!empty($this->actions)) {
            $rowHtml .= $this->renderActions($row);
        }

        return $rowHtml;
    }

    protected function renderActions($row) {

        $actionsHtml = '<td class="px-6  py-4 whitespace-nowrap text-right text-sm font-medium ">';
            $actionsHtml .= '<div class="flex space-x-2">'; //
            foreach ($this->actions as $action) {
                $actionsHtml .= $action->render($row);
            }
            $actionsHtml .= "</div>";
        $actionsHtml .= "</td>";
        
        return $actionsHtml;
    }

    protected function getColumnCount() {
        return count($this->columns) + (empty($this->actions) ? 0 : 1);
    }
}
