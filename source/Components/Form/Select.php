<?php

namespace Source\Components\Form;

class Select
{
    protected string $name;
    protected array $options = [];
    protected string $label = '';
    protected ?string $selected = null;
    protected ?string $icon = null;
    protected bool $searchable = false;

    public static function make(string $name): self
    {
        return new self($name);
    }

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function options($options): self
    {
        if (is_callable($options)) {
            $this->options = $options();
        } elseif (is_array($options)) {
            $this->options = $options;
        }
        return $this;
    }

    public function select(string $value): self
    {
        $this->selected = $value;
        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function searchable(bool $searchable = true): self
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function render(): string
    {
        $optionsHtml = '';
        foreach ($this->options as $key => $value) {
            $selected = $key == $this->selected ? 'selected' : '';
            $optionsHtml .= sprintf('<option value="%s" %s>%s</option>', $key, $selected, $value);
        }

        $iconHtml = $this->icon ? "<span class=\"absolute inset-y-0 left-0 flex items-center pl-3\"><i class=\"{$this->icon} text-gray-400\"></i></span>" : '';
        $pl_10 = $iconHtml ? 'pl-10' : '';

        // HTML do Select
        $selectHtml = <<<HTML
            <div class="mb-4">
                <label for="{$this->name}" class="block text-sm font-medium text-gray-700">{$this->label}</label>
                <div class="relative">
                    {$iconHtml}
                    <select name="{$this->name}" id="{$this->name}" class="mt-1 block w-full px-3 {$pl_10} py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option></option>
                        {$optionsHtml}
                    </select>
                </div>
            </div>
        HTML;

        // Se for pesquisável, inclui o Select2, traduz para português, e ajusta o estilo
        if ($this->searchable) {
            $selectHtml .= <<<HTML
                <!-- Select2 CSS -->
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

                <!-- Custom Select2 Style to Match Tailwind -->
                <style>
                    .select2-container .select2-selection--single {
                        height: 2.5rem; /* Tailwind's h-10 */
                        padding: 0.5rem 2.5rem 0.5rem 0.75rem; /* px-3 and pr-10 */
                        border-color: #d1d5db; /* Tailwind's border-gray-300 */
                        border-radius: 0.375rem; /* Tailwind's rounded-md */
                        display: flex;
                        align-items: center;
                    }

                    .select2-container--default .select2-selection--single .select2-selection__rendered {
                        color: #374151; /* Tailwind's text-gray-700 */
                        line-height: 1.25rem; /* Tailwind's leading-5 */
                        font-size: 0.875rem; /* Tailwind's text-sm */
                        /* Compensa a posição do ícone */
                         /* Compensa a posição da seta */
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    .select2-container--default .select2-selection--single .select2-selection__arrow {
                        top: 50%;
                        transform: translateY(-50%);
                        right: 0.75rem; /* Tailwind's pr-3 */
                    }

                    .select2-container--default .select2-selection--single .select2-selection__placeholder {
                        color: #9ca3af; /* Tailwind's text-gray-400 */
                    }

                    .select2-results__option {
                        padding: 0.5rem 1rem; /* Tailwind's px-4 py-2 */
                        color: #374151; /* Tailwind's text-gray-700 */
                    }

                    .select2-search--dropdown .select2-search__field {
                        padding: 0.5rem; /* Tailwind's p-2 */
                        border-radius: 0.375rem; /* Tailwind's rounded-md */
                        border-color: #d1d5db; /* Tailwind's border-gray-300 */
                        width: 100%;
                    }

                    .select2-dropdown {
                        border-color: #d1d5db; /* Tailwind's border-gray-300 */
                        border-radius: 0.375rem; /* Tailwind's rounded-md */
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Tailwind's shadow */
                    }
                </style>

                <!-- jQuery and Select2 JS -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                <!-- Tradução para Português -->
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pt-BR.js"></script>

                <!-- Initialize Select2 with Custom Settings -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const selectElement = document.getElementById('{$this->name}');
                        if (selectElement) {
                            $(selectElement).select2({
                                language: "pt-BR",
                                width: '100%',
                                placeholder: 'Selecione uma opção',
                                allowClear: true,
                                dropdownCssClass: 'select2-dropdown-tailwind',
                                templateResult: function (data) {
                                    if (!data.id) {
                                        return data.text;
                                    }
                                    var iconHtml = '';
                                    var result = $(
                                        '<span>' + iconHtml + data.text + '</span>'
                                    );
                                    return result;
                                },
                                templateSelection: function (data) {
                                    if (!data.id) {
                                        return data.text;
                                    }
                                    var iconHtml =  '';
                                    return $('<span>' + iconHtml + data.text + '</span>');
                                }
                            });
                        }
                    });
                </script>
            HTML;
        }

        return $selectHtml;
    }
}
