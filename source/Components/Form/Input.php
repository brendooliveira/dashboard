<?php

namespace Source\Components\Form;

class Input
{
    protected string $name;
    protected string $type;
    protected string $value = '';
    protected string $label = '';
    protected bool $required = false;
    protected array $options = [];
    protected ?\Closure $dataOption = null;
    protected ?string $icon = null;
    protected bool $isTagsInput = false;

    public static function make(string $name, string $type = 'text'): self
    {
        return new self($name, $type);
    }

    protected function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function required(bool $required = true): self
    {
        $this->required = $required;
        return $this;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function dataOption($dataOption): self
    {
        if (is_callable($dataOption)) {
            $this->dataOption = $dataOption;
        } elseif (is_array($dataOption)) {
            $this->options = $dataOption;
        }
        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function tags(bool $isTagsInput = true): self
    {
        $this->isTagsInput = $isTagsInput;
        return $this;
    }

    public function render(): string
    {
        $required = $this->required ? 'required' : '';
        $options = $this->dataOption ? ($this->dataOption)() : $this->options;
        $optionsAttr = '';

        foreach ($options as $key => $value) {
            $optionsAttr .= "$key=\"$value\" ";
        }

        $iconHtml = $this->icon ? "<span class=\"absolute inset-y-0 left-0 flex items-center pl-3\"><i class=\"{$this->icon} text-gray-400\"></i></span>" : '';

        if ($this->isTagsInput) {
            return $this->renderTagsInput($optionsAttr, $required, $iconHtml);
        }
        $label = $this->label ?? $this->name;
        $pl_10 = $iconHtml ? 'pl-10' : '';
        return <<<HTML
            <div class="mb-4">
                <label for="{$label}" class="block text-sm font-medium text-gray-700">{$this->label}</label>
                <div class="relative">
                    {$iconHtml}
                    <input 
                        type="{$this->type}" 
                        name="{$this->name}" 
                        id="{$this->name}" 
                        value="{$this->value}" 
                        {$optionsAttr}{$required}
                        class="mt-1 block w-full px-3 {$pl_10} py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
            </div>
        HTML;
    }

    protected function renderTagsInput(string $optionsAttr, string $required, string $iconHtml): string
    {
        $pl_10 = $iconHtml ? 'pl-10' : '';
        return <<<HTML
            <div x-data="tagsInput()" class="mb-4">
                <label for="{$this->name}" class="block text-sm font-medium text-gray-700">{$this->label}</label>
                <div class="relative mt-1 flex items-center">
                    {$iconHtml}
                    <input 
                        type="text" 
                        x-model="tagInput" 
                        @keydown.enter.prevent="addTag" 
                        @keydown.backspace="removeTagOnBackspace"
                        id="{$this->name}" 
                        placeholder="Adicione as tags" 
                        class="block w-full {$pl_10} px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        {$optionsAttr}{$required}
                    />
                    <input type="hidden" name="{$this->name}" :value="tags.join(',')">
                </div>
                <div class="mt-2 flex flex-wrap">
                    <template x-for="(tag, index) in tags" :key="index">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium mr-2 mb-2 px-2.5 pt-1 pb-2 rounded">
                            <span x-text="tag"></span>
                            <button type="button" @click="removeTag(index)" class="ml-1 text-indigo-500 hover:text-indigo-900">
                                &times;
                            </button>
                        </span>
                    </template>
                </div>
            </div>

            <script>
                function tagsInput() {
                    return {
                        tagInput: '',
                        tags: {$this->formatTagsForAlpine()},
                        addTag() {
                            if (this.tagInput.trim() !== '' && !this.tags.includes(this.tagInput.trim())) {
                                this.tags.push(this.tagInput.trim());
                            }
                            this.tagInput = '';
                        },
                        removeTag(index) {
                            this.tags.splice(index, 1);
                        },
                        removeTagOnBackspace() {
                            if (this.tagInput === '') {
                                this.tags.pop();
                            }
                        }
                    }
                }
            </script>
        HTML;
    }

    protected function formatTagsForAlpine(): string
    {
        $tagsArray = explode(',', $this->value);
        $tagsArray = array_map('trim', $tagsArray);
        return json_encode($tagsArray);
    }
}
