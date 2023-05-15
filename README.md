# REQUERIMENTOS DE ACESSO AO RESTAURANTE - CAMPUS SOBRAL

O sistema de Requerimento de Acesso ao Restaurante Acadêmico - RAR, foi desenvolvido para gerenciar as solicitações dos(as) discentes do *campus* Sobral que pretendem fazer uso do Restaurante Acadêmico, sendo por renovação de acesso que deve ser pedido semestralmente, segunda via do cartão de acesso (perda, roubo, danificado etc.) ou primeira via para os novatos;

* O sistema capta os dados dos(as) discente diretamente do *active directory* - AD hospedado na reitoria do IFCE;
* Gera notificações por e-mail no ato do requerimento para o(a) discente e nos despachos dos requerimento feitos pela **Coordenadoria de Assistência Estudantil**;
* Na Dashboard exibe gráficos sobre os requerimentos: como tipo de requerimento, solicitações de primeira e segunda via do cartão de acesso, fila de impressão e relatórios de impressão.
* Possui um gerenciamento de acesso a página de administração, onde podemos definir e policiar o acesso a todas as páginas do modo privado do sistema.
  * Gerenciamento de usuários*;
  * Gerenciamento de perfis de usuário*;
  * Gerenciamento de regras de acesso*. Essa módulo deve ser de acesso apenas ao administrador do sistema, pois a modificação dos registro podem deixar o sistema inoperante;
  * Gerenciamento de páginas*. Esse módulo também deve ser de acesso exclusivo do administrador do sistema, pois assim como o módulo de regras podem deixar o sistema inoperante;
  * Gerenciamento de logs - Visualização detalhada e exclusão. Aqui os registro são feito de acordo com as ações de inserção, atualização e exclusão de registro em qualquer módulo;
* Possui um gerenciamento dos módulos de ensino, que da gerencia sobre os seguintes módulo:
  * Gerenciamento de discentes*;
    * Gerenciamento de matriculas*;
  * Gerenciamento de Cursos*;
  * Gerenciamento de Semestres*;
  * Gerenciamento de dias das semana*;
* Tem também a gerencia sobre os módulos de requerimentos, onde podemos acessar os seguintes módulos:
  * Gerenciamento de requerimentos*;
    * Gerenciamento de despachos.
  * Gerenciamento de tipos de requerimentos;
* E por último temos o gerenciamento de impressão para as solicitações de cartão de acesso:
  * Gerenciamento de fila de impressão;
  * Gerenciamento de relatórios de impressão;

\* <small style="font-size:8pt">Gerenciamento são as páginas de cadastro, visualização detalhada, atualização e exclusão de dados (CRUD).</small>

## FERRAMENTAS USADAS

* Laravel
* Inertia
* ReactJS
* MariaDB
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
    laravelsail/php82-composer:latest \
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
