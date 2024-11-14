<?php

namespace Source;
use Source\Components\Card\Card;
use Source\Components\Menu\Item;
use Source\Components\Menu\Menu;
use Source\Components\Styles\Collum;
use Source\Components\Styles\Grid;
use Source\Components\Styles\Grids;
use Source\Components\Styles\Section;
use Source\Components\Table\ActionButton;
use Source\Components\Table\CollumText;
use Source\Components\Table\Table;
use Source\Dash\Page;

class PageHome extends Page
{
    protected string $title = 'Home';
    protected string $url = 'index.php?page=home';
    protected string $icon = 'fa-solid fa-house';

    public $table;

    public static function home(): string
    {
        $data = [
            [
                'first_name' => 'Brendo',
                'email' => 'brendo.dev@outlook.com'
            ],
            [
                'first_name' => 'Brendo',
                'email' => 'vandre.queiroz@live.com'
            ]
        ];

        return self::render([
            Grids::schema([
                Grid::schema([
                    Menu::schema([
                        Item::make('Cadastrar')
                            ->url('/cadastrar'),
                        Item::make('Visualizar')
                            ->url('/view')
                            ->icon('fa-solid fa-eye'),
                        Item::make('Visualizar')
                            ->url('/view')
                            ->icon('fa-solid fa-eye'),
                        Item::make('Visualizar')
                            ->url('/view')
                            ->icon('fa-solid fa-eye'),
                        Item::make('Visualizar')
                            ->url('/view')
                            ->icon('fa-solid fa-eye')
                    ]),
                ])->collum(2)->render(),
                Grid::schema([
                    Table::make()
                        ->data($data)
                        ->font('Rubik')
                        ->rowClass(fn($record):string => $record->email == 'vandre.queiroz@live.com' ? 'border-l-4 !border-l-purple-700 bg-purple-100 dark:bg-gray-800' : '')
                        ->columns([
                            CollumText::make('first_name')
                                ->label('Nome')
                                ->badge('success')
                                ->record(fn($record) => $record->first_name)
                                ->class('text-gray-700'), 
                            CollumText::make('email')
                                //->badge(fn($record):string => $record->email == 'vandre.queiroz@live.com' ? 'primary' : '')
                                ->label('Email')
                        ])
                        ->actions([
                            ActionButton::make()
                                ->label('Detalhes')
                                ->icon('fas fa-info'), // Usando o ícone do Font Awesome
                            ActionButton::make()
                                ->label('Editar')
                                ->icon('fas fa-edit') // Usando o ícone do Font Awesome
                                ->url(fn($record):string => "/teste/{$record->email}")
                        ])
                ])->collum(10)->render()
            ])->render()
            ,
            // Collum::schema([
            //     Card::make()
            //         ->icon('fa-solid fa-user')
            //         ->value('10')
            //         ->description('User'),
            //     Card::make()
            //         ->icon('fa-solid fa-images')
            //         ->value('120')
            //         ->description('Imagens')
            // ])
            // ->collum(2)
            // ->render(),
        ], 
            'DashBoard'
        );
    }
    
}

