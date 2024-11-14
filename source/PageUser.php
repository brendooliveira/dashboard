<?php

namespace Source;
use Source\Components\Card\Card;
use Source\Components\Form\ButtonAction;
use Source\Components\Html\TextTitle;
use Source\Components\Styles\Collum;
use Source\Components\Form\Form;
use Source\Components\Form\Input;
use Source\Components\Form\Select;
use Source\Components\Html\Html;
use Source\Components\Styles\Section;
use Source\Components\Tabs\Tab;
use Source\Components\Tabs\Tabs;
use Source\Dash\Page;

class PageUser extends Page
{
    protected string $title = 'User';
    protected string $url = 'index.php?page=user';
    protected string $icon = 'fa-solid fa-user';

    public static function create(): string
    {
        return self::render([
            Collum::schema([
                Card::make()
                    ->icon('fa-solid fa-users', 'green-400')
                    ->value(22)
                    ->description('Usuarios')
                    ->color('green-400'),
                Card::make()
                    ->icon('fa-solid fa-image', 'orange-400')
                    ->value(234)
                    ->color('green-400')
                    ->description('Imagens')
            ])->collum(2)
            ->render(),
            Section::schema([
                Tabs::schema([
                    Tab::make('User')
                        ->label('Perfil')
                        ->icon('fas fa-user')
                        ->schema([
                            Form::make('', 'GET')
                            ->add(
                            Collum::schema([
                                Input::make('name')
                                    ->label('Nome')
                                    ->value('John Doe')
                                    ->required(),
                                Input::make('email')->label('Seu email')->value('example@example.com')->required(),
                                Select::make('genre')
                                    ->label('Genero')
                                    ->options(['male' => 'Male', 'female' => 'Female'])
                                    ->select('female')
                            ])->collum(3))
                            ->add(Collum::schema([
                                Input::make('last_name')->label('Sobrenome')->value('John Doe')->required(),
                                Input::make('avatar')->label('Foto de perfil')->required(),
                            ])->collum(2))
                            ->setFormClasses('mt-5')
                        ]),
                    Tab::make('Account')
                        ->label('Minha conta')
                        ->icon('fas fa-cog')
                        ->schema([
                            Section::schema([
                                TextTitle::make('Minha')
                            ])
                        ]),
                    // Tab::make('Account2')
                    //     ->label('Minha conta2')
                    //     ->icon('fas fa-cog')
                    //     ->schema([

                    //     ])
                ]),
            ])->render(),
            
            Form::make('','GET')
                ->add(
                    Section::schema([
                        Collum::schema([
                            TextTitle::make('Dados pessoais')
                                ->subtitle('Informações'),
                            Collum::schema([
                                Input::make('name')
                                    ->icon('fa-solid fa-user')
                                    ->label('Seu nome'),
                                Input::make('tags')
                                    ->label('Tags')
                                    ->icon('fa-solid fa-tags')
                                    ->value('brendo, teste')
                                    ->tags(),
                                Select::make('category')
                                    ->label('Category')
                                    ->options(['tech' => 'Tech', 'health' => 'Health', 'education' => 'Education'])
                                    ->select('tech')
                                    ->icon('fa-solid fa-list')
                                    ->searchable()
                            ])->collum(1)
                        ])->collum(2)
                    ])
                )->add(
                    Section::schema([
                        Collum::schema([
                            TextTitle::make('Dados pessoais')
                                ->subtitle('Informações'),
                            Collum::schema([
                                Input::make('name')
                                    ->label('Seu nome'),
                                Input::make('last_name')
                                    ->label('Seu sobrenome'),
                            ])->collum(1)
                        ])->collum(2)
                    ])
                )->render()
        ], 
        'Criar Usuario'
        );
    }

    public static function view(): string
    {
        return self::render(
            Section::schema([
                TextTitle::make('Olá mundo')
                    ->subtitle('fechou na mata')
            ])->render()
            , 
            'Vizualizar Usuario'
        );
    }
}
