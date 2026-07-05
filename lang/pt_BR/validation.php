<?php

return [
    'accepted' => 'O campo :attribute deve ser aceito.',
    'array' => 'O campo :attribute deve ser uma lista.',
    'email' => 'O campo :attribute deve ser um e-mail válido.',
    'exists' => 'O valor selecionado para :attribute é inválido.',
    'in' => 'O valor selecionado para :attribute é inválido.',
    'max' => [
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
        'file' => 'O arquivo :attribute não pode ser maior que :max kilobytes.',
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
        'array' => 'O campo :attribute não pode ter mais que :max itens.',
    ],
    'min' => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
        'file' => 'O arquivo :attribute deve ter no mínimo :min kilobytes.',
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
        'array' => 'O campo :attribute deve ter no mínimo :min itens.',
    ],
    'nullable' => 'O campo :attribute pode ser nulo.',
    'regex' => 'O campo :attribute possui formato inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser um texto.',
    'unique' => 'O valor informado para :attribute já está em uso.',
    'alpha_dash' => 'O campo :attribute deve conter apenas letras, números, hifens e underscores.',

    'custom' => [
        'name' => [
            'regex' => 'O nome deve conter apenas letras e espacos.',
        ],
        'description' => [
            'max' => 'A descrição não pode ter mais que :max caracteres.',
        ],
        'password' => [
            'min' => 'A senha deve ter no mínimo :min caracteres.',
        ],
        'permissions.*' => [
            'exists' => 'Selecione apenas permissões válidas.',
        ],
        'slug' => [
            'alpha_dash' => 'O slug deve conter apenas letras, números, hifens e underscores.',
        ],
    ],

    'attributes' => [
        'name' => 'nome',
        'email' => 'e-mail',
        'password' => 'senha',
        'role' => 'perfil',
        'permissions' => 'permissões',
        'slug' => 'slug',
        'description' => 'descrição',
    ],
];
