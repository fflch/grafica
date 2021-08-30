## Conceito
[<img src="/public/images/logo-fflch.png" width="80"/>](/public/images/logo-fflch.png)

Sistema Gráfica da FFLCH/USP

## Funcionalidades

- Realizar pedidos referentes aos setores de Editora e Gráfica.

## Procedimentos de deploy
 
- Adicionar a biblioteca PHP referente ao sgbd da base replicada

```bash
composer install
cp .env.example .env
```
- Editar o arquivo .env
    - Dados da conexão na base do sistema
    - Dados da conexão na base replicada
    - Nº USP dos funcionários do grupo autorizador
    - Nº USP dos funcionários do grupo editora
    - Nº USP dos funcionários do grupo gráfica
    - Identificar o nome do setor utilizado nos PDFs

- Configurações finais do framework e do sistema:

```bash
php artisan key:generate
php artisan migrate
php artisan vendor:publish --provider="Uspdev\UspTheme\ServiceProvider" --tag=assets --force
```
No ambiente de desenvolvimento, pode-se usar dados fakers:

```bash
php artisan migrate:fresh --seed
```

Caso falte alguma dependência, siga as instruções do `composer`.

## [<img src="public/images/youtube.png" width="40" height="30"/>](public/images/youtube.png) Tutoriais 

- [Visão do Usuário](https://www.youtube.com/watch?v=kkPFmTwta1s)
- [Visão do Grupo Autorizador](https://www.youtube.com/watch?v=oAwgLOt8hXA)
- [Visão do Grupo Editora](https://www.youtube.com/watch?v=6KVa6yfqL9U)
- [Visão do Grupo Gráfica](https://www.youtube.com/watch?v=ZLqxfQDShio)
- [Visão do Responsável pelo Centro de Despesa](https://www.youtube.com/watch?v=8eRNtIc0wg8)

## Projetos utilizados

- [uspdev/laravel-usp-theme](https://github.com/uspdev/laravel-usp-theme)
- [uspdev/replicado](https://github.com/uspdev/replicado)
- [uspdev/senhaunica-socialite](https://github.com/uspdev/senhaunica-socialite)
- [uspdev/laravel-usp-faker](https://github.com/uspdev/laravel-usp-faker)
- [uspdev/laravel-usp-validators](https://github.com/uspdev/laravel-usp-validators)
- [fflch/laravel-fflch-pdf](https://github.com/fflch/laravel-fflch-pdf)

## Contribuição

1. Faça o _fork_ do projeto (<https://github.com/yourname/yourproject/fork>)
2. Crie uma _branch_ para sua modificação (`git checkout -b feature/fooBar`)
3. Faça o _commit_ (`git commit -am 'Add some fooBar'`)
4. _Push_ (`git push origin feature/fooBar`)
5. Crie um novo _Pull Request_

## Padrões de Projeto

Utilizamos a [PSR-2](https://www.php-fig.org/psr/psr-2/) para padrões de projeto. Ajuste seu editor favorito para a especificação.

