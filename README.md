# API Pública IPay

Este repositório contém o código-fonte da API do IPay (serviços de pagamento e transferências entre contas)


## Como rodar em desenvolvimento

- Instalar [Docker](https://docs.docker.com/engine/install) e [Docker Composer](https://docs.docker.com/compose/install/) na máquina 
- Levantar o ambiente 
```shell
$ docker-compose up -d
```
- Instalação das dependências
```shell
$ docker-compose exec app bash 
$ composer install
```

- Atualizar base de dados
```shell
$ docker-compose exec app bash 
$ bin/console doctrine:migrations:migrate
```

- Pronto! A API poderá ser acessada via protocolo http/https [127.0.0.1:8008](http:127.0.0.1:8008) para ambiente de desenvolvimento.

