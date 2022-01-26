<?php

$rotas = [
    '/' => [
        'GET' => '\Controlador\RaizControlador#index',
    ],

    '/login' => [
        'GET' => '\Controlador\LoginControlador#criar',
        'POST' => '\Controlador\LoginControlador#armazenar',
        'DELETE' => '\Controlador\LoginControlador#destruir',
    ],

    '/usuarios/criar' => [
        'GET' => '\Controlador\UsuarioControlador#index'
    ],

    '/usuarios' =>  [
        'POST' => '\Controlador\UsuarioControlador#armazenar'
    ],

    '/arquivos' => [
        'GET' => '\Controlador\ArquivoControlador#index',
        'POST' => '\Controlador\ArquivoControlador#armazenar'
    ],

    '/comentarios' => [
        'POST' => '\Controlador\ComentarioControlador#armazenar',
    ],

    '/comentarios/?' => [
        'PATCH' => '\Controlador\ComentarioControlador#atualizar',
        'DELETE' => '\Controlador\ComentarioControlador#destruir'
    ],

    '/comentarios/?/criar' => [
        'GET' => '\Controlador\ComentarioControlador#criar'
    ],

    '/comentarios/?/editar/?' => [
        'GET' => '\Controlador\ComentarioControlador#editar'
    ],

    '/relatorios' => [
        'GET' => '\Controlador\RelatorioControlador#index'
    ]
];
