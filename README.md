# Arquitetura de Projetos IPPLS

Plataforma web robusta desenvolvida para padronizar e gerenciar a criação de projetos acadêmicos no Instituto Politécnico Privado Lucrêcio dos Santos (IPPLS). A plataforma implementa templates padronizados baseados na arquitetura MVC (Model-View-Controller), oferecendo três níveis de complexidade (Base, Padrão e Avançado) para diferentes necessidades pedagógicas.

## 📋 Sobre o Projeto

Este projeto foi desenvolvido para resolver problemas estruturais no desenvolvimento de projetos acadêmicos pelos estudantes do IPPLS, oferecendo:

- **Padronização:** Templates de projeto baseados em arquitetura MVC
- **Gestão:** Sistema de acompanhamento de progresso dos projetos
- **Usabilidade:** Interface intuitiva para estudantes e coordenadores
- **Automação:** Geração e distribuição automatizada de estruturas de projeto
- **Monitoramento:** Sistema de notificações para avaliadores

## 🚀 Tecnologias Utilizadas

- **[Laravel 12](https://laravel.com/docs/12.x)** (com Starter Kit Jetstream)
- **[Vue 3](https://vuejs.org/)** com TypeScript
- **[Inertia.js](https://inertiajs.com/)** para SPA sem API
- **[Vite](https://vitejs.dev/)** para build e desenvolvimento
- **[Tailwind CSS](https://tailwindcss.com/)** para estilização
- **[shadcn/ui](https://ui.shadcn.com/)** para componentes UI
- **[MySQL](https://www.mysql.com/)** (ou SQLite para desenvolvimento)

## 📦 Instalação

### Pré-requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- MySQL ou SQLite
- NPM ou Yarn

### Passos para Instalação

1. **Clone o repositório:**
```bash
git clone https://github.com/Ngola-develop/arquitetura-de-projetos-ippls.git
cd arquitetura-de-projetos-ippls
```

2. **Instale as dependências do PHP:**
```bash
composer install
```

3. **Instale as dependências do Node.js:**
```bash
npm install
```

4. **Configure o ambiente:**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure o banco de dados no arquivo `.env`:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

Ou para desenvolvimento rápido com SQLite:
```env
DB_CONNECTION=sqlite
```

6. **Execute as migrações:**
```bash
php artisan migrate
```

7. **Popule o banco de dados (opcional):**
```bash
php artisan db:seed
```

8. **Compile os assets:**
```bash
npm run build
```

Ou para desenvolvimento:
```bash
npm run dev
```

9. **Inicie o servidor:**
```bash
php artisan serve
```

Ou use o script de desenvolvimento completo:
```bash
composer run dev
```

## 🏗️ Estrutura do Projeto

```
arquitetura-de-projetos-ippls/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controladores da aplicação
│   │   ├── Middleware/       # Middlewares customizados
│   │   └── Requests/         # Form Requests
│   ├── Models/              # Modelos Eloquent
│   └── Services/            # Serviços de negócio
├── database/
│   ├── migrations/          # Migrações do banco de dados
│   └── seeders/            # Seeders para dados iniciais
├── resources/
│   ├── js/
│   │   ├── components/      # Componentes Vue
│   │   ├── layouts/         # Layouts da aplicação
│   │   └── pages/           # Páginas Inertia
│   └── css/                # Estilos CSS
├── routes/ø
│   ├── web.php             # Rotas web
│   ├── auth.php            # Rotas de autenticação
│   └── estudante.php       # Rotas específicas de estudantes
└── public/                 # Arquivos públicos
```

## 🧩 Componentes Compartilhados

- `resources/js/components/Navbar.vue` – navegação utilizada em todas as páginas públicas
- `resources/js/components/AppFooter.vue` – **novo footer reutilizável** com links institucionais, redes sociais e newsletter

## 🧭 Páginas Públicas

- `resources/js/pages/Welcome.vue` – landing page premium com hero animado, CTA e agora utilizando o `AppFooter`
- `resources/js/pages/Templates/Base/Index.vue` – apresenta o template Base MVC com guia detalhado, exemplos de código e CTA
- `resources/js/pages/Templates/Padrao/index.vue` – descreve o template Padrão com camadas de serviços, middlewares e documentação própria
- `resources/js/pages/Templates/Avancado/Index.vue` – destaca o template Avançado enterprise, modularização e pipelines CI/CD

## 🎯 Funcionalidades Principais

### Módulo de Gestão de Usuários
- Cadastro de estudantes com informações completas
- Gestão de avaliadores (professores)
- Painel administrativo para coordenadores

### Módulo de Projetos
- Criação e gestão de projetos template
- Três níveis de arquitetura:
  - **Base:** Estrutura MVC simples
  - **Padrão:** Estrutura MVC com helpers e configurações
  - **Avançado:** Estrutura completa com Core, Middleware e Services
- Download de templates estruturados

### Módulo de Acompanhamento
- Acompanhamento de progresso (10%, 25%, 50%, 75%, 100%)
- Sistema de notificações
- Status de projetos (iniciado, em desenvolvimento, concluído)

### Módulo de Avaliação
- Sistema de avaliação para professores
- Relatórios e estatísticas
- Exportação de dados (CSV, Excel)

## 👥 Tipos de Usuários

### Estudante
- Visualizar projetos disponíveis
- Criar instâncias de projeto
- Acompanhar progresso
- Fazer upload de anexos
- Download de templates

### Professor/Avaliador
- Visualizar projetos atribuídos
- Avaliar projetos
- Acompanhar progresso dos estudantes
- Receber notificações

### Coordenador
- Gerenciar projetos template
- Gerenciar usuários (estudantes e professores)
- Gerenciar turmas
- Visualizar relatórios e estatísticas
- Exportar dados

## 🔐 Autenticação

O sistema utiliza Laravel Jetstream com autenticação completa:
- Registro de usuários
- Login/Logout
- Recuperação de senha
- Verificação de email
- Gerenciamento de perfil

## 📊 Banco de Dados

O sistema utiliza as seguintes tabelas principais:
- `users` - Usuários do sistema
- `cursos` - Cursos disponíveis
- `turmas` - Turmas dos estudantes
- `projetos` - Templates de projetos
- `instancias_projeto` - Instâncias de projetos dos estudantes
- `avaliacoes` - Avaliações dos projetos
- `notificacoes` - Notificações do sistema
- `templates_arquitetura` - Templates de arquitetura disponíveis

## 🧪 Testes

Execute os testes com:
```bash
php artisan test
```

Ou:
```bash
composer test
```

## 📝 Scripts Disponíveis

### Composer
- `composer dev` - Inicia servidor, queue e Vite em desenvolvimento
- `composer dev:ssr` - Inicia com SSR habilitado
- `composer test` - Executa os testes

### NPM
- `npm run dev` - Inicia Vite em modo desenvolvimento
- `npm run build` - Compila assets para produção
- `npm run build:ssr` - Compila com SSR
- `npm run lint` - Executa o linter

## 🤝 Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 👨‍💻 Autor

**Ngola-develop**
- GitHub: [@Ngola-develop](https://github.com/Ngola-develop)

## 🏫 Instituição

**Instituto Politécnico Privado Lucrêcio dos Santos (IPPLS)**

## 📚 Documentação Adicional

Para mais detalhes sobre o projeto, consulte o arquivo:
- `project-description/project-description-new-version.txt`

## 🐛 Problemas Conhecidos

Se encontrar algum problema, por favor abra uma [issue](https://github.com/Ngola-develop/arquitetura-de-projetos-ippls/issues).

## 🔄 Changelog

### Versão 1.0
- Implementação inicial da plataforma
- Sistema de autenticação completo
- Módulos de gestão de projetos, usuários e avaliações
- Templates de arquitetura MVC em três níveis
- Sistema de notificações
- Painel de supervisão para coordenadores

---

**Desenvolvido com ❤️ para o IPPLS**

