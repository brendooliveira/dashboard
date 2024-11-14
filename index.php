<?php

use Source\Components\Menu\Item;
use Source\Components\Menu\Menu;
use Source\Dash\Dash;
use Source\PageHome;
use Source\PageUser;

require __DIR__.'/vendor/autoload.php';


// Configura as páginas no dashboard
Dash::init([
    PageHome::init(),
    PageUser::init()
])
->menuItems([
    Menu::schema([
        Item::make('Minha conta')
            ->url('/')
            ->icon('fa-solid fa-user'),
        Item::make('sair')
            ->url('/')
            ->icon('fa-solid fa-close'),
    ])
] )
->title("Criativo")
->favicon('https://criativodahora.com.br/storage/icon/apple-touch-icon.png');

if(!empty($_GET['page'])){
    if($_GET['page'] == 'home'){
        echo PageHome::home();
    }

    if($_GET['page'] == 'user'){
        echo PageUser::create();
    }

    if($_GET['page'] == 'viewuser'){
        echo PageUser::view();
    }
}


// Para renderizar uma página específica