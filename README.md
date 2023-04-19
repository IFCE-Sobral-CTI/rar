# REQUERIMENTOS DE ACESSO AO RESTAURANTE - CAMPUS SOBRAL

## FERRAMENTAS USADAS

* Laravel
* Inertia
* ReactJS
* Postgres
* Redis

## INSTALAÇÃO

Para instalar faça um clone do projeto:

```sh
git clone https://github.com/CTI-Sobral-IFCE/rar.git
```

Acesse o diretório do projeto:

```sh
cd rar
```


Faça uma cópia do arquivo `.env`:

```sh
cp .env.example .env
```

Abra o arquivo `.env` e preencha com as configurações(Nome, url, banco de dados) do seu projeto.

Instale os pacotes do PHP/Laravel:

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Inicialize os containers que executam as instancias das ferramentas usadas pelas tecnologias usados no projeto.

```sh
./vendor/bin/sail up
```

Instale os pacotes Javascript/Inertia/Javascript:

```sh
sail npm install
```

Gere a chave de segurança da sua aplicação Laravel:

```sh
sail php artisan key:generate
```

Povoe o banco de dados:

```sh
sail php artisan migrate:fresh --seed
```

Para executar o projeto depois das configurações:

```sh
sail npm run dev
```

O sistema está distribuído em duas partes do front-end.

* Página de acesso público
  * <http://localhost>
* Dashboard
  * <http://localhost/admin>

Para acessar a dashboard use as seguintes credenciais

* Usuário:
  * ti.sobral@ifce.edu.br
* Senha:
  * qwe123

### CRÉDITOS

Projeto desenvolvido pela Coordenadoria de Tecnologia da Informação do IFCE - *Campus* Sobral.

### CONTATO

<ti.sobral@ifce.edu.br>

### LICENÇA

Este é um software de código aberto licenciado sob a licença do [MIT](https://opensource.org/licenses/MIT).
