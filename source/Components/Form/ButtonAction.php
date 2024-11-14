<?php

namespace Source\Components\Form;

class ButtonAction
{
    protected string $label;
    protected ?string $method = null;
    protected ?string $actionUrl = null;
    protected array $data = [];
    protected ?string $modalContent = null;
    protected bool $confirm = false;
    protected string $confirmMessage = 'Are you sure?';
    protected string $messageSuccess = 'Action completed successfully.';
    protected string $color = 'orange';
    protected ?string $alertMessage = null;
    protected string $alertType = 'teal';

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public static function make(string $label): self
    {
        return new self($label);
    }

    public function post(string $url): self
    {
        $this->method = 'POST';
        $this->actionUrl = $url;
        return $this;
    }

    public function get(string $url): self
    {
        $this->method = 'GET';
        $this->actionUrl = $url;
        return $this;
    }

    public function data(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function modal(string $content): self
    {
        $this->modalContent = $content;
        return $this;
    }

    public function confirm(bool $confirm, ?string $confirmMessage = 'Are you sure?'): self
    {
        $this->confirm = $confirm;
        $this->confirmMessage = $confirmMessage;
        return $this;
    }

    public function messageSuccess(string $message): self
    {
        $this->alertMessage = $message;
        return $this;
    }

    public function alertType(string $type): self
    {
        $this->alertType = $type;
        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function render(): string
    {
        $dataAttributes = htmlspecialchars(json_encode($this->data), ENT_QUOTES, 'UTF-8');
        $hasAction = $this->method && $this->actionUrl;
        $click = $this->confirm ? 'openConfirmModal = true' : ($hasAction ? 'submitForm()' : 'openModal = true');

        return <<<HTML
            <div x-data="{
                    openModal: false,
                    openConfirmModal: false,
                    showAlert: false,
                    async submitForm() {
                        try {
                            const response = await fetch('{$this->actionUrl}', {
                                method: '{$this->method}',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({$dataAttributes}),
                            });

                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }

                            const result = await response.json();
                            this.showAlert = true;

                            setTimeout(() => {
                                this.showAlert = false;
                            }, 3000);
                        } catch (error) {
                            console.error('Error:', error);
                        }
                    },
                    confirmAction() {
                        this.openConfirmModal = false;
                        this.submitForm();
                    },
                    init() {
                        if (!{$hasAction} && this.modalContent) {
                            this.openModal = true;
                        }
                    }
                }">
                <button
                    class="
                    inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-{$this->color}-600 hover:bg-{$this->color}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{$this->color}-500
                    "
                    @click="{$click}"
                >
                    {$this->label}
                </button>

                <template x-if="openModal">
                    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
                        <div class="bg-white p-4 rounded">
                            {$this->modalContent}
                            <button @click="openModal = false" class="mt-4 px-4 py-2 bg-gray-200 rounded">Close</button>
                        </div>
                    </div>
                </template>

                <template x-if="openConfirmModal">
                    <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
                        <div class="bg-white p-4 rounded">
                            <p>{$this->confirmMessage}</p>
                            <div class="mt-4">
                                <button @click="confirmAction()" class="px-4 py-2 bg-blue-500 text-white rounded">Confirm</button>
                                <button @click="openConfirmModal = false" class="ml-2 px-4 py-2 bg-gray-200 rounded">Cancel</button>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="showAlert">
                    <div class="bg-{$this->alertType}-100 border-t-4 border-{$this->alertType}-500 rounded-b text-{$this->alertType}-900 px-4 py-3 shadow-md mt-4" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-{$this->alertType}-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Success</p>
                                <p class="text-sm">{$this->alertMessage}</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        HTML;
    }
}
