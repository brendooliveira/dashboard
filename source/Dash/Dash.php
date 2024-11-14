<?php

namespace Source\Dash;

class Dash
{
    protected static array $pages = [];

    protected static array $menu = [];

    protected static string $favicon = '';

    protected static string $title = 'Meu Dash';

    public static function init(array $pages): self
    {
        self::$pages = $pages;
        return new static();
    }

    public static function renderPage(string $content): string
    {
        return (new static())->theme($content);
    }

    public static function favicon(?string $icon = ''): self
    {
        self::$favicon = <<<HTML
          <link rel="shortcut icon" href="{$icon}" type="image/png">
        HTML;

        return new static();
    }

    public static function title(?string $title = ''): self
    {
        self::$title = $title;
        return new static();
    }

    public static function menuItems(?array $menu)
    {
        self::$menu = $menu;
        return new static();
    }

    protected function theme(string $content): string
    {
        $icon = self::$favicon;
        $title = self::$title;
        return <<<HTML
            <!doctype html>
            <html lang="pt-br">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link href="https://cdn.tailwindcss.com" rel="stylesheet">
                <script src="https://cdn.tailwindcss.com"></script>
                {$icon} 
                <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
            </head>
            <body>
                <div>
                <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
                
                <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
                    <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
                
                    <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed inset-y-0 left-0 z-30 w-80 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0">
                        <div class="flex items-center justify-start mx-3 mt-8">
                            <div class="flex items-center">
                                <span class="text-2xl mx-3 font-semibold text-white">$title</span>
                            </div>
                        </div>
                
                        <nav class="mt-10">
                            {$this->renderLinks()}
                        </nav>
                    </div>
                    
                    <div class="flex flex-col flex-1 overflow-hidden">
                        <header class="flex items-center justify-between px-6 py-4 bg-white border-b-4">
                            <div class="flex items-center">
                                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </button>
                            </div>
                
                            <div class="flex items-center">
                                <div x-data="{ dropdownOpen: false }" class="relative">
                                    <button @click="dropdownOpen = ! dropdownOpen"
                                        class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                                        <img class="object-cover w-full h-full"
                                            src="https://placehold.co/100x100/000000/CCC/png"
                                            alt="Your avatar">
                                    </button>
                
                                    <div x-show="dropdownOpen" @click="dropdownOpen = false" class="fixed inset-0 z-10 w-full h-full"
                                        style="display: none;"></div>
                
                                    <div x-show="dropdownOpen"
                                        class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl"
                                        style="display: none;">
                                        {$this->renderMenu()}
                                    </div>
                                </div>
                            </div>
                        </header>
                        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                            <div class="container px-6 py-8 mx-auto">
                                {$content}  
                            </div>
                        </main>
                    </div>
                </div>
            </div>
            </body>
            </html>
        HTML;
    }



    public static function render(string $content): string
    {
        return (new static())->theme($content);
    }

    public function renderMenu()
    {
        $menu = '';
        if(self::$menu){
            $fieldsHtml = implode('', array_map(fn($field) => $field->render(), self::$menu));
            $menu = $fieldsHtml;
        }
        return $menu;
    }

    protected function renderLinks(): string
    {
        $links = '';
        foreach (self::$pages as $page) {
            $links .= <<<HTML
                <a class="flex items-center px-6 py-3 mt-1 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                   href="{$page->getUrl()}">
                    <i class="{$page->getIcon()}"></i>
                    <span class="mx-3">{$page->getTitle()}</span>
                </a>
            HTML;
        }
        return $links;
    }
}
