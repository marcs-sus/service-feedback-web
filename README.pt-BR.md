# Sistema de Feedback de Qualidade de Serviço

Uma plataforma web de avaliação de serviços anônima projetada para implantação em tablets em diferentes setores organizacionais. Coleta feedback em tempo real através de uma interface amigável enquanto fornece aos administradores capacidades abrangentes de análise e relatórios.

## Funcionalidades

- **Avaliações Anônimas**: Coleta feedback de serviços sem armazenar dados pessoais
- **Perguntas Dinâmicas**: Carrega perguntas por setor do banco de dados
- **Suporte Multi-idioma**: Suporte de localização integrado
- **Respostas em Escala**: Sistema de classificação de 0-10 com feedback visual
- **Comentários Opcionais**: Campo de feedback aberto para dados qualitativos
- **Painel Administrativo**: Painel de gerenciamento completo com análises e gráficos
- **Interfaces CRUD Completas**: Gerencie tabelas via páginas CRUD perfeitamente
- **Resumos de Avaliações**: Filtre e revise todos os envios e feedback
- **Design Responsivo**: Interface otimizada para celular adequada para uso em tablet
- **Segurança de Sessão**: Gerenciamento seguro de sessões com limite de vida útil

## Tecnologias

- **Backend**: PHP 8.0+
- **Banco de Dados**: PostgreSQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Gráficos**: Chart.js para visualização de dados

## Banco de Dados

O sistema utiliza PostgreSQL com 7 tabelas principais:

- `sectors` - Divisões organizacionais para categorizar perguntas
- `devices` - Registros de tablet/dispositivos para implantação de formulário
- `questions` - Perguntas de pesquisa vinculadas a setores
- `question_translations` - Traduções em vários idiomas para perguntas
- `evaluations` - Registros de respostas individuais (referência de perguntas + pontuações)
- `feedback` - Comentários de texto aberto de usuários
- `admin_users` - Credenciais de administrador para acesso ao painel

Consulte [`sql/database.sql`](sql/database.sql) para o esquema completo.

## Bibliotecas & Dependências

### PHP

- **vlucas/phpdotenv** ^5.6 - Gerenciamento de configuração de ambiente
  - Utilizado em [`config.php`](config.php) para carregar o arquivo [`.env`](.env.example)

### Frontend

- **Chart.js** ^4.5.1 - Visualização de dados interativa
  - Utilizado em [`public/js/charts.js`](public/js/charts.js) para exibir gráficos em [`public/admin/dashboard.php`](public/admin/dashboard.php)

## Instalação

### Pré-requisitos

- PHP 8.0 ou superior
- PostgreSQL 12 ou superior
- Composer (para gerenciamento de dependências PHP)
- Servidor web (Apache, Nginx, etc.)

### Etapas de Configuração

1. **Clonar o repositório**

   ```bash
   git clone https://github.com/marcs-sus/service-feedback-web.git
   cd service-feedback-web
   ```

2. **Instalar dependências PHP**

   ```bash
   composer install
   ```

3. **Instalar dependências frontend**

   ```bash
   npm install
   ```

4. **Configurar variáveis de ambiente**

   ```bash
   cp .env.example .env
   ```

   Edite `.env` com suas credenciais PostgreSQL e configurações de aplicação:

   ```
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=feedback_system
   DB_USER=postgres
   DB_PASSWORD=sua_senha
   DEFAULT_LOCALE=pt_BR
   ```

5. **Criar o banco de dados**

   ```sql
   CREATE DATABASE feedback_system;
   ```

6. **Carregar o esquema do banco de dados**

   ```bash
   psql -U postgres -d feedback_system -f sql/database.sql
   ```

7. **Configurar servidor web**

   - Aponte a raiz do documento para o diretório `public`
   - Exemplo para Apache: `DocumentRoot /caminho/para/service-feedback-web/public`

8. **Definir permissões apropriadas**

   ```bash
   chmod 755 public
   chmod 644 public -R
   ```

9. **Acessar a aplicação**
   - Formulário público: [`http://localhost/`](http://localhost/)
   - Painel administrativo: [`http://localhost/admin/login_page.php`](http://localhost/admin/login_page.php)

## Estrutura do Projeto

```
service-feedback-web/
├── public/                 # Arquivos acessíveis pela web
│   ├── admin/             # Páginas do painel administrativo
│   ├── css/               # Folhas de estilo
│   ├── js/                # JavaScript frontend
│   ├── assets/            # Ícones e imagens
│   ├── index.php          # Formulário de avaliação pública
│   └── thank.php          # Página de conclusão
├── src/                   # Código-fonte backend
│   ├── model/             # Modelos de dados (Device, Question, etc.)
│   ├── auth/              # Lógica de autenticação
│   ├── crud_actions/      # Operações Criar, Ler, Atualizar, Deletar
│   ├── locales/           # Arquivos de tradução (JSON)
│   ├── db_conn.php        # Conexão com banco de dados Singleton
│   ├── query.php          # Construtor de consultas
│   └── session.php        # Gerenciamento de sessão
├── sql/                   # Scripts de banco de dados
├── config.php             # Configuração de aplicação
└── .env.example          # Modelo de variáveis de ambiente
```

## Uso

### Formulário Público

1. Acesse o formulário na URL raiz
2. Selecione seu idioma (seletor no canto superior direito)
3. Classifique cada pergunta em uma escala de 0-10
4. Opcionalmente forneça feedback adicional
5. Envie a avaliação

### Painel Administrativo

1. Faça login em `/admin/login_page.php`
2. Credenciais padrão devem ser criadas no banco de dados inicialmente
3. Gerencie setores, dispositivos e perguntas
4. Visualize análises e resumos de avaliações

## Configuração

Edite `.env` para personalizar:

- Detalhes de conexão do banco de dados
- Idioma e timezone da aplicação
- Tempo limite de sessão
- IDs de dispositivo e setor padrão para roteamento de formulário

## Licença

Este projeto está sob a Licença MIT - Consulte o arquivo [LICENSE](LICENSE) para detalhes
