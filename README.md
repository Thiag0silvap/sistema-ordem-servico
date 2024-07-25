# Sistema de Ordem de Serviço

Este é um sistema de gerenciamento de ordens de serviço desenvolvido para facilitar a administração de clientes, técnicos e ordens de serviço. O sistema permite cadastrar e listar clientes e técnicos, além de gerenciar ordens de serviço com status, descrições e atribuições a técnicos.

## Funcionalidades

- **Cadastro de Clientes**: Adicione novos clientes com informações como nome, endereço e o telefone.
- **Cadastro de Técnicos**: Registre técnicos com nome, especialidade e telefone.
- **Cadastro de Ordem de Serviço**: Crie novas ordens de serviço, associando clientes e técnicos, com informações sobre data, descrição e status.
- **Listagem de Clientes**: Visualize a lista de clientes cadastrados.
- **Listagem de Técnicos**: Veja todos os técnicos registrados no sistema.
- **Listagem de Ordens de Serviço**: Acesse a lista de ordens de serviço e suas informações.


## Tecnologias Utilizadas

- PHP
- MySQL
- HTML
- CSS

## Estrutura do Projeto


- **`index.php`**: Página inicial do sistema após o login.
- **`login.php`**: Página de login para autenticação de usuário.
- **`register.php`**: Página para registro de novos usuários.
- **`cadastro_cliente`**: Formulário para cadastro de novos clientes.
- **`cadastro_tecnico.php`**: Formulário para cadastro de novos técnicos.
- **`cadastro_os.php`**: Formulário para cadastro de novas ordens de serviço.
- **`listar_clientes.php`**: Página para listar todos os clientes cadastrados.
- **`listar_tecnicos.php`**: Página para listar todos os técnicos cadastrados.
- **`listar_os.php`**: Página para listar todas as ordens de serviço cadastradas.
- **`atualizar_cliente.php`**: Página para atualizar as informações de um cliente existente.
- **`atualizar_tecnico.php`**: Página para atualizar as informações de um técnico existente.
- **`atualizar_os.php`**: Página para atualizar os detalhes de uma ordem de serviço existente.
- **`excluir_cliente.php`**: Página para excluir um cliente do sistema.
- **`excluir_tecnico.php`**: Página para excluir um técnico do sistema.
- **`excluir_os.php`**: Página para excluir uma ordem de serviço do sistema.
- **`logout.php`**: Página para realizar o logout do sistema.


## Configuração

1. Clone o repositório:
	```bash
	git clone https://github.com/seu-usuario/nome-do-repositorio.git
	```

2. Navegue até o diretório do projeto:
	```bash
	cd nome-do-repositorio
	```

3. Configure o banco de dados:
	- Crie um banco de dados MySQL com o nome `sistema_os`.
	- Importe o esquema do banco de dados (se disponível).

4. Configure o arquivo de conexão com o banco de dados:
	- Edite o arquivo `db.php` para configurar as credenciais do seu banco de dados MySQL.

## Uso

1. Inicie um servidor PHP:
	```bash
	php -S localhost:8000
	```

2. Acesse o sistema no navegador através de `http://localhost:8000`.


## Contribuição

Contribuições são bem-vindas! Sinta se à vontade para abrir problemas (issues)	e pull request.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).

## Para mais informações, entre em contato com [thiagocot70@gmail.com](mailto:thiagocot70@gmail.com).