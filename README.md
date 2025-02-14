🏥 Sistema de Controle de Estoque e Aplicações – Farmácia Ambulatorial

Este sistema foi desenvolvido para gerenciar o estoque de medicamentos em uma farmácia ambulatorial, controlando entradas, saídas e aplicações de medicamentos em pacientes, além de sugerir datas para próximas compras e aplicações.

🖥️ Funcionalidades Principais

Cadastro de medicamentos, pacientes e usuários.
Controle de entrada e saída de medicamentos.
Registro de aplicações de medicamentos em pacientes.
Relatório de próximas aplicações e sugestão de compra.
Controle de medicamentos especiais.
Gestão de usuários com permissões por grupo (admin, assistente, consulta).
Exportação de histórico em CSV e PDF.

🚀 Requisitos

PHP 8.x ou superior.
Servidor MySQL 8.x ou superior.
Servidor Web (Apache ou Servidor embutido do PHP).
Bootstrap 5.3 para estilização.

## 🗄️ Banco de Dados

### 📦 Criação do Banco e Usuário
Execute os seguintes comandos no MySQL:

```sql
CREATE DATABASE estoque_farmacia;

CREATE USER 'farmacia_user'@'localhost' IDENTIFIED BY 'senha_forte';
GRANT ALL PRIVILEGES ON estoque_farmacia.* TO 'farmacia_user'@'localhost';
FLUSH PRIVILEGES;
```
## 📋 Criação das Tabelas
### 🧑‍💼 Tabela de Usuários

#### Campos:

``` Tabela
id – INT, Chave primária, AUTO_INCREMENT.
nome – VARCHAR(100), Nome do usuário.
email – VARCHAR(100), Único, Email do usuário.
senha – VARCHAR(255), Senha criptografada.
grupo – ENUM('admin', 'assistente', 'consulta'), Grupo de permissão do usuário.
ativo – TINYINT(1), Define se o usuário está ativo (1) ou inativo (0).
```

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255),
    grupo ENUM('admin', 'assistente', 'consulta'),
    ativo TINYINT(1) DEFAULT 1
);
```

## 💊 Tabela de Medicamentos

### Campos:

```
id – INT, Chave primária, AUTO_INCREMENT.
nome – VARCHAR(100), Nome do medicamento.
lote – VARCHAR(50), Único, Lote do medicamento.
validade – DATE, Data de validade.
data_compra – DATE, Data da compra.
quantidade – INT, Quantidade comprada inicialmente.
estoque – INT, Controle do estoque atual.
especial – TINYINT(1), Indica se é um medicamento especial (1) ou comum (0).
ativo – TINYINT(1), Define se o medicamento está ativo (1) ou inativo (0).
```
```sql
CREATE TABLE medicamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    lote VARCHAR(50) UNIQUE,
    validade DATE,
    data_compra DATE,
    quantidade INT,
    estoque INT DEFAULT 0,
    especial TINYINT(1) DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1
);
```

## 🧑‍⚕️ Tabela de Pacientes

### Campos:

```text
id – INT, Chave primária, AUTO_INCREMENT.
nome – VARCHAR(100), Nome do paciente.
cpf – VARCHAR(14), Único, CPF do paciente.
telefone – VARCHAR(15), Telefone de contato.
ativo – TINYINT(1), Define se o paciente está ativo (1) ou inativo (0).
```
```sql
CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(14) UNIQUE,
    telefone VARCHAR(15),
    ativo TINYINT(1) DEFAULT 1
);
```

## 🔄 Tabela de Movimentações

### Campos:
```text
id – INT, Chave primária, AUTO_INCREMENT.
tipo – ENUM('entrada', 'saida'), Tipo de movimentação.
medicamento_id – INT, Chave estrangeira para medicamentos.
quantidade – INT, Quantidade movimentada.
lote – VARCHAR(50), Lote do medicamento movimentado.
paciente – VARCHAR(100), Nome do paciente vinculado à saída (opcional).
data_movimentacao – TIMESTAMP, Data e hora da movimentação.
usuario_id – INT, Chave estrangeira para usuários.
```
```sql
CREATE TABLE movimentacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('entrada', 'saida'),
    medicamento_id INT,
    quantidade INT,
    lote VARCHAR(50),
    paciente VARCHAR(100),
    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_id INT,
    FOREIGN KEY (medicamento_id) REFERENCES medicamentos(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

```

## 💉 Tabela de Aplicações

### Campos:

```markdown
id – INT, Chave primária, AUTO_INCREMENT.
paciente_id – INT, Chave estrangeira para pacientes.
medicamento_id – INT, Chave estrangeira para medicamentos.
quantidade – INT, Quantidade aplicada.
data_aplicacao – DATE, Data da aplicação.
periodicidade – INT, Intervalo em dias entre as aplicações.
data_proxima_aplicacao – DATE, Data sugerida da próxima aplicação.
data_sugerida_compra – DATE, Data sugerida para compra.
criado_em – TIMESTAMP, Data e hora do registro.
```
```mysql
CREATE TABLE aplicacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT,
    medicamento_id INT,
    quantidade INT,
    data_aplicacao DATE,
    periodicidade INT,
    data_proxima_aplicacao DATE,
    data_sugerida_compra DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (medicamento_id) REFERENCES medicamentos(id)
);

```

## 🧑‍💻 Usuário Administrador Padrão

#### Para criar um usuário administrador inicial, rode o PHP abaixo para criptografar a senha:

```phpregexp
<?php
echo password_hash('123456', PASSWORD_DEFAULT);
?>
```

#### Exemplo de inserção no MySQL:
```sql
INSERT INTO usuarios (nome, email, senha, grupo) 
VALUES ('Administrador', 'admin@farmacia.com', '$2y$10$ExemploHashGeradoAqui', 'admin');
```

```pgsql
Sistema_Farmacia/
│
├── index.php
├── cabecalho.php
├── cadastro_usuario.php
├── listar_usuarios.php
├── editar_usuario.php
│
├── cadastro_medicamento.php
├── consulta_estoque.php
├── entrada_medicamento.php
├── saida_medicamento.php
│
├── cadastro_paciente.php
├── listar_pacientes.php
├── editar_paciente.php
│
├── aplicacao_medicamento.php
├── relatorio_proximas_aplicacoes.php
│
├── historico_movimentacoes.php
├── exportar_historico_csv.php
├── exportar_historico_pdf.php
```

## 🔐 Grupos de Permissões

| Grupo      | Solução                                                                        |
|------------|--------------------------------------------------------------------------------|
| Admin      | Gerencia usuários, pacientes, medicamentos, aplicações e visualiza relatórios. |
| Assistente | Movimentações e aplicações de medicamentos, sem gerenciar usuários.            |
| Consulta   | Apenas visualização de relatórios e estoques.                                  |


## 🖼️ Funcionalidades por Tela

| Grupo                                                                                                       | Solução                                                                                   |
|-------------------------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------|
| Cadastro de Usuário                                                                                         | Adicionar novo usuário e vincular a um grupo.                                             |
| Cadastro de Medicamento                                                                                     | Inserir medicamentos, lote, validade, data da compra, quantidade e indicar se é especial. |
| Entrada de Medicamento                                                                                      | Registrar chegada de medicamento ao estoque.                                              |
| Saída de Medicamento	                                                                                       | Registrar saída de medicamento (sem vínculo com paciente).                                |
| Cadastro de Paciente	                                                                                       | Cadastrar pacientes (nome, CPF, telefone).                                                |
| Aplicação de Medicamento                                                                                    |	Registrar aplicação em paciente, com periodicidade e sugerir data da próxima compra.|
| Relatório Próximas Aplicações	| Listar próximas aplicações e compras, com filtros por paciente e medicamento. |
| Histórico de Movimentações |	Mostrar entradas, saídas e aplicações, com exportação CSV e PDF.                 |
| Consulta de Estoque |	Listar medicamentos com lote, validade, quantidade e alertas de baixo estoque.          |

## 🤝 Contribuição

#### Caso queira contribuir, sinta-se à vontade para:
 
#### 1. Fazer um fork do repositório.
#### 2. Criar uma branch (git checkout -b feature/nova-funcionalidade).
#### 3. Commitar as alterações (git commit -m 'Adiciona nova funcionalidade').
#### 4. Push para o branch (git push origin feature/nova-funcionalidade).
##### 5. Abrir um Pull Request.


## 📧 Contato

Desenvolvido por Ítalo Freitas
E-mail: [italofre@gmail.com]
LinkedIn: linkedin.com/in/italomfreitas