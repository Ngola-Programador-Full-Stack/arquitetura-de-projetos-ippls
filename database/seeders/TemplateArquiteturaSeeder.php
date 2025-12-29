<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateArquitetura;
use Illuminate\Support\Facades\DB;

class TemplateArquiteturaSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Verificando e atualizando templates...');
        $this->command->line('');

        // =====================================================
        // 1. TEMPLATE BASE - MVC SIMPLIFICADO (MANTIDO)
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            ['nivel' => 'base'],
            [
                'nome' => 'Template Base',
                'subtitulo' => 'MVC Simplificado',
                'nivel' => 'base',
                'descricao' => 'Estrutura MVC fundamental e direta para iniciantes. Aprenda os conceitos básicos de arquitetura de software com uma estrutura simples e bem organizada.',
                'descricao_completa' => 'O Template Base oferece uma introdução prática ao padrão MVC (Model-View-Controller), ideal para estudantes que estão começando no desenvolvimento web. Com uma estrutura enxuta e direta, permite foco no aprendizado dos conceitos fundamentais sem complexidade desnecessária.',

                'estrutura_diretorios' => [
                    'projeto_base/' => [
                        'index.php',
                        'config/' => ['database.php'],
                        'models/' => ['User.php'],
                        'views/' => [
                            'pages/' => ['home.php']
                        ],
                        'controllers/' => ['HomeController.php'],
                        'assets/' => [
                            'css/' => ['style.css'],
                            'js/' => ['main.js'],
                            'images/' => [
                                'logo/' => ['ippls-logo-removebg-preview.png']
                            ]
                        ],
                        'favicon.ico',
                        'README.md'
                    ]
                ],

                'arquivos_base' => [
                    ['caminho' => 'projeto_base/index.php', 'template' => $this->getIndexBase()],
                    ['caminho' => 'projeto_base/config/database.php', 'template' => $this->getDatabaseConfig()],
                    ['caminho' => 'projeto_base/models/User.php', 'template' => $this->getUserModel()],
                    ['caminho' => 'projeto_base/controllers/HomeController.php', 'template' => $this->getHomeController()],
                    ['caminho' => 'projeto_base/views/pages/home.php', 'template' => $this->getHomeView()],
                    ['caminho' => 'projeto_base/assets/images/logo/ippls-logo-removebg-preview.png', 'template' => $this->getLogoPlaceholder()],
                    ['caminho' => 'projeto_base/favicon.ico', 'template' => $this->getFaviconPlaceholder()],
                    ['caminho' => 'projeto_base/assets/css/style.css', 'template' => $this->getStyleCss()],
                    ['caminho' => 'projeto_base/assets/js/main.js', 'template' => $this->getMainJs()],
                    ['caminho' => 'projeto_base/README.md', 'template' => $this->getReadmeBase()]
                ],

                'requisitos' => [
                    'PHP' => '>= 7.4',
                    'MySQL' => '>= 5.7',
                    'Apache/Nginx' => 'Qualquer',
                    'Conhecimento' => 'Básico de PHP'
                ],

                'beneficios' => [
                    'Estrutura simples e intuitiva para estudantes',
                    'Separação clara de responsabilidades (MVC)',
                    'Fácil manutenção e expansão do código',
                    'Ideal para projetos acadêmicos pequenos',
                    'Documentação completa incluída',
                    'Exemplos práticos de uso'
                ],

                'casos_uso' => [
                    ['nome' => 'Sistema de Cadastro', 'descricao' => 'CRUD básico para gerenciar usuários, produtos ou qualquer entidade.', 'icone' => 'database'],
                    ['nome' => 'Páginas Dinâmicas', 'descricao' => 'Sites com conteúdo dinâmico proveniente da base de dados.', 'icone' => 'file-text'],
                    ['nome' => 'Blogs Simples', 'descricao' => 'Sistema de publicação de artigos com categorias.', 'icone' => 'book'],
                    ['nome' => 'Portfólios', 'descricao' => 'Páginas pessoais com projetos e informações.', 'icone' => 'briefcase']
                ],

                'caracteristicas' => ['Estrutura MVC Básica', 'Setup Rápido', 'Fácil de Aprender', 'Segurança Básica'],
                'instrucoes_uso' => $this->getInstrucoesBase(),
                'tempo_setup' => 5,
                'para_iniciantes' => true,
                'gratuito' => true,
                'documentado' => true,
                'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Base verificado/atualizado');

        // =====================================================
        // 2. TEMPLATE PADRÃO - MVC COM COMPOSER E ROTAS
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            ['nivel' => 'padrao'],
            [
                'nome' => 'Template Padrão',
                'subtitulo' => 'MVC com Composer e Autoloading',
                'nivel' => 'padrao',
                'descricao' => 'Estrutura profissional com Composer, autoloading PSR-4, sistema de rotas e convenção app/Http/. Evolução natural do template Base com práticas modernas de desenvolvimento.',
                'descricao_completa' => 'O Template Padrão introduz conceitos profissionais mantendo a simplicidade do Base. Adiciona Composer para gerenciamento de dependências, autoloading PSR-4 para carregamento automático de classes, sistema de rotas centralizado e organização em app/Http/ seguindo convenções do mercado.',

                'estrutura_diretorios' => [
                    'projeto_padrao/' => [
                        'index.php',
                        'app/' => [
                            'config/' => ['database.php', 'app.php', 'constants.php' ,'helpers.php'],
                            'Http/' => [
                                'Controllers/' => ['HomeController.php', 'UserController.php']
                            ],
                            'Models/' => ['User.php']
                        ],
                        'routes/' => ['web.php'],
                        'views/' => [
                            'components/' => ['footer.php', 'navbar.php'],
                            'errors/' => ['404.php', '500.php'],
                            'layouts/' => ['main.php'],
                            'pages/' => ['home.php', 'users.php', 'docs.php']
                        ],
                        'assets/' => [
                            'css/' => ['style.css', 'base.css',
                            'sections/' => ['footer.css', 'hero.css', 'skills.css'],
                            'components/' => ['alerts.css', 'buttons.css', 'cards.css', 'docs.css', 'errors.css', 'forms.css', 'tables.css', 'navbar.css']
                        ],
                            'js/' => ['main.js',
                            'components' => ['navbar.js', 'backToTop.js', 'docs.js'],
                        ],
                            'images/' => [
                                'logo/' => ['ippls-logo-removebg-preview.png', 'composer.svg', 'php.svg', 'mysql.svg', 'license.svg'],
                                'skills/' => ['apache.svg', 'composer.svg', 'css3.svg', 'git.svg', 'html5.svg', 'javascript.svg', 'mysql.svg', 'php.svg', 'xampp.svg']
                            ]
                        ],
                        // ✅ ADICIONAR FONT AWESOME
                        'vendor/' => [
                            'fontawesome/' => [
                                'css/' => ['all.min.css'],
                                'webfonts/' => [
                                    'fa-solid-900.woff2',
                                    'fa-regular-400.woff2',
                                    'fa-brands-400.woff2'
                                ]
                            ]
                        ],
                        'vendor/',
                        'composer.json',
                        'favicon.ico',
                        '.htaccess',
                        'README.md'
                    ]
                ],

                'arquivos_base' => [
                    ['caminho' => 'projeto_padrao/index.php', 'template' => $this->getIndexPadrao()],
                    ['caminho' => 'projeto_padrao/composer.json', 'template' => $this->getComposerJsonPadrao()],
                    ['caminho' => 'projeto_padrao/.htaccess', 'template' => $this->getHtaccessPadrao()],
                    ['caminho' => 'projeto_padrao/routes/web.php', 'template' => $this->getWebRoutesPadrao()],
                    ['caminho' => 'projeto_padrao/vendor/fontawesome/css/all.min.css', 'template' => $this->getAllMinCssFA()],
                    ['caminho' => 'projeto_padrao/vendor/fontawesome/webfonts/fa-brands-400.woff2', 'template' => $this->getFaBrands400Woff2()],
                    ['caminho' => 'projeto_padrao/vendor/fontawesome/webfonts/fa-regular-400.woff2', 'template' => $this->getFaRegular400Woff2()],
                    ['caminho' => 'projeto_padrao/vendor/fontawesome/webfonts/fa-solid-900.woff2', 'template' => $this->getFaSolid400Woff2()],
                    ['caminho' => 'projeto_padrao/app/config/database.php', 'template' => $this->getDatabaseConfigPadrao()],
                    ['caminho' => 'projeto_padrao/app/config/constants.php', 'template' => $this->getConstantsConfig()],
                    ['caminho' => 'projeto_padrao/app/config/app.php', 'template' => $this->getAppConfig()],
                    ['caminho' => 'projeto_padrao/app/config/helpers.php', 'template' => $this->getHelpersConfig()],
                    ['caminho' => 'projeto_padrao/app/Models/User.php', 'template' => $this->getUserModelPadrao()],
                    ['caminho' => 'projeto_padrao/app/Http/Controllers/HomeController.php', 'template' => $this->getHomeControllerPadrao()],
                    ['caminho' => 'projeto_padrao/app/Http/Controllers/UserController.php', 'template' => $this->getUserControllerPadrao()],
                    ['caminho' => 'projeto_padrao/views/components/footer.php', 'template' => $this->getFooterPadrao()],
                    ['caminho' => 'projeto_padrao/views/components/navbar.php', 'template' => $this->getNavbarPadrao()],
                    ['caminho' => 'projeto_padrao/views/errors/404.php', 'template' => $this->get404Padrao()],
                    ['caminho' => 'projeto_padrao/views/errors/500.php', 'template' => $this->get500Padrao()],
                    ['caminho' => 'projeto_padrao/views/layouts/main.php', 'template' => $this->getMainLayout()],
                    ['caminho' => 'projeto_padrao/views/pages/home.php', 'template' => $this->getHomeViewPadrao()],
                    ['caminho' => 'projeto_padrao/views/pages/users.php', 'template' => $this->getUsersViewPadrao()],
                    ['caminho' => 'projeto_padrao/views/pages/docs.php', 'template' => $this->getDocsViewsPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/style.css', 'template' => $this->getStyleCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/base.css', 'template' => $this->getBaseCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/sections/footer.css', 'template' => $this->getFooterCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/sections/hero.css', 'template' => $this->getHeroCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/sections/skills.css', 'template' => $this->getSkillsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/alerts.css', 'template' => $this->getAlertsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/buttons.css', 'template' => $this->getButtonsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/cards.css', 'template' => $this->getCardsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/errors.css', 'template' => $this->getErrorsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/forms.css', 'template' => $this->getFormsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/navbar.css', 'template' => $this->getNavbarCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/tables.css', 'template' => $this->getTablesCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/css/components/docs.css', 'template' => $this->getDocsCssPadrao()],
                    ['caminho' => 'projeto_padrao/assets/js/main.js', 'template' => $this->getMainJs()],
                    ['caminho' => 'projeto_padrao/assets/js/components/navbar.js', 'template' => $this->getNavbarJs()],
                    ['caminho' => 'projeto_padrao/assets/js/components/backToTop.js', 'template' => $this->getBackToTopJs()],
                    ['caminho' => 'projeto_padrao/assets/js/components/docs.js', 'template' => $this->getDocsJs()],
                    ['caminho' => 'projeto_padrao/assets/images/logo/ippls-logo-removebg-preview.png', 'template' => $this->getLogoPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/logo/composer.svg', 'template' => $this->getComposerPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/logo/php.svg', 'template' => $this->getPhpPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/logo/mysql.svg', 'template' => $this->getMySqlPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/logo/license.svg', 'template' => $this->getLicensePlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/apache.svg', 'template' => $this->getApachePlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/composer.svg', 'template' => $this->getComposerPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/css3.svg', 'template' => $this->getCss3Placeholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/git.svg', 'template' => $this->getGitPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/html5.svg', 'template' => $this->getHtml5Placeholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/javascript.svg', 'template' => $this->getJavascriptPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/mysql.svg', 'template' => $this->getMySqlPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/php.svg', 'template' => $this->getPhpPlaceholder()],
                    ['caminho' => 'projeto_padrao/assets/images/skills/xampp.svg', 'template' => $this->getXamppPlaceholder()],
                    ['caminho' => 'projeto_padrao/favicon.ico', 'template' => $this->getFaviconPlaceholder()],
                    ['caminho' => 'projeto_padrao/README.md', 'template' => $this->getReadmePadrao()]
                ],

                'requisitos' => [
                    'PHP' => '>= 8.0',
                    'Composer' => '>= 2.0',
                    'MySQL' => '>= 5.7',
                    'Apache/Nginx' => 'Com mod_rewrite'
                ],

                'beneficios' => [
                    'Autoloading PSR-4 com Composer',
                    'Sistema de rotas centralizado e organizado',
                    'Convenção app/Http/ profissional',
                    'Namespace para evitar conflitos',
                    'Separação clara entre rotas e controllers',
                    'Fácil expansão e manutenção'
                ],

                'casos_uso' => [
                    ['nome' => 'Sistemas Web Completos', 'descricao' => 'Aplicações web com múltiplas páginas e funcionalidades.', 'icone' => 'globe'],
                    ['nome' => 'APIs REST Simples', 'descricao' => 'Endpoints REST para integração com front-end.', 'icone' => 'code'],
                    ['nome' => 'Dashboards', 'descricao' => 'Painéis administrativos com dados dinâmicos.', 'icone' => 'bar-chart'],
                    ['nome' => 'Sistemas Acadêmicos', 'descricao' => 'Gestão de alunos, notas e frequência.', 'icone' => 'book-open']
                ],

                'caracteristicas' => ['Composer PSR-4', 'Sistema de Rotas', 'Namespaces', 'Convenção app/Http/'],
                'instrucoes_uso' => $this->getInstrucoesPadrao(),
                'tempo_setup' => 10,
                'para_iniciantes' => false,
                'gratuito' => true,
                'documentado' => true,
                'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Padrão verificado/atualizado');

        // =====================================================
        // 3. TEMPLATE AVANÇADO - EVOLUÇÃO DO PADRÃO
        // =====================================================
        TemplateArquitetura::updateOrCreate(
            ['nivel' => 'avancado'],
            [
                'nome' => 'Template Avançado',
                'subtitulo' => 'URLs Amigáveis, Middleware e Recursos Expandidos',
                'nivel' => 'avancado',
                'descricao' => 'Evolução do Template Padrão com URLs profissionais, middleware, upload de arquivos, paginação e API REST básica. Ideal para projetos que precisam de funcionalidades avançadas sem complexidade enterprise.',
                'descricao_completa' => 'O Template Avançado estende o Padrão com URLs amigáveis (sem ?page=), sistema de middleware para autenticação e CSRF, upload de arquivos, paginação de dados, API REST básica e múltiplos CRUDs. Mantém a simplicidade do MVC com recursos profissionais.',

                'estrutura_diretorios' => [
                    'projeto_avancado/' => [
                        'index.php',
                        'app/' => [
                            'config/' => ['app.php', 'database.php', 'constants.php', 'helpers.php'],
                            'Http/' => [
                                'Controllers/' => [
                                    'HomeController.php',
                                    'UserController.php',
                                    'AuthController.php',
                                    'ProductController.php',
                                    'ApiController.php'
                                ],
                                'Middleware/' => [
                                    'AuthMiddleware.php',
                                    'CsrfMiddleware.php'
                                ]
                            ],
                            'Models/' => ['User.php', 'Product.php']
                        ],
                        'routes/' => ['web.php', 'api.php'],
                        'views/' => [
                            'layouts/' => ['main.php', 'dashboard.php'],
                            'pages/' => [
                                'home.php',
                                'users.php',
                                'products.php',
                                'docs.php',
                                'dashboard.php',
                                'auth/' => ['login.php', 'register.php']
                            ],
                            'components/' => [
                                'navbar.php',
                                'footer.php',
                                'breadcrumbs.php',
                                'pagination.php'
                            ],
                            'errors/' => ['404.php', '500.php']
                        ],
                        'public/' => [
                            'uploads/' => ['users/', 'products/'],
                            'assets/' => [
                                'css/' => [
                                    'style.css',
                                    'base.css',
                                    'components/' => [
                                        'navbar.css',
                                        'buttons.css',
                                        'forms.css',
                                        'cards.css',
                                        'tables.css',
                                        'alerts.css',
                                        'pagination.css',
                                        'breadcrumbs.css'
                                    ],
                                    'sections/' => [
                                        'hero.css',
                                        'footer.css',
                                        'dashboard.css'
                                    ]
                                ],
                                'js/' => [
                                    'main.js',
                                    'components/' => [
                                        'navbar.js',
                                        'upload.js',
                                        'pagination.js',
                                        'api.js'
                                    ]
                                ],
                                'images/' => [
                                    'logo/' => ['ippls-logo-removebg-preview.png'],
                                    'placeholders/' => ['user-placeholder.png', 'product-placeholder.png']
                                ]
                            ]
                        ],
                        'storage/' => [
                            'logs/' => ['app.log'],
                            'cache/' => [],
                            'sessions/' => []
                        ],
                        'vendor/' => [
                            'fontawesome/' => [
                                'css/' => ['all.min.css'],
                                'webfonts/' => [
                                    'fa-solid-900.woff2',
                                    'fa-regular-400.woff2',
                                    'fa-brands-400.woff2'
                                ]
                            ]
                        ],
                        '.htaccess',
                        'composer.json',
                        'favicon.ico',
                        'README.md'
                    ]
                ],

                'arquivos_base' => [
                    // ========================================
                    // INDEX.PHP - ROTEAMENTO MELHORADO
                    // ========================================
                    ['caminho' => 'projeto_avancado/index.php', 'template' => $this->getIndexAvancado()],
                    ['caminho' => 'projeto_avancado/.htaccess', 'template' => $this->getHtaccessAvancado()],
                    ['caminho' => 'projeto_avancado/composer.json', 'template' => $this->getComposerJsonAvancado()],

                    // ========================================
                    // CONFIGURAÇÕES
                    // ========================================
                    ['caminho' => 'projeto_avancado/app/config/app.php', 'template' => $this->getAppConfigAvancado()],
                    ['caminho' => 'projeto_avancado/app/config/database.php', 'template' => $this->getDatabaseConfigAvancado()],
                    ['caminho' => 'projeto_avancado/app/config/constants.php', 'template' => $this->getConstantsConfigAvancado()],
                    ['caminho' => 'projeto_avancado/app/config/helpers.php', 'template' => $this->getHelpersConfigAvancado()],

                    // ========================================
                    // ROTAS
                    // ========================================
                    ['caminho' => 'projeto_avancado/routes/web.php', 'template' => $this->getWebRoutesAvancado()],
                    ['caminho' => 'projeto_avancado/routes/api.php', 'template' => $this->getApiRoutesAvancado()],

                    // ========================================
                    // MIDDLEWARE
                    // ========================================
                    ['caminho' => 'projeto_avancado/app/Http/Middleware/AuthMiddleware.php', 'template' => $this->getAuthMiddleware()],
                    ['caminho' => 'projeto_avancado/app/Http/Middleware/CsrfMiddleware.php', 'template' => $this->getCsrfMiddleware()],

                    // ========================================
                    // MODELS
                    // ========================================
                    ['caminho' => 'projeto_avancado/app/Models/User.php', 'template' => $this->getUserModelAvancado()],
                    ['caminho' => 'projeto_avancado/app/Models/Product.php', 'template' => $this->getProductModel()],

                    // ========================================
                    // CONTROLLERS
                    // ========================================
                    ['caminho' => 'projeto_avancado/app/Http/Controllers/HomeController.php', 'template' => $this->getHomeControllerAvancado()],
                    ['caminho' => 'projeto_avancado/app/Http/Controllers/UserController.php', 'template' => $this->getUserControllerAvancado()],
                    ['caminho' => 'projeto_avancado/app/Http/Controllers/AuthController.php', 'template' => $this->getAuthController()],
                    ['caminho' => 'projeto_avancado/app/Http/Controllers/ProductController.php', 'template' => $this->getProductController()],
                    ['caminho' => 'projeto_avancado/app/Http/Controllers/ApiController.php', 'template' => $this->getApiController()],

                    // ========================================
                    // VIEWS - LAYOUTS
                    // ========================================
                    ['caminho' => 'projeto_avancado/views/layouts/main.php', 'template' => $this->getMainLayoutAvancado()],
                    ['caminho' => 'projeto_avancado/views/layouts/dashboard.php', 'template' => $this->getDashboardLayout()],

                    // ========================================
                    // VIEWS - PAGES
                    // ========================================
                    ['caminho' => 'projeto_avancado/views/pages/home.php', 'template' => $this->getHomeViewAvancado()],
                    ['caminho' => 'projeto_avancado/views/pages/users.php', 'template' => $this->getUsersViewAvancado()],
                    ['caminho' => 'projeto_avancado/views/pages/products.php', 'template' => $this->getProductsView()],
                    ['caminho' => 'projeto_avancado/views/pages/docs.php', 'template' => $this->getDocsViewAvancado()],
                    ['caminho' => 'projeto_avancado/views/pages/dashboard.php', 'template' => $this->getDashboardView()],
                    ['caminho' => 'projeto_avancado/views/pages/auth/login.php', 'template' => $this->getLoginView()],
                    ['caminho' => 'projeto_avancado/views/pages/auth/register.php', 'template' => $this->getRegisterView()],

                    // ========================================
                    // VIEWS - COMPONENTS
                    // ========================================
                    ['caminho' => 'projeto_avancado/views/components/navbar.php', 'template' => $this->getNavbarAvancado()],
                    ['caminho' => 'projeto_avancado/views/components/footer.php', 'template' => $this->getFooterAvancado()],
                    ['caminho' => 'projeto_avancado/views/components/breadcrumbs.php', 'template' => $this->getBreadcrumbs()],
                    ['caminho' => 'projeto_avancado/views/components/pagination.php', 'template' => $this->getPaginationComponent()],

                    // ========================================
                    // VIEWS - ERRORS
                    // ========================================
                    ['caminho' => 'projeto_avancado/views/errors/404.php', 'template' => $this->get404Avancado()],
                    ['caminho' => 'projeto_avancado/views/errors/500.php', 'template' => $this->get500Avancado()],

                    // ========================================
                    // ASSETS - CSS
                    // ========================================
                    ['caminho' => 'projeto_avancado/public/assets/css/style.css', 'template' => $this->getStyleCssAvancado()],
                    ['caminho' => 'projeto_avancado/public/assets/css/base.css', 'template' => $this->getBaseCssAvancado()],
                    ['caminho' => 'projeto_avancado/public/assets/css/components/pagination.css', 'template' => $this->getPaginationCss()],
                    ['caminho' => 'projeto_avancado/public/assets/css/components/breadcrumbs.css', 'template' => $this->getBreadcrumbsCss()],
                    ['caminho' => 'projeto_avancado/public/assets/css/sections/dashboard.css', 'template' => $this->getDashboardCss()],

                    // ========================================
                    // ASSETS - JS
                    // ========================================
                    ['caminho' => 'projeto_avancado/public/assets/js/main.js', 'template' => $this->getMainJsAvancado()],
                    ['caminho' => 'projeto_avancado/public/assets/js/components/upload.js', 'template' => $this->getUploadJs()],
                    ['caminho' => 'projeto_avancado/public/assets/js/components/api.js', 'template' => $this->getApiJs()],

                    // ========================================
                    // STORAGE
                    // ========================================
                    ['caminho' => 'projeto_avancado/storage/logs/app.log', 'template' => ''],

                    // ========================================
                    // ASSETS BINÁRIOS
                    // ========================================
                    ['caminho' => 'projeto_avancado/public/assets/images/logo/ippls-logo-removebg-preview.png', 'template' => $this->getLogoPlaceholder()],
                    ['caminho' => 'projeto_avancado/favicon.ico', 'template' => $this->getFaviconPlaceholder()],

                    // FontAwesome
                    ['caminho' => 'projeto_avancado/vendor/fontawesome/css/all.min.css', 'template' => $this->getAllMinCssFA()],
                    ['caminho' => 'projeto_avancado/vendor/fontawesome/webfonts/fa-brands-400.woff2', 'template' => $this->getFaBrands400Woff2()],
                    ['caminho' => 'projeto_avancado/vendor/fontawesome/webfonts/fa-regular-400.woff2', 'template' => $this->getFaRegular400Woff2()],
                    ['caminho' => 'projeto_avancado/vendor/fontawesome/webfonts/fa-solid-900.woff2', 'template' => $this->getFaSolid400Woff2()],

                    // ========================================
                    // README
                    // ========================================
                    ['caminho' => 'projeto_avancado/README.md', 'template' => $this->getReadmeAvancado()]
                ],

                'requisitos' => [
                    'PHP' => '>= 8.0',
                    'Composer' => '>= 2.0',
                    'MySQL' => '>= 5.7',
                    'Apache' => 'Com mod_rewrite',
                    'Extensões PHP' => 'PDO, fileinfo, GD/Imagick'
                ],

                'beneficios' => [
                    'URLs amigáveis e profissionais',
                    'Sistema de middleware para segurança',
                    'Upload de arquivos com validação',
                    'Paginação automática de dados',
                    'API REST para integrações',
                    'Múltiplos CRUDs prontos (Users, Products)',
                    'Sistema de autenticação básico',
                    'Breadcrumbs e navegação avançada'
                ],

                'casos_uso' => [
                    ['nome' => 'E-commerce Básico', 'descricao' => 'Sistema de vendas com produtos, categorias e pedidos.', 'icone' => 'shopping-cart'],
                    ['nome' => 'Portal de Conteúdo', 'descricao' => 'Blog ou portal com múltiplos autores e categorias.', 'icone' => 'newspaper'],
                    ['nome' => 'Sistema de Gestão', 'descricao' => 'ERP/CRM básico com múltiplos módulos.', 'icone' => 'briefcase'],
                    ['nome' => 'API + Frontend', 'descricao' => 'Backend com API REST para consumo por SPA.', 'icone' => 'code']
                ],

                'caracteristicas' => [
                    'URLs Amigáveis',
                    'Middleware (Auth, CSRF)',
                    'Upload de Arquivos',
                    'Paginação',
                    'API REST',
                    'Múltiplos CRUDs'
                ],

                'instrucoes_uso' => $this->getInstrucoesAvancado(),
                'tempo_setup' => 15,
                'para_iniciantes' => false,
                'gratuito' => true,
                'documentado' => true,
                'ativo' => true
            ]
        );

        $this->command->info('  ✓ Template Avançado verificado/atualizado');

        $this->command->newLine();
        $this->command->info('✅ Templates de arquitetura verificados/atualizados com sucesso!');
        $this->command->line('');
        $this->command->line('📦 <fg=cyan>Templates Disponíveis:</>');
        $this->command->line('   • Template Base - MVC Simplificado (Iniciantes)');
        $this->command->line('   • Template Padrão - MVC com Composer e Autoloading (Intermediário)');
        $this->command->line('   • Template Avançado - Service Layer e DI (Avançado)');
        $this->command->line('');
    }

    // ==========================================
    // TEMPLATE BASE - MÉTODOS ORIGINAIS MANTIDOS
    // ==========================================


private function getIndexBase(): string
{
    return <<<'PHP'
<?php
// index.php - Ponto de entrada e roteamento global

require_once 'config/database.php';

// Captura a ação da URL
$action = $_GET['action'] ?? 'index';

// Carregar controller
require_once 'controllers/HomeController.php';
$controller = new HomeController();

// Roteamento centralizado
switch ($action) {
    case 'create':
        $controller->create();
        break;

    case 'update':
        $controller->update();
        break;

    case 'delete':
        $controller->delete();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
PHP;
}


    private function getDatabaseConfig(): string
    {
        return <<<'PHP'
<?php
// config/database.php - Configuração do banco de dados

define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');

// Função para conectar ao banco
function getConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}
PHP;
    }

    private function getUserModel(): string
    {
        return <<<'PHP'
<?php
// models/User.php - Model de usuário com CRUD completo

class User {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // ✅ CREATE - Criar novo usuário
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
        );
        return $stmt->execute([
            htmlspecialchars($data['name'] ?? ''),
            htmlspecialchars($data['email'] ?? '')
        ]);
    }

    // ✅ READ - Buscar todos os usuários
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ READ - Buscar usuário por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ UPDATE - Atualizar usuário
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );
        return $stmt->execute([
            htmlspecialchars($data['name'] ?? ''),
            htmlspecialchars($data['email'] ?? ''),
            $id
        ]);
    }

    // ✅ DELETE - Deletar usuário
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ✅ Validação de email único
    public function emailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
PHP;
    }

private function getHomeController(): string
{
    return <<<'PHP'
<?php
// controllers/HomeController.php - Controller principal com CRUD completo

require_once 'models/User.php';

class HomeController {
    private $userModel;
    private $message = '';
    private $messageType = '';

    public function __construct() {
        // Iniciar sessão se não estiver iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // ✅ Método principal - Lista todos os usuários
    public function index() {
        $users = $this->userModel->getAll();
        $controller = $this;
        require __DIR__ . '/../views/pages/home.php';
    }

    // ✅ CREATE - Criar novo usuário
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validação
            if (empty($name) || empty($email)) {
                $this->setMessage('Por favor, preencha todos os campos.', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setMessage('Email inválido.', 'error');
            } elseif ($this->userModel->emailExists($email)) {
                $this->setMessage('Este email já está cadastrado.', 'error');
            } else {
                if ($this->userModel->create(['name' => $name, 'email' => $email])) {
                    $this->setMessage('Usuário criado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao criar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ UPDATE - Atualizar usuário
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Validação
            if (empty($name) || empty($email)) {
                $this->setMessage('Por favor, preencha todos os campos.', 'error');
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->setMessage('Email inválido.', 'error');
            } elseif ($this->userModel->emailExists($email, $id)) {
                $this->setMessage('Este email já está cadastrado.', 'error');
            } else {
                if ($this->userModel->update($id, ['name' => $name, 'email' => $email])) {
                    $this->setMessage('Usuário atualizado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao atualizar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ DELETE - Deletar usuário
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);

            if ($id > 0) {
                if ($this->userModel->delete($id)) {
                    $this->setMessage('Usuário deletado com sucesso!', 'success');
                    header('Location: ?');
                    exit;
                } else {
                    $this->setMessage('Erro ao deletar usuário.', 'error');
                }
            }
        }
        $this->index();
    }

    // ✅ Armazena mensagem na SESSION
    private function setMessage($message, $type) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    // ✅ Verifica se existe mensagem (NÃO limpa ainda)
    public function hasMessage() {
        return isset($_SESSION['flash_message']);
    }

    // ✅ Recupera mensagem SEM limpar
    public function getMessage() {
        return $_SESSION['flash_message'] ?? '';
    }

    // ✅ Recupera tipo SEM limpar
    public function getMessageType() {
        return $_SESSION['flash_type'] ?? '';
    }

    // ✅ NOVO - Limpa as mensagens após exibição
    public function clearMessage() {
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }

    public function getUserById($id) {
        return $this->userModel->getById($id);
    }
}
PHP;
}


    private function getHomeView(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Base MVC - IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Hero Section - Brutal Design with IPPLS Logo -->
    <div class="hero-section">
        <div class="hero-container">
            <div class="hero-grid">
                <!-- Left Section: Text Content -->
                <div class="hero-content">
                    <!-- Welcome IPPLS -->
                    <div class="welcome-container">
                        <span class="welcome-icon">👋</span>
                        <span class="welcome-text">Bem-vindo ao futuro do desenvolvimento no ITLS</span>
                    </div>
                    <h1 class="hero-title">
                        Template <span class="hero-title-highlight">MVC BASE</span>
                    </h1>
                    <p class="hero-subtitle">
                        Arquitetura base para desenvolvimento rápido. Construa projetos sem concessões.
                    </p>
                    <div class="hero-buttons">
                        <a href="#home" class="btn-hero btn-hero-primary">Começar Agora</a>
                        <a href="README.md" class="btn-hero btn-hero-secondary">Documentação</a>
                    </div>
                </div>
                <!-- Right Section: Visual Block -->
                <div class="hero-visual">
                    <div class="decoration-block-top">
                        <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                    </div>
                    <div class="feature-card">
                        <h2 class="feature-card-title">Ousado. Forte. Real.</h2>
                        <p class="feature-card-subtitle">IPPLS - Instituto Politécnico</p>
                    </div>
                    <div class="decoration-block-bottom">
                        <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Alert Messages -->
        <?php if (isset($controller) && $controller->hasMessage()): ?>
            <div class="alert alert-<?= $controller->getMessageType() ?>">
                <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
                <span><?= htmlspecialchars($controller->getMessage()) ?></span>
            </div>
            <?php $controller->clearMessage(); // Limpa APÓS exibir ?>
        <?php endif; ?>

        <h1 class="hero-title">
            CRUD - <span class="hero-title-highlight">CREATE</span> READ <span class="hero-title-highlight">UPDATE</span> DELETE
        </h1><br>

        <!-- Create/Edit User Card -->
        <div class="card" id="form">
            <div class="card-header">
                <h2><?= isset($_GET['edit']) ? '✏️ Editar Usuário' : '➕ Criar Usuário' ?></h2>
            </div>
            <div class="card-body">
                <?php
                $editUser = null;
                if (isset($_GET['edit']) && isset($controller)) {
                    $editUser = $controller->getUserById(intval($_GET['edit']));
                }
                ?>
                <form method="POST" action="?action=<?= $editUser ? 'update' : 'create' ?>">
                    <?php if ($editUser): ?>
                        <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Nome Completo *</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-input"
                                value="<?= htmlspecialchars($editUser['name'] ?? '') ?>"
                                placeholder="Digite o nome"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email *</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="<?= htmlspecialchars($editUser['email'] ?? '') ?>"
                                placeholder="exemplo@ippls.edu.ao"
                                required
                            >
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <?= $editUser ? 'ATUALIZAR' : 'CRIAR' ?>
                        </button>
                        <?php if ($editUser): ?>
                            <a href="?" class="btn btn-secondary">CANCELAR</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Users List Card -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Usuários Cadastrados (<?= count($users ?? []) ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($users)): ?>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><strong>#<?= $user['id'] ?></strong></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?edit=<?= $user['id'] ?>" class="btn btn-sm btn-edit">
                                                    EDITAR
                                                </a>
                                                <form method="POST" action="?action=delete" class="inline-form"
                                                      onsubmit="return confirm('Confirma a exclusão?');">
                                                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-delete">
                                                        DELETAR
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>Nenhum Usuário</h3>
                        <p>Crie o primeiro usuário usando o formulário acima.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="skills-section">
        <h2 class="skills-title">Requisitos Técnicos</h2>
        <div class="skills-grid">
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" alt="HTML" class="skill-icon">
                <span class="skill-name">HTML5</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" alt="CSS" class="skill-icon">
                <span class="skill-name">CSS3</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript" class="skill-icon">
                <span class="skill-name">JavaScript</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg" alt="PHP" class="skill-icon">
                <span class="skill-name">PHP</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL" class="skill-icon">
                <span class="skill-name">MySQL</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apache/apache-original.svg" alt="Apache" class="skill-icon">
                <span class="skill-name">Apache</span>
            </div>
            <div class="skill-card">
                <img src="https://www.apachefriends.org/images/xampp-logo-ac950edf.svg" alt="XAMPP" class="skill-icon">
                <span class="skill-name">XAMPP</span>
            </div>
            <div class="skill-card">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" alt="Git" class="skill-icon">
                <span class="skill-name">Git</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="footer-logo">
                <p class="footer-desc">Arquitetura base para desenvolver seus projetos.</p>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#home">Começar</a></li>
                    <li><a href="README.md">Documentação</a></li>
                    <li><a href="?">Usuários</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Tecnologias</h3>
                <ul class="footer-links">
                    <li>PHP • MySQL</li>
                    <li>HTML5 • CSS3</li>
                    <li>JavaScript • Git</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Desenvolvido com ❤️ para o <strong>IPPLS</strong></p>
            <p class="footer-version">Template Base MVC • v1.0.0 • 2025</p>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
HTML;
    }

    private function getStyleCss(): string
    {
        return <<<'CSS'
/* ============================================
    Template Para Projeto MVC - IPPLS BRUTAL DESIGN
    Estrutura Organizada e Modular
    ============================================ */

/* ============================================
   1. RESET & BASE
   ============================================ */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    /* Cores IPPLS */
    --ippls-blue-dark: #07183b;
    --ippls-blue-medium: #4A8FC4;
    --ippls-red: #C1272D;
    --ippls-gold: #F4B41A;
    --ippls-gold-dark: #D69E0E;

    /* Escala de Cinzas */
    --gray-900: #0c2248;
    --gray-800: #1a2f52;
    --gray-700: #2d4464;
    --gray-400: #a0a0a0;
    --gray-50: #f9f9f9;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #e8eef5 0%, #d4dce8 100%);
    min-height: 100vh;
    padding: 0;
    color: #07183b;
    line-height: 1.6;
}


/* ============================================
   2. SEÇÃO HERO
   ============================================ */

/* Container Principal */
.hero-section {
    padding: 1.5rem 1rem;
    margin: 0;
    border-radius: 0;
    background: var(--gray-900);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    position: relative;
}

@media (min-width: 768px) {
    .hero-section {
        padding: 2.5rem 1.25rem;
        margin: 0;
    }
}

.hero-container {
    width: 100%;
    max-width: 1400px;
    padding: 0 1rem;
}

/* Layout em Grade */
.hero-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: center;
}

@media (min-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
}

/* Conteúdo Hero (Esquerda) */
.hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    z-index: 10;
}

@media (min-width: 768px) {
    .hero-content {
        text-align: left;
    }
}

/* Títulos */
.hero-title {
    font-size: 2rem;
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 480px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (min-width: 640px) {
    .hero-title {
        font-size: 3rem;
    }
}

@media (min-width: 768px) {
    .hero-title {
        font-size: 3.5rem;
    }
}

@media (min-width: 1024px) {
    .hero-title {
        font-size: 4.5rem;
    }
}

.hero-title-highlight {
    color: var(--ippls-gold);
}

.hero-subtitle {
    margin-top: 1rem;
    font-size: 1rem;
    font-weight: 500;
    color: var(--gray-400);
    text-wrap: balance;
}

@media (min-width: 640px) {
    .hero-subtitle {
        font-size: 1.125rem;
    }
}

@media (min-width: 768px) {
    .hero-subtitle {
        font-size: 1.25rem;
    }
}

/* Badge de Boas-Vindas */
.welcome-container {
    margin-bottom: 1rem;
    display: inline-block;
}

@media (min-width: 640px) {
    .welcome-container {
        margin-bottom: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .welcome-container {
        margin-bottom: 2rem;
    }
}

.welcome-icon {
    font-size: 1.5rem;
    animation: wave 2s ease-in-out infinite;
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
}

.welcome-text {
    font-size: 0.875rem;
    color: var(--ippls-gold);
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 640px) {
    .welcome-text {
        font-size: 0.95rem;
    }
}

/* Botões da Seção Hero */
.hero-buttons {
    margin-top: 2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.btn-hero {
    border-radius: 0.25rem;
    padding: 0.875rem 2rem;
    flex-grow: 1;
    text-align: center;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.1em;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-hero-primary {
    background: var(--ippls-gold);
    color: #07183b;
}

.btn-hero-primary:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(244, 180, 26, 0.3);
}

.btn-hero-secondary {
    border: 2px solid var(--ippls-gold);
    color: var(--ippls-gold);
    background: transparent;
}

.btn-hero-secondary:hover {
    background: var(--ippls-gold);
    color: #07183b;
}

/* Visual Hero (Direita) */
.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    min-height: 200px;
}

@media (min-width: 640px) {
    .hero-visual {
        padding: 2rem;
        min-height: 250px;
    }
}

@media (min-width: 768px) {
    .hero-visual {
        padding: 2.5rem;
        min-height: 300px;
    }
}

/* Blocos Decorativos */
.decoration-block-top {
    position: absolute;
    top: -1rem;
    left: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(12deg);
    border-radius: 0.5rem;
    border-bottom: 3px solid var(--ippls-gold-dark);
    border-right: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-top {
        top: -1.5rem;
        left: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-top {
        top: -2.5rem;
        left: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-bottom: 4px solid var(--ippls-gold-dark);
        border-right: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-top {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-top {
        top: -5rem;
        width: 16rem;
        height: 16rem;
    }
}

.decoration-block-bottom {
    position: absolute;
    bottom: -1rem;
    right: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(-12deg);
    border-radius: 0.5rem;
    border-right: 3px solid var(--ippls-gold-dark);
    border-bottom: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-bottom {
        bottom: -1.5rem;
        right: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-bottom {
        bottom: -2.5rem;
        right: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-right: 4px solid var(--ippls-gold-dark);
        border-bottom: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-bottom {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-bottom {
        bottom: -5rem;
        right: -4rem;
        width: 16rem;
        height: 16rem;
    }
}

/* Logos */
.logo {
    height: 50px;
    width: auto;
    display: block;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.4))
            drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3))
            drop-shadow(0 2px 4px rgba(255, 255, 255, 0.2));
}

@media (min-width: 480px) {
    .logo {
        height: 60px;
        filter: drop-shadow(0 12px 24px rgba(255, 255, 255, 0.45))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.35))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.25));
    }
}

@media (min-width: 640px) {
    .logo {
        height: 70px;
        filter: drop-shadow(0 15px 30px rgba(255, 255, 255, 0.5))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.4))
                drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 768px) {
    .logo {
        height: 80px;
        filter: drop-shadow(0 18px 36px rgba(255, 255, 255, 0.55))
                drop-shadow(0 10px 20px rgba(255, 255, 255, 0.45))
                drop-shadow(0 5px 10px rgba(255, 255, 255, 0.35));
    }
}

@media (min-width: 1024px) {
    .logo {
        height: 100px;
        filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.6))
                drop-shadow(0 12px 24px rgba(255, 255, 255, 0.5))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.4))
                drop-shadow(0 2px 4px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 1280px) {
    .logo {
        height: 120px;
        filter: drop-shadow(0 25px 50px rgba(255, 255, 255, 0.65))
                drop-shadow(0 15px 30px rgba(255, 255, 255, 0.55))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.45))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.35));
    }
}

.logo:hover {
    transform: scale(1.08) translateY(-4px);
    filter: drop-shadow(0 30px 60px rgba(255, 255, 255, 0.8))
            drop-shadow(0 20px 40px rgba(255, 255, 255, 0.7))
            drop-shadow(0 10px 20px rgba(244, 180, 26, 0.6))
            drop-shadow(0 5px 10px rgba(244, 180, 26, 0.8));
}

/* Card de Destaque */
.feature-card {
    position: relative;
    z-index: 10;
    background: var(--gray-800);
    padding: 1rem;
    width: 100%;
    max-width: 100%;
    text-align: center;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    transform: rotate(-2deg);
    border-radius: 0.75rem;
    border-bottom: 3px solid #050f1f;
    border-right: 5px solid #050f1f;
}

@media (min-width: 640px) {
    .feature-card {
        padding: 1.5rem;
        border-bottom: 4px solid #050f1f;
        border-right: 8px solid #050f1f;
    }
}

.feature-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--gray-50);
    word-wrap: break-word;
    hyphens: auto;
}

@media (min-width: 480px) {
    .feature-card-title {
        font-size: 1.5rem;
    }
}

@media (min-width: 640px) {
    .feature-card-title {
        font-size: 1.875rem;
    }
}

.feature-card-subtitle {
    margin-top: 0.25rem;
    font-size: 0.75rem;
    font-weight: 300;
    color: var(--gray-400);
}

@media (min-width: 640px) {
    .feature-card-subtitle {
        font-size: 0.875rem;
    }
}

@media (min-width: 768px) {
    .feature-card-subtitle {
        font-size: 1rem;
    }
}


/* ============================================
   3. CONTAINER PRINCIPAL
   ============================================ */
.main-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.25rem;
}


/* ============================================
   4. ALERTAS E MENSAGENS FLASH
   ============================================ */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 600;
    animation: slideDown 0.3s ease;
    border-left: 4px solid;
    position: relative;
    z-index: 1000;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-color: #dc3545;
}


/* ============================================
   5. CARDS
   ============================================ */
.card {
    background: var(--gray-900);
    color: white;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    margin-bottom: 2rem;
    border-bottom: 4px solid #050f1f;
    border-right: 6px solid #050f1f;
}

.card-header {
    background: var(--gray-800);
    padding: 1.5rem 2rem;
    border-bottom: 3px solid var(--ippls-gold);
}

.card-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-body {
    padding: 2rem;
    background: var(--gray-900);
}


/* ============================================
   6. FORMULÁRIOS
   ============================================ */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
    }
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 700;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-400);
}

.form-input {
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-700);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: var(--gray-800);
    color: white;
}

.form-input:focus {
    outline: none;
    border-color: var(--ippls-gold);
    background: var(--gray-700);
}

.form-input::placeholder {
    color: var(--gray-400);
}


/* ============================================
   7. BOTÕES
   ============================================ */
.button-group {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    flex-wrap: wrap;
}

.btn {
    padding: 0.875rem 2rem;
    border: none;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--ippls-gold);
    color: #07183b;
    border-bottom: 3px solid var(--ippls-gold-dark);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(244, 180, 26, 0.4);
}

.btn-secondary {
    background: transparent;
    color: var(--gray-400);
    border: 2px solid var(--gray-700);
}

.btn-secondary:hover {
    background: var(--gray-800);
    border-color: var(--gray-400);
    color: white;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.btn-edit {
    background: var(--ippls-gold);
    color: #07183b;
    border: none;
}

.btn-edit:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-1px);
}

.btn-delete {
    background: var(--ippls-red);
    color: white;
    border: none;
}

.btn-delete:hover {
    background: #9d1f23;
    transform: translateY(-1px);
}


/* ============================================
   8. TABELAS
   ============================================ */
.table-wrapper {
    overflow-x: auto;
    border-radius: 0.5rem;
    border: 2px solid var(--gray-800);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-800);
}

.data-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    color: var(--ippls-gold);
}

.data-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-800);
}

.data-table tbody tr {
    transition: background-color 0.2s ease;
}

.data-table tbody tr:hover {
    background: var(--gray-800);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}


/* ============================================
   9. ESTADO VAZIO
   ============================================ */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--gray-400);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: white;
    text-transform: uppercase;
    font-weight: 700;
}


/* ============================================
   10. SEÇÃO DE HABILIDADES
   ============================================ */
.skills-section {
    width: 100%;
    max-width: 1200px;
    margin: 3rem auto;
    text-align: center;
    padding: 2rem 1.5rem;
}

.skills-title {
    font-size: 2rem;
    font-weight: 700;
    color: #0c2248;
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    line-height: 1.1;
}

@media (min-width: 768px) {
    .skills-title {
        font-size: 2.5rem;
    }
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (min-width: 640px) {
    .skills-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 768px) {
    .skills-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
}

.skill-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1rem;
    background: #0c2248;
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.skill-card:hover {
    transform: scale(1.05) translateY(-5px);
    background: #1a3a5f;
    border-color: var(--ippls-gold);
    box-shadow: 0 15px 35px rgba(244, 180, 26, 0.3);
}

.skill-icon {
    width: 3rem;
    height: 3rem;
    margin-bottom: 0.75rem;
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .skill-icon {
        width: 3.5rem;
        height: 3.5rem;
    }
}

.skill-card:hover .skill-icon {
    transform: rotateY(360deg);
}

.skill-name {
    color: #d1d5db;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .skill-name {
        font-size: 0.95rem;
    }
}

.skill-card:hover .skill-name {
    color: var(--ippls-gold);
}


/* ============================================
   11. RODAPÉ
   ============================================ */
.footer {
    background: var(--gray-900);
    color: white;
    margin-top: 3rem;
    padding: 2.5rem 2rem;
    border-top: 3px solid var(--ippls-gold);
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .footer-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
    }
}

.footer-section {
    flex: 1;
    min-width: 200px;
}

.footer-logo {
    height: 60px;
    margin-bottom: 1rem;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}

.footer-desc {
    color: var(--gray-400);
    font-size: 0.9rem;
    line-height: 1.6;
}

.footer-heading {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--ippls-gold);
    margin-bottom: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-400);
}

.footer-links a {
    color: var(--gray-400);
    text-decoration: none;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: var(--ippls-gold);
}

.footer-bottom {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-700);
    text-align: center;
}

.footer-bottom p {
    margin: 0.5rem 0;
    font-size: 0.95rem;
    color: var(--gray-400);
}

.footer-bottom strong {
    color: var(--ippls-gold);
    font-weight: 600;
}

.footer-version {
    font-size: 0.75rem;
    color: var(--gray-400);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.footer-heart {
    color: var(--ippls-red);
    animation: heartbeat 1.5s ease-in-out infinite;
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}


/* ============================================
   12. CLASSES UTILITÁRIAS
   ============================================ */
.inline-form {
    display: inline;
}


/* ============================================
   13. RESPONSIVIDADE
   ============================================ */
@media (max-width: 768px) {
    .button-group {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-sm {
        width: 100%;
    }

    .card-body {
        padding: 1.5rem;
    }
}
CSS;
    }




    private function getStyleCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
TEMPLATE PADRÃO MVC - IPPLS
Sistema de CSS Componentizado
============================================ */

/* Base & Reset */
@import 'base.css';

/* Componentes */
@import 'components/navbar.css';
@import 'components/buttons.css';
@import 'components/forms.css';
@import 'components/cards.css';
@import 'components/tables.css';
@import 'components/alerts.css';
@import 'components/docs.css';
@import 'components/errors.css';

/* Seções */
@import 'sections/hero.css';
@import 'sections/skills.css';
@import 'sections/footer.css';
CSS;
    }

    private function getBaseCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   BASE - RESET & VARIÁVEIS CSS
   Template Padrão IPPLS
   ============================================ */

/* Reset Global */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Variáveis CSS */
:root {
    /* Cores IPPLS */
    --ippls-blue-dark: #07183b;
    --ippls-blue-medium: #4A8FC4;
    --ippls-red: #C1272D;
    --ippls-gold: #F4B41A;
    --ippls-gold-dark: #D69E0E;

    /* Escala de Cinzas */
    --gray-900: #0c2248;
    --gray-800: #1a2f52;
    --gray-700: #2d4464;
    --gray-400: #a0a0a0;
    --gray-50: #f9f9f9;

    /* Sombras */
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px rgba(0, 0, 0, 0.15);
    --shadow-2xl: 0 25px 50px rgba(0, 0, 0, 0.25);

    /* Transições */
    --transition-fast: 0.15s ease;
    --transition-base: 0.3s ease;
    --transition-slow: 0.5s ease;

    /* ============================================
       DOCUMENTAÇÃO - ESTILOS MODERNOS
       ============================================ */

    /* ===== VARIÁVEIS CSS ===== */

        /* Cores Base */
    --docs-bg: #ffffff;
    --docs-bg-secondary: #f9fafb;
    --docs-bg-tertiary: #f3f4f6;
    --docs-text: #1f2937;
    --docs-text-secondary: #6b7280;
    --docs-text-muted: #9ca3af;

    /* Cores de Destaque */
    --docs-primary: #002B5B;
    --docs-primary-light: #005691;
    --docs-accent: #FFD700;
    --docs-accent-dark: #f59e0b;

    /* Sidebar */
    --docs-sidebar-bg: #ffffff;
    --docs-sidebar-border: #e5e7eb;
    --docs-sidebar-hover: #f3f4f6;
    --docs-sidebar-active: #eff6ff;

    /* Código */
    --docs-code-bg: #1e293b;
    --docs-code-text: #f1f5f9;
    --docs-inline-code-bg: #f1f5f9;
    --docs-inline-code-text: #be123c;
    --docs-inline-code-border: #e5e7eb;

    /* Componentes */
    --docs-border: #e5e7eb;
    --docs-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --docs-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --docs-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --docs-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

    /* Animações */
    --docs-transition: all 0.2s ease;
    --docs-transition-slow: all 0.3s ease;

    /* Dimensões */
    --docs-sidebar-width: 280px;
    --docs-toc-width: 240px;
    --docs-header-height: 64px;

}


/* Body Base */
body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto,
                 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #e8eef5 0%, #d4dce8 100%);
    min-height: 100vh;
    padding: 0;
    color: var(--ippls-blue-dark);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Container Principal */
.main-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.25rem;
}

/* Classes Utilitárias */
.inline-form {
    display: inline;
}

/* Animações Globais */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes wave {
    0%, 100% { transform: rotate(0deg); }
    25% { transform: rotate(20deg); }
    75% { transform: rotate(-20deg); }
}

@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}
CSS;
    }

    private function getFooterCssPadrao(): string
    {
        return <<<'CSS'
    /* ============================================
    RODAPÉ
    ============================================ */

.footer {
    background: var(--gray-900);
    color: white;
    margin-top: 0.1rem;
    padding: 2.5rem 2rem;
    border-top: 3px solid var(--ippls-gold);
    z-index: 100;
}

.footer-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media (min-width: 768px) {
    .footer-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
    }
}

.footer-section {
    flex: 1;
    min-width: 200px;
}

.footer-logo {
    height: 60px;
    margin-bottom: 1rem;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}

.footer-desc {
    color: var(--gray-400);
    font-size: 0.9rem;
    line-height: 1.6;
}

.footer-heading {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--ippls-gold);
    margin-bottom: 1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--gray-400);
}

.footer-links a {
    color: var(--gray-400);
    text-decoration: none;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: var(--ippls-gold);
}

.footer-bottom {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-700);
    text-align: center;
}

.footer-bottom p {
    margin: 0.5rem 0;
    font-size: 0.95rem;
    color: var(--gray-400);
}

.footer-bottom strong {
    color: var(--ippls-gold);
    font-weight: 600;
}

.footer-version {
    font-size: 0.75rem;
    color: var(--gray-400);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.footer-heart {
    color: var(--ippls-red);
    animation: heartbeat 1.5s ease-in-out infinite;
}
CSS;
    }

    private function getHeroCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   SEÇÃO HERO
   ============================================ */

/* Container Principal */
.hero-section {
    padding: 1.5rem 1rem;
    margin: 0;
    border-radius: 0;
    background: var(--gray-900);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    position: relative;
}

@media (min-width: 768px) {
    .hero-section {
        padding: 2.5rem 1.25rem;
        margin: 0;
    }
}

.hero-container {
    width: 100%;
    max-width: 1400px;
    padding: 0 1rem;
}

/* Layout em Grade */
.hero-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: center;
}

@media (min-width: 768px) {
    .hero-grid {
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
}

/* Conteúdo Hero (Esquerda) */
.hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    z-index: 10;
}

@media (min-width: 768px) {
    .hero-content {
        text-align: left;
    }
}

/* Títulos */
.hero-title {
    font-size: 2rem;
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 480px) {
    .hero-title {
        font-size: 2.5rem;
    }
}

@media (min-width: 640px) {
    .hero-title {
        font-size: 3rem;
    }
}

@media (min-width: 768px) {
    .hero-title {
        font-size: 3.5rem;
    }
}

@media (min-width: 1024px) {
    .hero-title {
        font-size: 4.5rem;
    }
}

.hero-title-highlight {
    color: var(--ippls-gold);
}

.hero-subtitle {
    margin-top: 1rem;
    font-size: 1rem;
    font-weight: 500;
    color: var(--gray-400);
    text-wrap: balance;
}

@media (min-width: 640px) {
    .hero-subtitle {
        font-size: 1.125rem;
    }
}

@media (min-width: 768px) {
    .hero-subtitle {
        font-size: 1.25rem;
    }
}

/* Badge de Boas-Vindas */
.welcome-container {
    margin-bottom: 1rem;
    display: inline-block;
}

@media (min-width: 640px) {
    .welcome-container {
        margin-bottom: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .welcome-container {
        margin-bottom: 2rem;
    }
}

.welcome-icon {
    font-size: 1.5rem;
    animation: wave 2s ease-in-out infinite;
}

.welcome-text {
    font-size: 0.875rem;
    color: var(--ippls-gold);
    font-weight: 900;
    text-transform: uppercase;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

@media (min-width: 640px) {
    .welcome-text {
        font-size: 0.95rem;
    }
}

/* Botões da Seção Hero */
.hero-buttons {
    margin-top: 2rem;
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Visual Hero (Direita) */
.hero-visual {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    min-height: 200px;
}

@media (min-width: 640px) {
    .hero-visual {
        padding: 2rem;
        min-height: 250px;
    }
}

@media (min-width: 768px) {
    .hero-visual {
        padding: 2.5rem;
        min-height: 300px;
    }
}

/* Blocos Decorativos */
.decoration-block-top {
    position: absolute;
    top: -1rem;
    left: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(12deg);
    border-radius: 0.5rem;
    border-bottom: 3px solid var(--ippls-gold-dark);
    border-right: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-top {
        top: -1.5rem;
        left: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-top {
        top: -2.5rem;
        left: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-bottom: 4px solid var(--ippls-gold-dark);
        border-right: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-top {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-top {
        top: -5rem;
        width: 16rem;
        height: 16rem;
    }
}

.decoration-block-bottom {
    position: absolute;
    bottom: -1rem;
    right: -1rem;
    width: 4rem;
    height: 4rem;
    background: var(--ippls-gold);
    transform: rotate(-12deg);
    border-radius: 0.5rem;
    border-right: 3px solid var(--ippls-gold-dark);
    border-bottom: 5px solid var(--ippls-gold-dark);
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (min-width: 640px) {
    .decoration-block-bottom {
        bottom: -1.5rem;
        right: -1.5rem;
        width: 6rem;
        height: 6rem;
    }
}

@media (min-width: 768px) {
    .decoration-block-bottom {
        bottom: -2.5rem;
        right: -2.5rem;
        width: 8rem;
        height: 8rem;
        border-right: 4px solid var(--ippls-gold-dark);
        border-bottom: 8px solid var(--ippls-gold-dark);
    }
}

@media (min-width: 1024px) {
    .decoration-block-bottom {
        width: 12rem;
        height: 12rem;
    }
}

@media (min-width: 1280px) {
    .decoration-block-bottom {
        bottom: -5rem;
        right: -4rem;
        width: 16rem;
        height: 16rem;
    }
}

/* Logos */
.logo {
    height: 50px;
    width: auto;
    display: block;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.4))
            drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3))
            drop-shadow(0 2px 4px rgba(255, 255, 255, 0.2));
}

@media (min-width: 480px) {
    .logo {
        height: 60px;
        filter: drop-shadow(0 12px 24px rgba(255, 255, 255, 0.45))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.35))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.25));
    }
}

@media (min-width: 640px) {
    .logo {
        height: 70px;
        filter: drop-shadow(0 15px 30px rgba(255, 255, 255, 0.5))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.4))
                drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 768px) {
    .logo {
        height: 80px;
        filter: drop-shadow(0 18px 36px rgba(255, 255, 255, 0.55))
                drop-shadow(0 10px 20px rgba(255, 255, 255, 0.45))
                drop-shadow(0 5px 10px rgba(255, 255, 255, 0.35));
    }
}

@media (min-width: 1024px) {
    .logo {
        height: 100px;
        filter: drop-shadow(0 20px 40px rgba(255, 255, 255, 0.6))
                drop-shadow(0 12px 24px rgba(255, 255, 255, 0.5))
                drop-shadow(0 6px 12px rgba(255, 255, 255, 0.4))
                drop-shadow(0 2px 4px rgba(255, 255, 255, 0.3));
    }
}

@media (min-width: 1280px) {
    .logo {
        height: 120px;
        filter: drop-shadow(0 25px 50px rgba(255, 255, 255, 0.65))
                drop-shadow(0 15px 30px rgba(255, 255, 255, 0.55))
                drop-shadow(0 8px 16px rgba(255, 255, 255, 0.45))
                drop-shadow(0 3px 6px rgba(255, 255, 255, 0.35));
    }
}

.logo:hover {
    transform: scale(1.08) translateY(-4px);
    filter: drop-shadow(0 30px 60px rgba(255, 255, 255, 0.8))
            drop-shadow(0 20px 40px rgba(255, 255, 255, 0.7))
            drop-shadow(0 10px 20px rgba(244, 180, 26, 0.6))
            drop-shadow(0 5px 10px rgba(244, 180, 26, 0.8));
}

/* Card de Destaque */
.feature-card {
    position: relative;
    z-index: 10;
    background: var(--gray-800);
    padding: 1rem;
    width: 100%;
    max-width: 100%;
    text-align: center;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    transform: rotate(-2deg);
    border-radius: 0.75rem;
    border-bottom: 3px solid #050f1f;
    border-right: 5px solid #050f1f;
}

@media (min-width: 640px) {
    .feature-card {
        padding: 1.5rem;
        border-bottom: 4px solid #050f1f;
        border-right: 8px solid #050f1f;
    }
}

.feature-card-title {
    font-size: 1.25rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--gray-50);
    word-wrap: break-word;
    hyphens: auto;
}

@media (min-width: 480px) {
    .feature-card-title {
        font-size: 1.5rem;
    }
}

@media (min-width: 640px) {
    .feature-card-title {
        font-size: 1.875rem;
    }
}

.feature-card-subtitle {
    margin-top: 0.25rem;
    font-size: 0.75rem;
    font-weight: 300;
    color: var(--gray-400);
}

@media (min-width: 640px) {
    .feature-card-subtitle {
        font-size: 0.875rem;
    }
}

@media (min-width: 768px) {
    .feature-card-subtitle {
        font-size: 1rem;
    }
}
CSS;
    }


    private function getSkillsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   SEÇÃO DE HABILIDADES / TECNOLOGIAS
   ============================================ */

.skills-section {
    width: 100%;
    max-width: 1200px;
    margin: 3rem auto;
    text-align: center;
    padding: 2rem 1.5rem;
}

.skills-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--ippls-blue-dark);
    margin-bottom: 2rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    line-height: 1.1;
}

@media (min-width: 768px) {
    .skills-title {
        font-size: 2.5rem;
    }
}

.skills-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (min-width: 640px) {
    .skills-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 768px) {
    .skills-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }
}

.skill-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 1rem;
    background: var(--gray-900);
    border-radius: 0.75rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.skill-card:hover {
    transform: scale(1.05) translateY(-5px);
    background: var(--gray-800);
    border-color: var(--ippls-gold);
    box-shadow: 0 15px 35px rgba(244, 180, 26, 0.3);
}

.skill-icon {
    width: 3rem;
    height: 3rem;
    margin-bottom: 0.75rem;
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .skill-icon {
        width: 3.5rem;
        height: 3.5rem;
    }
}

.skill-card:hover .skill-icon {
    transform: rotateY(360deg);
}

.skill-name {
    color: #d1d5db;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .skill-name {
        font-size: 0.95rem;
    }
}

.skill-card:hover .skill-name {
    color: var(--ippls-gold);
}
CSS;
    }

    private function getAlertsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   ALERTAS E MENSAGENS FLASH
   ============================================ */

.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-weight: 600;
    animation: slideDown 0.3s ease;
    border-left: 4px solid;
    position: relative;
    z-index: 1000;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border-color: #28a745;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    border-color: #dc3545;
}

.alert-warning {
    background: #fff3cd;
    color: #856404;
    border-color: #ffc107;
}

.alert-info {
    background: #d1ecf1;
    color: #0c5460;
    border-color: #17a2b8;
}
CSS;

    }
    private function getButtonsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   BOTÕES - COMPONENTES
   ============================================ */

/* Grupo de Botões */
.button-group {
    display: flex;
    gap: 1rem;
    padding-top: 1rem;
    flex-wrap: wrap;
}

/* Botão Base */
.btn {
    padding: 0.875rem 2rem;
    border: none;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    cursor: pointer;
    transition: all var(--transition-base);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

/* Botão Primário */
.btn-primary {
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
    border-bottom: 3px solid var(--ippls-gold-dark);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(244, 180, 26, 0.4);
}

/* Botão Secundário */
.btn-secondary {
    background: transparent;
    color: var(--gray-400);
    border: 2px solid var(--gray-700);
}

.btn-secondary:hover {
    background: var(--gray-800);
    border-color: var(--gray-400);
    color: white;
}

/* Botão Pequeno */
.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

/* Botão Editar */
.btn-edit {
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
    border: none;
}

.btn-edit:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-1px);
}

/* Botão Deletar */
.btn-delete {
    background: var(--ippls-red);
    color: white;
    border: none;
}

.btn-delete:hover {
    background: #9d1f23;
    transform: translateY(-1px);
}

/* Botões Hero */
.btn-hero {
    border-radius: 0.25rem;
    padding: 0.875rem 2rem;
    flex-grow: 1;
    text-align: center;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.875rem;
    letter-spacing: 0.1em;
    transition: all var(--transition-base);
    text-decoration: none;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.btn-hero-primary {
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
}

.btn-hero-primary:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(244, 180, 26, 0.3);
}

.btn-hero-secondary {
    border: 2px solid var(--ippls-gold);
    color: var(--ippls-gold);
    background: transparent;
}

.btn-hero-secondary:hover {
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
}

/* Botões de Ação */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* ============================================
   BOTÃO BACK TO TOP
   ============================================ */

.back-to-top {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 50px;
    height: 50px;
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
    border: none;
    border-radius: 50%;
    border-bottom: 3px solid var(--ippls-gold-dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    opacity: 0;
    visibility: hidden;
    transform: translateY(100px);
    transition: all var(--transition-base);
    box-shadow: var(--shadow-lg);
    z-index: 999;
}

.back-to-top:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(244, 180, 26, 0.5);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.back-to-top i {
    animation: bounceUp 2s ease-in-out infinite;
}

@keyframes bounceUp {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

/* Responsividade */
@media (max-width: 768px) {
    .button-group {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn-sm {
        width: 100%;
    }

    .back-to-top {
        bottom: 1.5rem;
        right: 1.5rem;
        width: 45px;
        height: 45px;
        font-size: 1.125rem;
    }
}
CSS;

    }
    private function getCardsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   CARDS
   ============================================ */

.card {
    background: var(--gray-900);
    color: white;
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    margin-bottom: 2rem;
    border-bottom: 4px solid #050f1f;
    border-right: 6px solid #050f1f;
}

.card-header {
    background: var(--gray-800);
    padding: 1.5rem 2rem;
    border-bottom: 3px solid var(--ippls-gold);
}

.card-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.card-body {
    padding: 2rem;
    background: var(--gray-900);
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem;
    }
}

/* Estado Vazio */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--gray-400);
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    color: white;
    text-transform: uppercase;
    font-weight: 700;
}

.empty-state p {
    color: var(--gray-400);
    font-size: 1rem;
}
CSS;
    }

    private function getErrorsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   PÁGINAS DE ERRO (404, 500, etc)
   ============================================ */

.error-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
}

.error-content {
    max-width: 600px;
    width: 100%;
    text-align: center;
    background: var(--gray-800);
    padding: 3rem 2rem;
    border-radius: 1rem;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
    border-bottom: 4px solid var(--ippls-gold);
    border-right: 6px solid var(--ippls-gold);
}

.error-icon {
    position: relative;
    margin-bottom: 2rem;
}

.error-number {
    font-size: 8rem;
    font-weight: 900;
    color: var(--ippls-gold);
    text-shadow: 0 4px 8px rgba(244, 180, 26, 0.3);
    line-height: 1;
    display: block;
}

@media (min-width: 768px) {
    .error-number {
        font-size: 10rem;
    }
}

.error-decoration {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(12deg);
    width: 200px;
    height: 200px;
    background: var(--ippls-gold);
    opacity: 0.1;
    border-radius: 1rem;
    z-index: -1;
}

.error-title {
    font-size: 1.75rem;
    font-weight: 900;
    text-transform: uppercase;
    color: white;
    margin-bottom: 1rem;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .error-title {
        font-size: 2.25rem;
    }
}

.error-message {
    font-size: 1.125rem;
    color: var(--gray-400);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.error-suggestions {
    background: var(--gray-900);
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 2rem;
    border-left: 3px solid var(--ippls-gold);
}

.error-suggestions h2 {
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--ippls-gold);
    margin-bottom: 1rem;
}

.error-suggestions ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-suggestions li {
    color: var(--gray-400);
    padding: 0.5rem 0;
    text-align: left;
    position: relative;
    padding-left: 1.5rem;
}

.error-suggestions li::before {
    content: "→";
    position: absolute;
    left: 0;
    color: var(--ippls-gold);
    font-weight: 700;
}

.error-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 2rem;
}

.error-footer {
    padding-top: 2rem;
    border-top: 1px solid var(--gray-700);
}

.error-logo {
    height: 50px;
    margin-bottom: 0.5rem;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}

.error-footer p {
    font-size: 0.875rem;
    color: var(--gray-400);
    margin: 0;
}
CSS;
    }

    private function getFormsCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   FORMULÁRIOS - COMPONENTES
   ============================================ */

/* Grid de Formulário */
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
    }
}

/* Grupo de Campo */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Label */
.form-label {
    font-weight: 700;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--gray-400);
}

/* Input */
.form-input {
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-700);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: all var(--transition-base);
    background: var(--gray-800);
    color: white;
}

.form-input:focus {
    outline: none;
    border-color: var(--ippls-gold);
    background: var(--gray-700);
    box-shadow: 0 0 0 3px rgba(244, 180, 26, 0.1);
}

.form-input::placeholder {
    color: var(--gray-400);
}

/* Input Error State */
.form-input.error {
    border-color: var(--ippls-red);
}

.form-input.error:focus {
    border-color: var(--ippls-red);
    box-shadow: 0 0 0 3px rgba(193, 39, 45, 0.1);
}

/* Input Success State */
.form-input.success {
    border-color: #28a745;
}

/* Mensagem de Erro */
.form-error {
    font-size: 0.75rem;
    color: var(--ippls-red);
    margin-top: 0.25rem;
}

/* Mensagem de Ajuda */
.form-help {
    font-size: 0.75rem;
    color: var(--gray-400);
    margin-top: 0.25rem;
}
CSS;
    }

    private function getNavbarCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   NAVBAR - BARRA DE NAVEGAÇÃO
   ============================================ */

/* Container da Navbar */
.navbar {
    background: var(--ippls-blue-dark);
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 3px solid var(--ippls-gold);
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    gap: 1rem;
}

/* Brand/Logo */
.navbar-brand {
    flex-shrink: 0;
}

.navbar-logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 10px 20px rgba(255, 255, 255, 0.4))
            drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3))
            drop-shadow(0 2px 4px rgba(255, 255, 255, 0.2));
}

.navbar-logo:hover {
    opacity: 0.8;
}

.navbar-logo-img {
    height: 50px;
    width: auto;
}

.navbar-logo-text {
    font-size: 1.25rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: var(--ippls-gold);
    display: none;
}

@media (min-width: 640px) {
    .navbar-logo-text {
        display: inline;
    }
}

/* Menu de Navegação */
.navbar-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
    gap: 0;
}

@media (min-width: 768px) {
    .navbar-menu {
        display: flex;
        gap: 0;
    }
}

/* Item do Menu */
.navbar-item {
    position: relative;
}

.navbar-link {
    display: block;
    padding: 0.875rem 1.5rem;
    color: white;
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.05em;
    transition: all var(--transition-base);
    border-bottom: 3px solid transparent;
}

.navbar-link:hover {
    color: var(--ippls-gold);
    border-bottom-color: var(--ippls-gold);
    background-color: rgba(244, 180, 26, 0.05);
}

/* Botão Toggle Mobile */
.navbar-toggle {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    gap: 0.35rem;
    z-index: 120; /* garantir que fique acima de overlays */
}

@media (min-width: 768px) {
    .navbar-toggle {
        display: none;
    }
}

.hamburger-line {
    width: 25px;
    height: 3px;
    background: var(--ippls-gold);
    transition: all var(--transition-base);
    border-radius: 2px;
}

.navbar-toggle.active .hamburger-line:nth-child(1) {
    transform: rotate(45deg) translate(10px, 10px);
}

.navbar-toggle.active .hamburger-line:nth-child(2) {
    opacity: 0;
}

.navbar-toggle.active .hamburger-line:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

/* Menu Mobile */
@media (max-width: 767px) {
    .navbar-menu {
        display: flex;
        position: absolute;
        top: 70px;
        left: 0;
        right: 0;
        background: var(--ippls-blue-dark);
        border-bottom: 3px solid var(--ippls-gold);
        flex-direction: column;
        gap: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-in-out;
        opacity: 0;
        z-index: 110; /* garantir prioridade sobre outros elementos */
    }

    .navbar-menu.active {
        max-height: 500px;
        opacity: 1;
    }

    .navbar-item {
        width: 100%;
    }

    .navbar-link {
        border-bottom: 1px solid var(--gray-700);
    }

    .navbar-link:hover {
        border-bottom-color: var(--ippls-gold);
    }
}

/* Ações (Botões direita) */
.navbar-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-shrink: 0;
}

@media (max-width: 767px) {
    .navbar-actions {
        gap: 0.5rem;
    }
}

/* Responsivo: Redimensionar botões */
@media (max-width: 480px) {
    .navbar-container {
        height: 60px;
        padding: 0 0.75rem;
    }

    .navbar-logo-img {
        height: 40px;
    }

    .navbar-link {
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.7rem;
    }
}

/* Ativo (página atual) */
.navbar-link.active {
    color: var(--ippls-gold);
    border-bottom-color: var(--ippls-gold);
    background-color: rgba(244, 180, 26, 0.1);
}
CSS;
    }

    private function getTablesCssPadrao(): string
    {
        return <<<'CSS'
/* ============================================
   TABELAS
   ============================================ */

.table-wrapper {
    overflow-x: auto;
    border-radius: 0.5rem;
    border: 2px solid var(--gray-800);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-800);
}

.data-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.1em;
    color: var(--ippls-gold);
}

.data-table td {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-800);
}

.data-table tbody tr {
    transition: background-color 0.2s ease;
}

.data-table tbody tr:hover {
    background: var(--gray-800);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}
CSS;
    }

    private function getDocsCssPadrao():string {
        return <<<'CSS'
/* ============================================
   DOCUMENTAÇÃO - ESTILOS TOTALMENTE RESPONSIVOS
   ============================================ */

/* ===== VARIÁVEIS ===== */
:root {
    /* Cores Light */
    /* --docs-bg: #ffffff; */
    --docs-bg-secondary: #f8fafc;
    --docs-text: #0f172a;
    --docs-text-secondary: #475569;
    --docs-text-muted: #94a3b8;
    --docs-primary: #002B5B;
    --docs-accent: #FFD700;
    --docs-border: #e2e8f0;

    /* Sidebar */
    --docs-sidebar-bg: #ffffff;
    --docs-sidebar-hover: #f1f5f9;
    --docs-sidebar-active: #dbeafe;

    /* Código */
    --docs-code-bg: #1e293b;
    --docs-code-text: #e2e8f0;
    --docs-inline-code-bg: #e0e7ff;
    --docs-inline-code-text: #4338ca;

    /* Sombras */
    --docs-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    --docs-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --docs-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);

    /* Dimensões */
    --docs-sidebar-width: 280px;
    --docs-header-height: 70px;

    /* Transições */
    --docs-transition: all 0.2s ease;
}

/* Tema Escuro */
body.dark-theme {
    --docs-bg: #0f172a;
    --docs-bg-secondary: #1e293b;
    --docs-text: #f1f5f9;
    --docs-text-secondary: #cbd5e1;
    --docs-text-muted: #64748b;
    --docs-sidebar-bg: #1e293b;
    --docs-sidebar-hover: #334155;
    --docs-sidebar-active: #1e3a8a;
    --docs-code-bg: #020617;
    --docs-inline-code-bg: #312e81;
    --docs-inline-code-text: #a5b4fc;
    --docs-border: #334155;
}

/* ===== LAYOUT PRINCIPAL ===== */
.docs-wrapper {
    display: flex;
    min-height: calc(100vh - 200px);
    background: var(--docs-bg);
    position: relative;
}

/* ===== SIDEBAR ===== */
.docs-sidebar {
    width: var(--docs-sidebar-width);
    background: var(--docs-sidebar-bg);
    border-right: 1px solid var(--docs-border);
    display: flex;
    flex-direction: column;
    position: fixed;
    top: var(--docs-header-height);
    left: 0;
    height: calc(100% - var(--docs-header-height));
    overflow-y: auto;
    z-index: 90; /* abaixo da navbar (navbar z-index: 100) */
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: var(--docs-shadow-md);
}

.docs-sidebar-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--docs-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-shrink: 0;
    background: var(--docs-sidebar-bg);
    position: sticky;
    top: 0;
    z-index: 10;
}

.docs-sidebar-header h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--docs-text);
    display: flex;
    align-items: center;
    gap: 0.625rem;
    margin: 0;
}

.docs-sidebar-header h3 i {
    color: var(--docs-primary);
}

body.dark-theme .docs-sidebar-header h3 i {
    color: var(--docs-code-text);
}

.docs-sidebar-close {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--docs-text-secondary);
    cursor: pointer;
    padding: 0.375rem;
    transition: var(--docs-transition);
    border-radius: 0.375rem;
}

.docs-sidebar-close:hover {
    color: var(--docs-text);
    background: var(--docs-sidebar-hover);
}

/* Pesquisa */
.docs-sidebar-search {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--docs-border);
    position: relative;
    flex-shrink: 0;
    background: var(--docs-sidebar-bg);
    position: sticky;
    top: 65px;
    z-index: 9;
}

.docs-sidebar-search i {
    position: absolute;
    left: 2rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--docs-text-muted);
    font-size: 0.875rem;
}

.docs-sidebar-search input {
    width: 100%;
    padding: 0.625rem 0.875rem 0.625rem 2.25rem;
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    background: var(--docs-bg);
    color: var(--docs-text);
    font-size: 0.875rem;
    transition: var(--docs-transition);
}

.docs-sidebar-search input:focus {
    outline: none;
    border-color: var(--docs-primary);
    box-shadow: 0 0 0 3px rgba(0, 43, 91, 0.1);
}

.docs-sidebar-search input::placeholder {
    color: var(--docs-text-muted);
}

/* Navegação */
.docs-sidebar-nav {
    flex: 1;
    overflow-y: auto;
    padding: 0.75rem 0;
}

.docs-nav-item {
    display: block;
    padding: 0.625rem 1.5rem;
    color: var(--docs-text-secondary);
    text-decoration: none;
    font-size: 0.875rem;
    transition: var(--docs-transition);
    border-left: 3px solid transparent;
    line-height: 1.5;
}

.docs-nav-item:hover {
    color: var(--docs-text);
    background: var(--docs-sidebar-hover);
    border-left-color: var(--docs-text-muted);
}

.docs-nav-item.active {
    color: var(--docs-primary);
    background: var(--docs-sidebar-active);
    border-left-color: var(--docs-primary);
    font-weight: 600;
}

body.dark-theme .docs-nav-item.active {
    color: #e0e7ff;
}


.docs-nav-level-2 {
    padding-left: 2.25rem;
    font-size: 0.8125rem;
}

.docs-nav-level-3 {
    padding-left: 3rem;
    font-size: 0.8125rem;
}

/* Footer Sidebar */
.docs-sidebar-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--docs-border);
    flex-shrink: 0;
    background: var(--docs-sidebar-bg);
}

.docs-github-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.625rem;
    padding: 0.75rem 1rem;
    background: var(--docs-bg);
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    color: var(--docs-text);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    transition: var(--docs-transition);
}

.docs-github-link:hover {
    background: var(--docs-sidebar-hover);
    border-color: var(--docs-text-muted);
}

/* ===== CONTEÚDO PRINCIPAL ===== */
.docs-content-wrapper {
    flex: 1;
    margin-left: var(--docs-sidebar-width);
    padding: 0 2rem;
    max-width: none; /* permitir que o conteúdo ocupe todo o espaço disponível */
    width: auto;
    box-sizing: border-box;
}

/* Header */
.docs-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--docs-border);
    margin-bottom: 2rem;
}

.docs-menu-toggle {
    display: none;
    background: var(--docs-bg-secondary);
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    width: 2.75rem;
    height: 2.75rem;
    align-items: center;
    justify-content: center;
    color: var(--docs-text);
    cursor: pointer;
    font-size: 1.25rem;
    flex-shrink: 0;
    transition: var(--docs-transition);
}

.docs-menu-toggle:hover {
    background: var(--docs-sidebar-hover);
}

.docs-header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}

.docs-header-icon {
    width: 3.25rem;
    height: 3.25rem;
    background: linear-gradient(135deg, var(--docs-primary), #005691);
    border-radius: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.625rem;
    flex-shrink: 0;
    box-shadow: var(--docs-shadow-md);
}

.docs-header-text {
    flex: 1;
    min-width: 0;
}

.docs-header-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--docs-text);
    margin: 0;
    line-height: 1.2;
}

.docs-header-subtitle {
    font-size: 1rem;
    color: var(--docs-text-secondary);
    margin: 0.25rem 0 0;
}

.docs-header-actions {
    display: flex;
    gap: 0.625rem;
    flex-shrink: 0;
}

.docs-theme-toggle {
    width: 2.75rem;
    height: 2.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--docs-bg-secondary);
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    color: var(--docs-text);
    cursor: pointer;
    font-size: 1.125rem;
    transition: var(--docs-transition);
}

.docs-theme-toggle:hover {
    background: var(--docs-sidebar-hover);
}

/* Breadcrumb */
.docs-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0 0 1.5rem;
    font-size: 0.875rem;
    color: var(--docs-text-secondary);
}

.docs-breadcrumb a {
    color: var(--docs-text-secondary);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    transition: var(--docs-transition);
}

.docs-breadcrumb a:hover {
    color: var(--docs-primary);
}

.docs-breadcrumb i {
    font-size: 0.75rem;
}

/* ===== CONTEÚDO ===== */
.docs-content {
    padding-bottom: 3rem;
    line-height: 1.75;
}

/* Tipografia */
.docs-content h1 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--docs-text);
    margin: 2rem 0 1.25rem;
    padding-bottom: 0.875rem;
    border-bottom: 2px solid var(--docs-border);
    line-height: 1.2;
}

.docs-content h1:first-child {
    margin-top: 0;
}

.docs-content h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--docs-text);
    margin: 2.5rem 0 1rem;
    padding-left: 1rem;
    border-left: 4px solid var(--docs-accent);
    line-height: 1.3;
}

.docs-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--docs-text);
    margin: 2rem 0 0.875rem;
    line-height: 1.4;
}

.docs-content h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--docs-text);
    margin: 1.5rem 0 0.75rem;
}

.docs-content p {
    margin: 0 0 1.25rem;
    color: var(--docs-text);
}

/* Links */
.docs-content a {
    color: var(--docs-primary);
    text-decoration: none;
    font-weight: 500;
    transition: var(--docs-transition);
    border-bottom: 1px solid transparent;
}

.docs-content a:hover {
    color: #005691;
    border-bottom-color: currentColor;
}

/* Listas */
.docs-content ul,
.docs-content ol {
    margin: 1.25rem 0;
    padding-left: 2rem;
}

.docs-content li {
    margin: 0.625rem 0;
    color: var(--docs-text);
    line-height: 1.6;
}

/* Task Lists */
.task-list {
    list-style: none;
    padding-left: 0 !important;
}

.task-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.task-item i {
    color: var(--docs-text-muted);
    margin-top: 0.25rem;
    font-size: 1.125rem;
}

.task-item.checked i {
    color: var(--docs-primary);
}

/* Código */
.inline-code {
    background: var(--docs-inline-code-bg);
    color: var(--docs-inline-code-text);
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875em;
    font-weight: 600;
    border: 1px solid var(--docs-border);
}

.docs-content pre {
    background: var(--docs-code-bg);
    color: var(--docs-code-text);
    padding: 1.5rem;
    border-radius: 0.75rem;
    overflow-x: auto;
    margin: 1.5rem 0;
    box-shadow: var(--docs-shadow-md);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.docs-content pre code {
    background: transparent;
    color: inherit;
    padding: 0;
    font-size: 0.875rem;
    line-height: 1.7;
    font-family: 'Courier New', monospace;
}

/* Tabelas */
.table-container {
    overflow-x: auto;
    margin: 1.5rem 0;
    border-radius: 0.625rem;
    border: 1px solid var(--docs-border);
    box-shadow: var(--docs-shadow);
}

.docs-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.875rem;
}

.docs-table th {
    background: var(--docs-bg-secondary);
    padding: 1rem 1.25rem;
    text-align: left;
    font-weight: 700;
    color: var(--docs-text);
    border-bottom: 2px solid var(--docs-border);
}

.docs-table td {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--docs-border);
    color: var(--docs-text);
}

.docs-table tr:last-child td {
    border-bottom: none;
}

.docs-table tr:hover {
    background: var(--docs-bg-secondary);
}

/* Badges */
.badge-img {
    display: inline-block;
    margin: 0.25rem 0.25rem 0.25rem 0;
    height: 20px;
    vertical-align: middle;
}

/* Imagens */
.content-img {
    max-width: 100%;
    height: auto;
    border-radius: 0.625rem;
    margin: 1.5rem 0;
    box-shadow: var(--docs-shadow-md);
    border: 1px solid var(--docs-border);
}

/* Blockquotes */
.docs-quote {
    background: var(--docs-bg-secondary);
    border-left: 4px solid var(--docs-accent);
    padding: 1.25rem 1.5rem;
    margin: 1.5rem 0;
    border-radius: 0 0.5rem 0.5rem 0;
    color: var(--docs-text);
}

/* Divider */
.docs-divider {
    border: none;
    height: 2px;
    background: linear-gradient(to right, var(--docs-border), transparent);
    margin: 2.5rem 0;
}

/* Navegação Página */
.docs-page-nav {
    margin: 3rem 0 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--docs-border);
    text-align: center;
}

.docs-page-nav-top {
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.875rem 1.75rem;
    background: var(--docs-bg-secondary);
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    color: var(--docs-text);
    text-decoration: none;
    font-weight: 500;
    transition: var(--docs-transition);
}

.docs-page-nav-top:hover {
    background: var(--docs-primary);
    color: white;
    border-color: var(--docs-primary);
}

/* Footer Conteúdo */
.docs-content-footer {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
    padding: 2rem;
    background: var(--docs-bg-secondary);
    border-radius: 0.875rem;
    border: 1px solid var(--docs-border);
}

.docs-footer-section h4 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--docs-text);
    margin: 0 0 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.docs-footer-section h4 i {
    color: var(--docs-primary);
}

.docs-footer-section p {
    color: var(--docs-text-secondary);
    font-size: 0.875rem;
    margin: 0 0 1rem;
}

.docs-footer-links {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.docs-footer-links a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.125rem;
    background: var(--docs-bg);
    border: 1px solid var(--docs-border);
    border-radius: 0.5rem;
    color: var(--docs-text);
    text-decoration: none;
    font-size: 0.875rem;
    transition: var(--docs-transition);
}

.docs-footer-links a:hover {
    background: var(--docs-primary);
    color: white;
    border-color: var(--docs-primary);
}

/* Estado Vazio */
.docs-empty-state {
    text-align: center;
    padding: 5rem 2rem;
}

.docs-empty-state i {
    font-size: 5rem;
    color: var(--docs-text-muted);
    margin-bottom: 1.5rem;
}

.docs-empty-state h2 {
    font-size: 1.75rem;
    color: var(--docs-text);
    margin: 0 0 0.75rem;
    border: none;
    padding: 0;
}

.docs-empty-state p {
    color: var(--docs-text-secondary);
    font-size: 1rem;
}

/* Overlay Mobile */
.docs-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 999;
    display: none;
    backdrop-filter: blur(2px);
}

.docs-overlay.active {
    display: block;
}

/* ===== RESPONSIVO ===== */

/* Large Tablet */
@media (max-width: 1024px) {
    .docs-content-wrapper {
        padding: 0 1.5rem;
    }

    .docs-content h1 {
        font-size: 2.25rem;
    }

    .docs-content h2 {
        font-size: 1.75rem;
    }
}

/* Tablet */
@media (max-width: 768px) {
    /* Sidebar em mobile */
    .docs-sidebar {
        transform: translateX(-100%);
    }

    .docs-sidebar.active {
        transform: translateX(0);
    }

    .docs-sidebar-close {
        display: flex;
    }

    /* Conteúdo */
    .docs-content-wrapper {
        margin-left: 0;
        padding: 0 1.25rem;
    }

    /* Header */
    .docs-menu-toggle {
        display: flex;
    }

    .docs-header {
        padding: 1.25rem 0;
    }

    .docs-header-icon {
        width: 2.75rem;
        height: 2.75rem;
        font-size: 1.375rem;
    }

    .docs-header-title {
        font-size: 1.615rem;
    }

    .docs-header-subtitle {
        font-size: 0.9375rem;
    }

    /* Tipografia */
    .docs-content h1 {
        font-size: 2rem;
    }

    .docs-content h2 {
        font-size: 1.625rem;
        padding-left: 0.75rem;
    }

    .docs-content h3 {
        font-size: 1.375rem;
    }

    .docs-content h4 {
        font-size: 1.125rem;
    }

    /* Código */
    .docs-content pre {
        padding: 1.25rem;
        font-size: 0.8125rem;
    }

    /* Footer */
    .docs-content-footer {
        grid-template-columns: 1fr;
        padding: 1.5rem;
    }

    /* Breadcrumb */
    .docs-breadcrumb {
        font-size: 0.8125rem;
    }
}

/* Mobile pequeno */
@media (max-width: 480px) {
    .docs-content-wrapper {
        padding: 0 1rem;
    }

    .docs-header {
        padding: 1rem 0;
    }

    .docs-header-icon {
        width: 2.5rem;
        height: 2.5rem;
        font-size: 1.25rem;
    }

    .docs-header-title {
        font-size: 1.365rem;
    }

    .docs-header-subtitle {
        display: none;
    }

    .docs-content h1 {
        font-size: 1.75rem;
    }

    .docs-content h2 {
        font-size: 1.5rem;
        padding-left: 0.625rem;
    }

    .docs-content h3 {
        font-size: 1.25rem;
    }

    .docs-table {
        font-size: 0.8125rem;
    }

    .docs-table th,
    .docs-table td {
        padding: 0.75rem 0.875rem;
    }

    .docs-footer-links {
        flex-direction: column;
    }

    .docs-footer-links a {
        justify-content: center;
    }
}

/* Mobile muito pequeno */
@media (max-width: 360px) {
    .docs-content-wrapper {
        padding: 0 0.75rem;
    }

    .docs-header-title {
        font-size: 1.15rem;
    }

    .docs-content h1 {
        font-size: 1.5rem;
    }

    .docs-content h2 {
        font-size: 1.375rem;
    }
}

/* Scrollbar */
.docs-sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.docs-sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.docs-sidebar-nav::-webkit-scrollbar-thumb {
    background: var(--docs-border);
    border-radius: 3px;
}

.docs-sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: var(--docs-text-muted);
}

/* Print */
@media print {
    .docs-sidebar,
    .docs-header-actions,
    .docs-menu-toggle,
    .docs-breadcrumb,
    .docs-page-nav,
    .docs-overlay,
    .docs-content-footer {
        display: none !important;
    }

    .docs-content-wrapper {
        margin-left: 0;
        max-width: 100%;
    }

    .docs-content {
        color: #000;
    }
}

/*
   - Desktop: sidebar fixa à esquerda, conteúdo centralizado à direita
   - Mobile: sidebar vira overlay completo (abaixo da navbar)
*/

/* 1. Reset para página de docs */
body:has(.docs-wrapper) {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

body:has(.docs-wrapper) .navbar {
    flex-shrink: 0;
    z-index: 100; /* garantir prioridade sobre o conteúdo */
}

body:has(.docs-wrapper) .docs-wrapper {
    flex: 1;
    display: flex;
    position: relative;
}

/* 2. Sidebar ajustada (fixed no desktop) */
.docs-sidebar {
    position: fixed;
    top: var(--docs-header-height);
    left: 0;
    width: var(--docs-sidebar-width);
    height: calc(100vh - var(--docs-header-height));
    max-height: calc(100vh - var(--docs-header-height));
    overflow-y: auto;
    z-index: 90; /* abaixo da navbar */
    background: var(--docs-sidebar-bg);
}

/* 3. Conteúdo com espaço e centralizado */
.docs-content-wrapper {
    flex: 1;
    min-width: 0;
    position: relative;
    margin-left: var(--docs-sidebar-width);
}

.docs-content {
    min-height: calc(100vh - 350px); /* Garante espaço para o footer */
    max-width: 80rem; /* centraliza o conteúdo para leitura */
    margin: 0 auto;
}

/* 4. Mobile: sidebar como overlay completo */
@media (max-width: 768px) {
    .docs-sidebar {
        transform: translateX(-100%); /* escondida por padrão */
        position: fixed;
        top: var(--docs-header-height);
        height: calc(100vh - var(--docs-header-height));
        z-index: 1100; /* acima do overlay */
        box-shadow: var(--docs-shadow-lg);
    }

    .docs-sidebar.active {
        transform: translateX(0);
    }

    .docs-overlay {
        top: var(--docs-header-height);
        height: calc(100vh - var(--docs-header-height));
        z-index: 1000;
    }

    /* Conteúdo ocupa toda a largura quando sidebar escondida */
    .docs-content-wrapper {
        margin-left: 0;
    }
}
CSS;
    }

    // ========================================
    /* Estilos da fontawesome*/
    // ========================================

    private function getAllMinCssFA(): string
    {
        /* Retorna uma nota de que o all.min.css deve ser copiado manualmente */
        /* O all.min.css real será incluído no ZIP através de cópia do arquivo */
        return 'ALLMINFA_PLACEHOLDER - O all.min.css será incluído automaticamente no template.';
    }

    private function getMainJs(): string
    {
        return <<<'JS'
// assets/js/main.js - Scripts principais

document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ Template Base MVC carregado com sucesso! DESIGN BRUTAL');
    console.log('🏫 IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos');

    // Adicionar animação suave nas linhas da tabela
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.3s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Auto-hide mensagens após 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Validação de formulário em tempo real
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email && !emailRegex.test(email)) {
                this.style.borderColor = '#C1272D';
            } else {
                this.style.borderColor = '#4A8FC4';
            }
        });
    }
});
JS;
    }

    private function getNavbarJs(): string{
        return <<<'JS'
/**
 * Navbar - Controlador de Menu Mobile
 * Gerencia o toggle do menu hamburger e interações
 */

document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    // Garantir que os elementos existem
    if (!navbarToggle || !navbarMenu) {
        console.warn('⚠️ Navbar elements not found');
        return;
    }

    // Event: Clicar no botão hamburger
    navbarToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const isActive = navbarMenu.classList.toggle('active');
        navbarToggle.classList.toggle('active', isActive);

        // Accessibility
        navbarToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
    });

    // Event: Fechar menu ao clicar em um link
    const navLinks = navbarMenu.querySelectorAll('.navbar-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navbarMenu.classList.remove('active');
            navbarToggle.classList.remove('active');
        });
    });

    // Event: Fechar menu ao clicar fora (mobile)
    // Prevent closing when clicking inside the navbar/menu
    if (navbarMenu) {
        navbarMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    document.addEventListener('click', function(e) {
        // Only act when menu is open
        if (navbarMenu.classList.contains('active') && !e.target.closest('.navbar')) {
            navbarMenu.classList.remove('active');
            navbarToggle.classList.remove('active');
            navbarToggle.setAttribute('aria-expanded', 'false');
        }
    });
});
JS;
    }

    private function getBackToTopJS(): string {
        return <<<'JS'
/**
 * Back to Top Button
 * Botão para voltar ao topo da página com scroll suave
 */

document.addEventListener('DOMContentLoaded', function() {
    // Criar o botão dinamicamente
    const backToTopBtn = document.createElement('button');
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.id = 'backToTop';
    backToTopBtn.setAttribute('aria-label', 'Voltar ao topo');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';

    // Adicionar ao body
    document.body.appendChild(backToTopBtn);

    // Mostrar/Ocultar botão baseado no scroll
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });

    // Scroll suave ao clicar
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    console.log('✅ Back to Top button inicializado');
});
JS;
    }

    private function getDocsJs(): string{
        return <<<'JS'
/**
 * DOCS.JS - Sistema de Documentação Responsivo
 * Template Padrão IPPLS
 */

(function() {
    'use strict';

    // Elementos
    const elements = {
        sidebar: document.getElementById('docsSidebar'),
        sidebarClose: document.getElementById('sidebarClose'),
        menuToggle: document.getElementById('menuToggle'),
        sidebarNav: document.getElementById('sidebarNav'),
        docsSearch: document.getElementById('docsSearch'),
        themeToggle: document.getElementById('themeToggle'),
        docsContent: document.getElementById('docsContent'),
        overlay: document.getElementById('docsOverlay'),
    };

    // Estado
    const state = {
        currentTheme: localStorage.getItem('docs-theme') || 'light',
        sidebarOpen: false,
        searchIndex: [],
    };

    // ========================================
    // INICIALIZAÇÃO
    // ========================================
    function init() {
        applyTheme();
        buildSearchIndex();
        setupEventListeners();
        setupScrollSpy();
        setupSmoothScroll();
        highlightActiveNav();
        setupCodeCopy();
    }

    // ========================================
    // TEMA
    // ========================================
    function applyTheme() {
        if (state.currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
            if (elements.themeToggle) {
                elements.themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
        } else {
            document.body.classList.remove('dark-theme');
            if (elements.themeToggle) {
                elements.themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }
    }

    function toggleTheme() {
        state.currentTheme = state.currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('docs-theme', state.currentTheme);
        applyTheme();
    }

    // ========================================
    // SIDEBAR MOBILE
    // ========================================
    function openSidebar() {
        if (elements.sidebar && elements.overlay) {
            elements.sidebar.classList.add('active');
            elements.overlay.classList.add('active');
            state.sidebarOpen = true;
            document.body.style.overflow = 'hidden';
        }
    }

    function closeSidebar() {
        if (elements.sidebar && elements.overlay) {
            elements.sidebar.classList.remove('active');
            elements.overlay.classList.remove('active');
            state.sidebarOpen = false;
            document.body.style.overflow = '';
        }
    }

    // ========================================
    // SCROLL SPY
    // ========================================
    function setupScrollSpy() {
        if (!elements.docsContent) return;

        const headings = elements.docsContent.querySelectorAll('h1[id], h2[id], h3[id]');
        const navItems = elements.sidebarNav?.querySelectorAll('.docs-nav-item');

        if (headings.length === 0) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id;

                    navItems?.forEach(item => {
                        const href = item.getAttribute('href');
                        if (href === `#${id}`) {
                            navItems.forEach(n => n.classList.remove('active'));
                            item.classList.add('active');

                            // Scroll item into view in sidebar
                            item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                        }
                    });
                }
            });
        }, {
            rootMargin: '-80px 0px -66%',
            threshold: 0
        });

        headings.forEach(heading => observer.observe(heading));
    }

    // ========================================
    // SMOOTH SCROLL
    // ========================================
    function setupSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');

                if (href === '#') {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    closeSidebar();
                    return;
                }

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - offset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    closeSidebar();

                    if (history.pushState) {
                        history.pushState(null, null, href);
                    }
                }
            });
        });
    }

    // ========================================
    // NAVEGAÇÃO ATIVA
    // ========================================
    function highlightActiveNav() {
        if (!elements.sidebarNav) return;

        const hash = window.location.hash;

        if (hash) {
            const navItems = elements.sidebarNav.querySelectorAll('.docs-nav-item');
            navItems.forEach(item => {
                if (item.getAttribute('href') === hash) {
                    item.classList.add('active');
                    item.scrollIntoView({ block: 'nearest' });
                }
            });
        }
    }

    // ========================================
    // SISTEMA DE PESQUISA
    // ========================================
    function buildSearchIndex() {
        if (!elements.docsContent) return;

        const headings = elements.docsContent.querySelectorAll('h1, h2, h3');
        const paragraphs = elements.docsContent.querySelectorAll('p');

        headings.forEach(heading => {
            if (heading.id) {
                state.searchIndex.push({
                    type: 'heading',
                    title: heading.textContent,
                    content: heading.textContent,
                    id: heading.id
                });
            }
        });

        paragraphs.forEach((p, index) => {
            const prevHeading = getPreviousHeading(p);
            if (prevHeading) {
                state.searchIndex.push({
                    type: 'content',
                    title: prevHeading.textContent,
                    content: p.textContent,
                    id: prevHeading.id || `content-${index}`
                });
            }
        });
    }

    function getPreviousHeading(element) {
        let prev = element.previousElementSibling;

        while (prev) {
            if (prev.tagName && /^H[1-3]$/.test(prev.tagName)) {
                return prev;
            }
            prev = prev.previousElementSibling;
        }

        return null;
    }

    // ========================================
    // EVENT LISTENERS
    // ========================================
    function setupEventListeners() {
        // Tema
        if (elements.themeToggle) {
            elements.themeToggle.addEventListener('click', toggleTheme);
        }

        // Sidebar mobile
        if (elements.menuToggle) {
            elements.menuToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                openSidebar();
            });
        }

        if (elements.sidebarClose) {
            elements.sidebarClose.addEventListener('click', (e) => {
                e.stopPropagation();
                closeSidebar();
            });
        }

        // Overlay
        if (elements.overlay) {
            elements.overlay.addEventListener('click', closeSidebar);
        }

        // Impedir propagação de cliques dentro da sidebar
        if (elements.sidebar) {
            elements.sidebar.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }

        // Pesquisa na sidebar
        if (elements.docsSearch) {
            let searchTimeout;
            elements.docsSearch.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                const query = e.target.value.trim();

                searchTimeout = setTimeout(() => {
                    const navItems = elements.sidebarNav?.querySelectorAll('.docs-nav-item');

                    if (query.length >= 2) {
                        navItems?.forEach(item => {
                            const text = item.textContent.toLowerCase();
                            const isMatch = text.includes(query.toLowerCase());
                            item.style.display = isMatch ? 'block' : 'none';

                            // Highlight match
                            if (isMatch) {
                                item.style.backgroundColor = 'var(--docs-sidebar-active)';
                            } else {
                                item.style.backgroundColor = '';
                            }
                        });
                    } else {
                        navItems?.forEach(item => {
                            item.style.display = 'block';
                            item.style.backgroundColor = '';
                        });
                    }
                }, 300);
            });
        }

        // Hash change
        window.addEventListener('hashchange', highlightActiveNav);

        // Resize
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                if (window.innerWidth > 768 && state.sidebarOpen) {
                    closeSidebar();
                }
            }, 150);
        });

        // Fechar sidebar com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && state.sidebarOpen) {
                closeSidebar();
            }
        });
    }

    // ========================================
    // CÓDIGO - BOTÃO COPIAR
    // ========================================
    function setupCodeCopy() {
        const codeBlocks = document.querySelectorAll('pre code');

        codeBlocks.forEach(block => {
            const pre = block.parentElement;

            // Verifica se já tem botão
            if (pre.querySelector('.code-copy-btn')) return;

            const button = document.createElement('button');
            button.className = 'code-copy-btn';
            button.innerHTML = '<i class="fas fa-copy"></i>';
            button.title = 'Copiar código';
            button.setAttribute('aria-label', 'Copiar código');

            button.addEventListener('click', async () => {
                const code = block.textContent;

                try {
                    await navigator.clipboard.writeText(code);
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.style.color = '#10b981';

                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy"></i>';
                        button.style.color = '';
                    }, 2000);
                } catch (err) {
                    console.error('Erro ao copiar:', err);

                    // Fallback
                    const textarea = document.createElement('textarea');
                    textarea.value = code;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);

                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.style.color = '#10b981';
                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy"></i>';
                        button.style.color = '';
                    }, 2000);
                }
            });

            pre.style.position = 'relative';
            pre.appendChild(button);
        });
    }

    // ========================================
    // INICIAR
    // ========================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();

// ========================================
// ESTILOS DO BOTÃO COPIAR
// ========================================
const style = document.createElement('style');
style.textContent = `
    .code-copy-btn {
        position: absolute;
        top: 0.875rem;
        right: 0.875rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 0.375rem;
        color: rgba(255, 255, 255, 0.8);
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        backdrop-filter: blur(4px);
        z-index: 10;
    }

    .code-copy-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: scale(1.05);
    }

    .code-copy-btn:active {
        transform: scale(0.95);
    }

    @media (max-width: 768px) {
        .code-copy-btn {
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
        }
    }
`;
document.head.appendChild(style);
JS;
    }

    private function getFooterPadrao(): string{
        return <<<'PHP'
<!-- Footer -->
<div class="footer">
    <div class="footer-content">
        <div class="footer-section">
            <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="footer-logo">
            <p class="footer-desc"><i class="fas fa-layer-group"></i> Arquitetura Padrão para Desenvolver seus Projetos.</p>
            <p class="footer-desc"><i class="fas fa-box"></i> Composer e Autoloading PSR-4.</p>
        </div>

        <div class="footer-section">
            <h3 class="footer-heading"><i class="fas fa-link"></i> Links Rápidos</h3>
            <ul class="footer-links">
                <li><a href="?page=home"><i class="fas fa-home"></i> Começar</a></li>
                <li><a href="?page=docs"><i class="fas fa-book"></i> Documentação</a></li>
                <li><a href="?page=users"><i class="fas fa-users"></i> Usuários</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3 class="footer-heading"><i class="fas fa-code"></i> Tecnologias</h3>
            <ul class="footer-links">
                <li><i class="fab fa-php"></i> PHP • <i class="fas fa-database"></i> MySQL</li>
                <li><i class="fab fa-html5"></i> HTML5 • <i class="fab fa-css3-alt"></i> CSS3</li>
                <li><i class="fab fa-js"></i> JavaScript • <i class="fab fa-git-alt"></i> Git</li>
                <li><i class="fas fa-box"></i> Composer • <i class="fas fa-code-branch"></i> Psr-4</li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <p>Desenvolvido com <i class="fas fa-heart footer-heart"></i> para o <strong>IPPLS</strong></p>
        <p class="footer-version">Template Padrão MVC • v1.0.0 • 2025</p>
        <p class="footer-copyright">Pai Grande Ngola • Todos Direitos Reservados • 2025</p>
    </div>
</div>
PHP;
    }

    private function getNavbarPadrao():string
    {
        return <<<'PHP'
<!-- Barra de Navegação Principal -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-brand">
            <a href="?page=home" class="navbar-logo">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="navbar-logo-img">
                <span class="navbar-logo-text">IPPLS</span>
            </a>
        </div>

        <!-- Menu Toggle (Mobile) -->
        <button class="navbar-toggle" id="navbarToggle" aria-label="Menu">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

        <!-- Links de Navegação -->
        <ul class="navbar-menu" id="navbarMenu">
            <li class="navbar-item">
                <a href="?page=home" class="navbar-link <?= ($_GET['page'] ?? 'home') === 'home' ? 'active' : '' ?>">
                    <i class="fas fa-home"></i> Início
                </a>
            </li>
            <li class="navbar-item">
                <a href="?page=users" class="navbar-link <?= ($_GET['page'] ?? '') === 'users' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Usuários
                </a>
            </li>
            <li class="navbar-item">
                <a href="?page=docs" class="navbar-link <?= ($_GET['page'] ?? '') === 'docs' ? 'active' : '' ?>">
                    <i class="fas fa-book"></i> Documentação
                </a>
            </li>
        </ul>

        <!-- Botões de Ação -->
        <div class="navbar-actions">
            <a href="?page=users" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus"></i> Novo Usuário
            </a>
        </div>
    </div>
</nav>
PHP;
    }

    private function get404Padrao(): string{
        return <<<'PHP'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada | IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <span class="error-number">404</span>
                <div class="error-decoration"></div>
            </div>

            <h1 class="error-title">PÁGINA NÃO ENCONTRADA</h1>

            <p class="error-message">
                A página que você está procurando não existe ou foi movida.
            </p>

            <div class="error-suggestions">
                <h2>O que você pode fazer:</h2>
                <ul>
                    <li>Verificar se digitou o endereço corretamente</li>
                    <li>Voltar para a página inicial</li>
                    <li>Usar o menu de navegação</li>
                </ul>
            </div>

            <div class="error-actions">
                <a href="?page=home" class="btn-hero btn-hero-primary">
                    ← Voltar para Início
                </a>
                <a href="javascript:history.back()" class="btn-hero btn-hero-secondary">
                    Página Anterior
                </a>
            </div>

            <div class="error-footer">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="error-logo">
                <p>IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos</p>
            </div>
        </div>
    </div>

    <script>
        // Animação de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const errorContent = document.querySelector('.error-content');
            errorContent.style.opacity = '0';
            errorContent.style.transform = 'translateY(20px)';

            setTimeout(() => {
                errorContent.style.transition = 'all 0.6s ease';
                errorContent.style.opacity = '1';
                errorContent.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
PHP;
    }

    private function get500Padrao(): string{
        return <<<'PHP'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Erro Interno | IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <span class="error-number">500</span>
                <div class="error-decoration"></div>
            </div>

            <h1 class="error-title">ERRO INTERNO DO SERVIDOR</h1>

            <p class="error-message">
                Desculpe, ocorreu um erro inesperado no servidor. Nossa equipe foi notificada e está trabalhando para resolver o problema.
            </p>

            <div class="error-suggestions">
                <h2>O que você pode fazer:</h2>
                <ul>
                    <li>Aguardar alguns minutos e tentar novamente</li>
                    <li>Voltar para a página inicial</li>
                    <li>Entrar em contato com o suporte se o problema persistir</li>
                </ul>
            </div>

            <div class="error-actions">
                <a href="?action=home" class="btn-hero btn-hero-primary">
                    ← Voltar para Início
                </a>
                <a href="javascript:location.reload()" class="btn-hero btn-hero-secondary">
                    Tentar Novamente
                </a>
            </div>

            <div class="error-footer">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="error-logo">
                <p>IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorContent = document.querySelector('.error-content');
            errorContent.style.opacity = '0';
            errorContent.style.transform = 'translateY(20px)';

            setTimeout(() => {
                errorContent.style.transition = 'all 0.6s ease';
                errorContent.style.opacity = '1';
                errorContent.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
PHP;
    }





    /*
    #==========================================================================#
    ######              Ícones, logos, imagens, svg
    #==========================================================================#
    */

    private function getLogoPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'LOGO_PLACEHOLDER - O logo IPPLS será incluído automaticamente no template.';
    }

    private function getLicensePlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'LICENSEMIT_PLACEHOLDER - O logo da Licensa do MIT será incluído automaticamente no template.';
    }

    private function getApachePlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'APACHE_PLACEHOLDER - O logo do Apache será incluído automaticamente no template.';
    }

    private function getComposerPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'COMPOSER_PLACEHOLDER - O logo do Composer será incluído automaticamente no template.';
    }

    private function getCss3Placeholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'CSS3 - O logo do Css será incluído automaticamente no template.';
    }

    private function getGitPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'GIT - O logo do Git será incluído automaticamente no template.';
    }

    private function getHtml5Placeholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'HTML5 - O logo do Html5 será incluído automaticamente no template.';
    }

    private function getJavascriptPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'JAVASCRIPT - O logo do Javascript será incluído automaticamente no template.';
    }

    private function getMySqlPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'MYSQL - O logo do MySql será incluído automaticamente no template.';
    }

    private function getPhpPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'PHP - O logo do Php será incluído automaticamente no template.';
    }

    private function getXamppPlaceholder(): string
    {
        // Retorna uma nota de que o logo deve ser copiado manualmente
        // O logo real será incluído no ZIP através de cópia do arquivo
        return 'XAMPP - O logo do Xampp será incluído automaticamente no template.';
    }

    private function getFaviconPlaceholder(): string
    {
        // Retorna uma nota de que o favicon deve ser copiado manualmente
        return 'FAVICON_PLACEHOLDER - O favicon será incluído automaticamente no template.';
    }

    private function getFaBrands400Woff2(): string
    {
        // Retorna uma nota de que o fa-brands-400.woff2 deve ser copiado manualmente
        // Será incluído no ZIP através de cópia do arquivo
        return 'FABRANDS400WOFF2_PLACEHOLDER - O fa-brands-400.woff2 será incluído automaticamente no template.';
    }
    private function getFaRegular400Woff2(): string
    {
        // Retorna uma nota de que o fa-brands-400.woff2 deve ser copiado manualmente
        // Será incluído no ZIP através de cópia do arquivo
        return 'FAREGULAR400WOFF2_PLACEHOLDER - O fa-regular-400.woff2 será incluído automaticamente no template.';
    }
    private function getFaSolid400Woff2(): string
    {
        // Retorna uma nota de que o fa-brands-400.woff2 deve ser copiado manualmente
        // Será incluído no ZIP através de cópia do arquivo
        return 'FASOLID900WOFF2_PLACEHOLDER - O fa-solid-900.woff2 será incluído automaticamente no template.';
    }

    /*
    #==========================================================================#
    ######             Fim dos Ícones, logos, imagens, svg
    #==========================================================================#
    */

    private function getReadmeBase(): string
    {
        return <<<'MD'
# Template Base - MVC Simplificado

Estrutura MVC fundamental e direta para iniciantes no desenvolvimento web.

## 🏫 IPPLS
**Instituto Politécnico Privado Lucrêcio dos Santos**

Template desenvolvido para o curso de Gestão de Redes e Sistemas Informáticos.

## 📋 Requisitos

- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx
- Conhecimento básico de PHP

## 🚀 Instalação

### 1. Configurar Servidor Local

Coloque os arquivos na pasta do seu servidor web:
- **XAMPP**: `C:\xampp\htdocs\meu-projeto`
- **WAMP**: `C:\wamp64\www\meu-projeto`
- **MAMP**: `/Applications/MAMP/htdocs/meu-projeto`

### 2. Criar Banco de Dados
```sql
CREATE DATABASE meu_projeto_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE meu_projeto_base;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email) VALUES
('Pai Grande Ngola', 'paigrandengola@ippls.edu.ao'),
('Professor Lengo Júnior', 'lengojunior@ippls.edu.ao'),
('Eng. Vanilson Manuel', 'vanilsonmanuel@ippls.edu.ao');
```

### 3. Configurar Conexão

Edite `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'meu_projeto_base');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. Acessar Aplicação
```
http://localhost/meu-projeto
```

## 📁 Estrutura do Projeto
```
projeto_base/
├── index.php                    # Ponto de entrada e roteamento centralizado
├── favicon.ico                  # Ícone do site
├── config/
│   └── database.php            # Configuração do banco de dados
├── models/
│   └── User.php                # Model com CRUD completo
├── views/
│   └── pages/                  # 📁 Diretório para suas páginas
│       └── home.php            # Página inicial com CRUD funcional
├── controllers/
│   └── HomeController.php      # Controller com ações CRUD e mensagens flash
└── assets/
    ├── css/
    │   └── style.css           # Estilos com cores IPPLS
    ├── js/
    │   └── main.js             # Scripts JavaScript
    └── images/
        └── logo/
            └── ippls-logo-removebg-preview.png
```

## 🎯 Conceitos Aprendidos

- **Model**: Gerencia os dados e a lógica de negócio (CRUD completo)
- **View**: Responsável pela apresentação (HTML + PHP)
- **Controller**: Intermediário entre Model e View (processa requisições)
- **Roteamento**: O `index.php` gerencia todas as rotas da aplicação
- **Sessões**: Sistema de mensagens flash persistentes entre requisições

## 🔄 Fluxo de Requisição
```
Usuário acessa URL
    ↓
index.php (roteamento)
    ↓
HomeController (lógica + sessões)
    ↓
User Model (dados)
    ↓
home.php (apresentação + limpeza de mensagens)
```

## ✨ Funcionalidades Incluídas

Este template já vem com um **CRUD completo de usuários** funcionando:
- ✅ **Create** - Criar novos usuários
- ✅ **Read** - Listar todos os usuários
- ✅ **Update** - Editar usuários existentes
- ✅ **Delete** - Deletar usuários
- ✅ **Validação** de formulários com feedback
- ✅ **Mensagens flash** persistentes com sessões
- ✅ **Redirecionamento** PRG (Post-Redirect-Get)
- ✅ Interface responsiva
- ✅ Logo IPPLS incluído

## 💬 Sistema de Mensagens Flash

O template inclui um sistema robusto de mensagens que persiste entre redirecionamentos usando **sessões do PHP**.

### Como Funciona

```php
// 1. Controller armazena a mensagem na sessão
$this->setMessage('Usuário criado com sucesso!', 'success');
header('Location: ?');
exit;

// 2. View verifica se existe mensagem
<?php if (isset($controller) && $controller->hasMessage()): ?>
    <div class="alert alert-<?= $controller->getMessageType() ?>">
        <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
        <span><?= htmlspecialchars($controller->getMessage()) ?></span>
    </div>
    <?php $controller->clearMessage(); // Limpa após exibir ?>
<?php endif; ?>
```

### Métodos Disponíveis

```php
// Armazenar mensagem (privado - apenas dentro do controller)
$this->setMessage('Texto da mensagem', 'success'); // ou 'error'

// Verificar se existe mensagem
$controller->hasMessage(); // true/false

// Recuperar mensagem (não limpa)
$controller->getMessage(); // string

// Recuperar tipo (não limpa)
$controller->getMessageType(); // 'success' ou 'error'

// Limpar mensagem da sessão
$controller->clearMessage(); // void
```

## 🎨 Cores do IPPLS

O template usa as cores oficiais do IPPLS definidas no CSS:

```css
/* Cores Principais */
--ippls-blue-dark: #07183b;      /* Azul Escuro Principal */
--ippls-blue-medium: #4A8FC4;    /* Azul Médio */
--ippls-red: #C1272D;            /* Vermelho IPPLS */
--ippls-gold: #F4B41A;           /* Dourado Principal */
--ippls-gold-dark: #D69E0E;      /* Dourado Escuro (sombras) */

/* Escala de Cinzas */
--gray-900: #0c2248;             /* Fundo escuro */
--gray-800: #1a2f52;             /* Cards e headers */
--gray-700: #2d4464;             /* Bordas */
--gray-400: #a0a0a0;             /* Texto secundário */
--gray-50: #f9f9f9;              /* Texto claro */
```

Use essas variáveis CSS para manter a identidade visual consistente!

## 📝 Como Criar Novas Funcionalidades

### 1. Criar um Novo Model

Crie um arquivo em `models/` (ex: `Product.php`):
```php
<?php
// models/Product.php

class Product {
    private $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // CREATE
    public function create($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, price) VALUES (?, ?)"
        );
        return $stmt->execute([
            htmlspecialchars($data['name']),
            floatval($data['price'])
        ]);
    }

    // READ - Todos
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ - Por ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE products SET name = ?, price = ? WHERE id = ?"
        );
        return $stmt->execute([
            htmlspecialchars($data['name']),
            floatval($data['price']),
            $id
        ]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

### 2. Criar um Novo Controller com Sistema de Mensagens

Crie um arquivo em `controllers/` (ex: `ProductController.php`):
```php
<?php
// controllers/ProductController.php

require_once 'models/Product.php';

class ProductController {
    private $productModel;

    public function __construct() {
        // ✅ Iniciar sessão
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->productModel = new Product();
    }

    public function index() {
        $products = $this->productModel->getAll();
        $controller = $this;
        require __DIR__ . '/../views/pages/products.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);

            if (empty($name) || $price <= 0) {
                $this->setMessage('Preencha todos os campos corretamente.', 'error');
            } else {
                if ($this->productModel->create(['name' => $name, 'price' => $price])) {
                    // ✅ Mensagem armazenada na sessão
                    $this->setMessage('Produto criado com sucesso!', 'success');
                    // ✅ Redireciona (PRG pattern)
                    header('Location: ?page=products');
                    exit;
                } else {
                    $this->setMessage('Erro ao criar produto.', 'error');
                }
            }
        }
        $this->index();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);

            if (empty($name) || $price <= 0) {
                $this->setMessage('Preencha todos os campos corretamente.', 'error');
            } else {
                if ($this->productModel->update($id, ['name' => $name, 'price' => $price])) {
                    $this->setMessage('Produto atualizado com sucesso!', 'success');
                    header('Location: ?page=products');
                    exit;
                } else {
                    $this->setMessage('Erro ao atualizar produto.', 'error');
                }
            }
        }
        $this->index();
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            if ($id > 0 && $this->productModel->delete($id)) {
                $this->setMessage('Produto deletado com sucesso!', 'success');
                header('Location: ?page=products');
                exit;
            } else {
                $this->setMessage('Erro ao deletar produto.', 'error');
            }
        }
        $this->index();
    }

    // ✅ SISTEMA DE MENSAGENS FLASH COM SESSÕES

    private function setMessage($message, $type) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    public function hasMessage() {
        return isset($_SESSION['flash_message']);
    }

    public function getMessage() {
        return $_SESSION['flash_message'] ?? '';
    }

    public function getMessageType() {
        return $_SESSION['flash_type'] ?? '';
    }

    public function clearMessage() {
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }

    // Outros métodos auxiliares
    public function getProductById($id) {
        return $this->productModel->getById($id);
    }
}
```

### 3. Criar uma Nova View com Mensagens Flash

Crie um arquivo em `views/pages/` (ex: `products.php`):
```php
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - IPPLS</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- ✅ Header Específico de Produtos (Versão Simplificada) -->
    <header class="page-header">
        <div class="page-header-content">
            <img src="assets/images/logo/ippls-logo-removebg-preview.png"
                 alt="IPPLS"
                 class="page-header-logo">
            <div class="page-header-text">
                <h1>Gestão de Produtos</h1>
                <p>IPPLS - Template Base MVC</p>
            </div>
        </div>
    </header>

    <!-- ✅ Container Principal para Conteúdo -->
    <div class="main-container">
        <!-- Sistema de Mensagens Flash -->
        <?php if (isset($controller) && $controller->hasMessage()): ?>
            <div class="alert alert-<?= $controller->getMessageType() ?>">
                <span><?= $controller->getMessageType() === 'success' ? '✓' : '⚠' ?></span>
                <span><?= htmlspecialchars($controller->getMessage()) ?></span>
            </div>
            <?php $controller->clearMessage(); ?>
        <?php endif; ?>

        <!-- Formulário de Criação/Edição -->
        <div class="card" id="form">
            <div class="card-header">
                <h2><?= isset($_GET['edit']) ? '✏️ Editar Produto' : '➕ Criar Produto' ?></h2>
            </div>
            <div class="card-body">
                <?php
                $editProduct = null;
                if (isset($_GET['edit']) && isset($controller)) {
                    $editProduct = $controller->getProductById(intval($_GET['edit']));
                }
                ?>
                <form method="POST" action="?page=products&action=<?= $editProduct ? 'update' : 'create' ?>">
                    <?php if ($editProduct): ?>
                        <input type="hidden" name="id" value="<?= $editProduct['id'] ?>">
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="name">Nome *</label>
                            <input type="text" id="name" name="name"
                                   class="form-input"
                                   value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>"
                                   placeholder="Digite o nome do produto"
                                   required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="price">Preço *</label>
                            <input type="number" id="price" name="price"
                                   class="form-input"
                                   value="<?= $editProduct['price'] ?? '' ?>"
                                   placeholder="0.00"
                                   step="0.01" required>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <?= $editProduct ? 'ATUALIZAR' : 'CRIAR' ?>
                        </button>
                        <?php if ($editProduct): ?>
                            <a href="?page=products" class="btn btn-secondary">CANCELAR</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Produtos Cadastrados (<?= count($products ?? []) ?>)</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($products)): ?>
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><strong>#<?= $product['id'] ?></strong></td>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                        <td><?= number_format($product['price'], 2, ',', '.') ?> Kz</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="?page=products&edit=<?= $product['id'] ?>#form"
                                                   class="btn btn-sm btn-edit">EDITAR</a>
                                                <form method="POST"
                                                      action="?page=products&action=delete"
                                                      class="inline-form"
                                                      onsubmit="return confirm('Confirma a exclusão de <?= htmlspecialchars($product['name']) ?>?');">
                                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                                    <button type="submit" class="btn btn-sm btn-delete">
                                                        DELETAR
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <h3>Nenhum Produto</h3>
                        <p>Crie o primeiro produto usando o formulário acima.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS" class="footer-logo">
                <p class="footer-desc">Arquitetura base para desenvolver seus projetos.</p>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Links Rápidos</h3>
                <ul class="footer-links">
                    <li><a href="#form">Começar</a></li>
                    <li><a href="README.md">Documentação</a></li>
                    <li><a href="?">Usuários</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3 class="footer-heading">Tecnologias</h3>
                <ul class="footer-links">
                    <li>PHP • MySQL</li>
                    <li>HTML5 • CSS3</li>
                    <li>JavaScript • Git</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>Desenvolvido com ❤️ para o <strong>IPPLS</strong></p>
            <p class="footer-version">Template Base MVC • v1.0.0 • 2025</p>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
```

### 4. Adicionar css para o cabeçálio desta nova view
 Inserir antes dos estilos do footer (Rodapé):



```css
/* ============================================
   14. HEADER DE PÁGINAS INTERNAS
   ============================================ */

/* Header Simplificado para Páginas Internas */
.page-header {
    background: var(--gray-900);
    color: white;
    padding: 2rem 1rem;
    text-align: center;
    border-bottom: 3px solid var(--ippls-gold);
    margin-bottom: 0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

@media (min-width: 768px) {
    .page-header {
        padding: 3rem 1.5rem;
    }
}

.page-header-content {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
}

@media (min-width: 768px) {
    .page-header-content {
        flex-direction: row;
        justify-content: space-between;
        text-align: left;
    }
}

/* Logo do Header de Página */
.page-header-logo {
    height: 60px;
    width: auto;
    filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
    transition: transform 0.3s ease;
}

@media (min-width: 768px) {
    .page-header-logo {
        height: 80px;
    }
}

.page-header-logo:hover {
    transform: scale(1.05);
}

/* Texto do Header de Página */
.page-header-text h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

@media (min-width: 768px) {
    .page-header-text h1 {
        font-size: 2.25rem;
    }
}

.page-header-text p {
    margin: 0.5rem 0 0 0;
    font-size: 0.875rem;
    color: var(--gray-400);
}

@media (min-width: 768px) {
    .page-header-text p {
        font-size: 1rem;
    }
}
```



### 5. Adicionar Rota no index.php

Edite `index.php` e adicione suporte para múltiplas páginas:
```php
<?php
// index.php - Ponto de entrada e roteamento global

require_once 'config/database.php';

// Captura página e ação da URL
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Roteamento por página
switch ($page) {
    case 'home':
        require_once 'controllers/HomeController.php';
        $controller = new HomeController();
        break;

    case 'products':  // ✅ Nova rota
        require_once 'controllers/ProductController.php';
        $controller = new ProductController();
        break;

    default:
        http_response_code(404);
        echo "<!DOCTYPE html><html><head><title>404</title></head>";
        echo "<body style='font-family: Arial; text-align: center; padding: 50px;'>";
        echo "<h1 style='color: #C1272D;'>404 - Página não encontrada</h1>";
        echo "<a href='?' style='color: #4A8FC4;'>Voltar para Home</a>";
        echo "</body></html>";
        exit;
}

// Executar ação no controller
switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
```

Acesse:
- **Home**: `http://localhost/meu-projeto`
- **Produtos**: `http://localhost/meu-projeto?page=products`

## 📚 Próximos Passos

1. ✅ CRUD completo com mensagens flash funcionando
2. 🔄 Adicionar mais modelos (Product, Category, etc.)
3. 🔄 Implementar sistema de autenticação
4. 🔄 Adicionar validações mais robustas
5. 🔄 Implementar upload de arquivos
6. 🔄 Adicionar paginação nas listagens

## 💡 Dicas

### Segurança
- **Sempre use** `htmlspecialchars()` para prevenir XSS
- **Sempre use** prepared statements para prevenir SQL Injection
- **Inicie sessões** no construtor do controller
- **Valide e sanitize** todos os dados de entrada

### Organização
- **Organize** suas views em `views/pages/`
- **Mantenha** a estrutura MVC (Model → Controller → View)
- **Use** as variáveis CSS do IPPLS para manter consistência visual
- **Comente** seu código para facilitar manutenção

### Mensagens Flash
- **Armazene** mensagens na sessão antes de redirecionar
- **Verifique** com `hasMessage()` antes de exibir
- **Limpe** as mensagens com `clearMessage()` após exibição
- **Redirecione** após POST para evitar reenvio de formulário (PRG pattern)

### Padrão PRG (Post-Redirect-Get)
```php
// ✅ Correto: Redirecionar após POST
if ($this->model->create($data)) {
    $this->setMessage('Criado com sucesso!', 'success');
    header('Location: ?page=sua-pagina');
    exit;
}

// ❌ Errado: Não redirecionar após POST
if ($this->model->create($data)) {
    $this->message = 'Criado!'; // Mensagem perdida no refresh
}
$this->index();
```

## ⚠️ Importante

Este template usa **roteamento centralizado** no `index.php`:
- O `index.php` gerencia TODAS as rotas
- Os controllers NÃO têm roteamento interno
- Cada método do controller é uma ação específica
- Use `header('Location: ?page=nome')` após operações POST
- **Sempre inicie sessões** no construtor do controller
- **Sempre limpe mensagens** após exibição na view
- **Use `require`** ao invés de `return` para carregar views

## 🐛 Solução de Problemas

### Mensagens não aparecem
```php
// ✅ Certifique-se de:
// 1. Iniciar sessão no controller
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Verificar existência antes de exibir
if (isset($controller) && $controller->hasMessage()) {
    // exibir mensagem
}

// 3. Limpar após exibição
$controller->clearMessage();
```

### Páginas não aparecem
```php
// ✅ Use require ao invés de return
public function index() {
    $data = $this->model->getAll();
    $controller = $this;
    require __DIR__ . '/../views/pages/suapagina.php'; // ✅
    // return __DIR__ . '/../views/pages/suapagina.php'; // ❌
}
```

### Edição não funciona
```php
// ✅ Verifique se o formulário tem:
// 1. Campo hidden com ID
<input type="hidden" name="id" value="<?= $produto['id'] ?>">

// 2. Action correto
<form method="POST" action="?page=products&action=update">

// 3. Botão de cancelar para voltar
<a href="?page=products" class="btn btn-secondary">CANCELAR</a>
```

---

**Desenvolvido com ❤️ para estudantes do IPPLS**

**Template Base MVC - Aprenda criando!**
MD;
    }


    private function getInstrucoesBase(): string
    {
        return "# Guia de Instalação - Template Base\n\n## 1. Baixar o Template\n## 2. Extrair Arquivos\n## 3. Criar Banco de Dados\n## 4. Configurar Conexão\n## 5. Acessar no Navegador";
    }

    // ==========================================
    // TEMPLATE PADRÃO - NOVOS MÉTODOS
    // ==========================================

    private function getIndexPadrao(): string
    {
        return <<<'PHP'
<?php
/**
 * Template Padrão - MVC Profissional com Composer
 * IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos
 *
 * ORDEM DE CARREGAMENTO CRÍTICA:
 * 1. Composer Autoload
 * 2. Configurações (app.php)
 * 3. Database (com função helper db())
 * 4. Sessão
 * 5. Rotas (que usam Controllers que usam Models que usam db())
 */

// ============================================
// 1. AUTOLOADER DO COMPOSER (PSR-4)
// ============================================
require_once __DIR__ . '/vendor/autoload.php';

// ============================================
// 2. CONFIGURAÇÕES DA APLICAÇÃO
// ============================================
require_once __DIR__ . '/app/config/app.php';

// ============================================
// 2.1. CONSTANTES GLOBAIS ⭐ DEVE VIR ANTES
// ============================================
require_once __DIR__ . '/app/config/constants.php';

// ============================================
// 3. DATABASE (CRÍTICO: Deve carregar ANTES das rotas)
// ============================================
require_once CONFIG_PATH . '/database.php';

// ============================================
// 4. HELPERS (função db() global) ⭐ CRÍTICO
// ============================================
require_once CONFIG_PATH . '/helpers.php';

// ============================================
// 5. INICIAR SESSÃO
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================
// 6. SISTEMA DE ROTAS (Agora db() está disponível)
// ============================================
require_once ROUTES_PATH . '/web.php';
PHP;
    }

    private function getComposerJsonPadrao(): string
    {
        return <<<'JSON'
{
    "name": "ippls/template-padrao",
    "description": "Template Padrão MVC com Composer - IPPLS",
    "type": "project",
    "license": "MIT",
    "require": {
        "php": ">=8.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "config": {
        "optimize-autoloader": true
    }
}
JSON;
    }

    private function getHtaccessPadrao(): string
    {
        return <<<'HTACCESS'
# Template Padrão IPPLS - Configuração Apache
# URLs Amigáveis e Segurança

# Habilitar RewriteEngine
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /projeto_padrao/

    # Permitir acesso direto a arquivos e diretórios existentes
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # Redirecionar outras requisições para index.php
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

# Segurança - Ocultar listagem de diretórios
Options -Indexes

# Proteção de arquivos sensíveis
<FilesMatch "^(composer\.(json|lock)|\.env|\.gitignore)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Configurações de PHP (se permitido)
<IfModule mod_php.c>
    php_flag display_errors On
    php_value upload_max_filesize 10M
    php_value post_max_size 10M
</IfModule>

# Compressão GZIP
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>

# Cache de arquivos estáticos
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
HTACCESS;
    }

    private function getWebRoutesPadrao(): string
    {
        return <<<'PHP'
<?php
/**
 * Rotas Web - Template Padrão IPPLS
 * Sistema de roteamento centralizado com tratamento de erros
 */

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

// ===============================
// CAPTURA DA URL
// ===============================
// page = páginas normais
// action = ações de CRUD
$page   = $_GET['page']   ?? null;
$action = $_GET['action'] ?? null;

try {

    // ===============================
    // 1. ROTAS DE PÁGINAS
    // ===============================
    if ($page) {

        switch ($page) {
            case 'home':
                $controller = new HomeController();
                return $controller->index();

            case 'users':
                $controller = new UserController();
                return $controller->index();

            case 'docs':
                $controller = new HomeController();
                return $controller->docs();
                exit;

            default:
                http_response_code(404);
                require ERRORS_PATH . '/404.php';
                exit;
        }
    }

    // ===============================
    // 2. ROTAS DE AÇÕES (CRUD)
    // ===============================
    if ($action) {

        switch ($action) {
            case 'index':
                $controller = new UserController();
                return $controller->index();

            case 'create':
                $controller = new UserController();
                return $controller->create();

            case 'update':
                $controller = new UserController();
                return $controller->update();

            case 'delete':
                $controller = new UserController();
                return $controller->delete();

            default:
                http_response_code(404);
                require ERRORS_PATH . '/404.php';
                exit;
        }
    }

    // ===============================
    // 3. SE NADA FOI DEFINIDO → HOME
    // ===============================
    $controller = new HomeController();
    return $controller->index();


} catch (\Exception $e) {

    // ===============================
    // TRATAMENTO DE ERROS 500
    // ===============================
    error_log("ERRO NO SISTEMA: " . $e->getMessage());
    error_log("ARQUIVO: " . $e->getFile());
    error_log("LINHA: " . $e->getLine());

    http_response_code(500);

    if (APP_ENV === 'development') {
        echo "<h1>Erro 500 - Desenvolvimento</h1>";
        echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        require ERRORS_PATH . '/500.php';
    }
}
PHP;
    }

    private function getDatabaseConfigPadrao(): string
    {
        return <<<'PHP'
<?php
/**
 * Configuração de Banco de Dados - Template Padrão
 */

namespace App\Config;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $name = getenv('DB_NAME') ?: 'projeto_padrao';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';

        try {
            $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";
            $this->pdo = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (\PDOException $e) {
            error_log("Erro na conexão com banco de dados: " . $e->getMessage());
            throw new \Exception("Falha ao conectar ao banco de dados. Contate o administrador.");
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}
PHP;
    }

    private function getAppConfig(): string
    {
        return <<<'PHP'
<?php
/**
 * Configuração da Aplicação
 */

define('APP_NAME', 'Projeto IPPLS');
define('APP_URL', 'http://localhost');
define('APP_ENV', 'development');

// Timezone
date_default_timezone_set('Africa/Luanda');

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
PHP;
    }

    private function getConstantsConfig(): string
    {
        return <<<'PHP'
<?php
/**
 * Constantes Globais - Template Padrão MVC
 * Define caminhos e configurações centralizadas
 */

// ============================================
// CAMINHOS BASE
// ============================================

define('BASE_PATH', dirname(__DIR__, 2));           // c:\xampp\htdocs\projeto_padrao
define('APP_PATH', BASE_PATH . '/app');              // c:\xampp\htdocs\projeto_padrao\app
define('VIEWS_PATH', BASE_PATH . '/views');          // c:\xampp\htdocs\projeto_padrao\views
define('ASSETS_PATH', BASE_PATH . '/assets');        // c:\xampp\htdocs\projeto_padrao\assets
define('CONFIG_PATH', APP_PATH . '/config');         // c:\xampp\htdocs\projeto_padrao\app\config
define('CONTROLLERS_PATH', APP_PATH . '/Http/Controllers');  // c:\xampp\htdocs\projeto_padrao\app/Http/Controllers
define('MODELS_PATH', APP_PATH . '/Models');         // c:\xampp\htdocs\projeto_padrao\app/Models
define('ROUTES_PATH', BASE_PATH . '/routes');        // c:\xampp\htdocs\projeto_padrao\routes
define('VENDOR_PATH', BASE_PATH . '/vendor');        // c:\xampp\htdocs\projeto_padrao\vendor

// ============================================
// CAMINHOS ESPECÍFICOS DE VIEWS
// ============================================

define('LAYOUTS_PATH', VIEWS_PATH . '/layouts');     // c:\xampp\htdocs\projeto_padrao\views\layouts
define('PAGES_PATH', VIEWS_PATH . '/pages');         // c:\xampp\htdocs\projeto_padrao\views\pages
define('COMPONENTS_PATH', VIEWS_PATH . '/components');  // c:\xampp\htdocs\projeto_padrao\views\components
define('ERRORS_PATH', VIEWS_PATH . '/errors');       // c:\xampp\htdocs\projeto_padrao\views\errors

// ============================================
// CAMINHOS DE ASSETS
// ============================================

define('CSS_PATH', ASSETS_PATH . '/css');            // c:\xampp\htdocs\projeto_padrao\assets\css
define('JS_PATH', ASSETS_PATH . '/js');              // c:\xampp\htdocs\projeto_padrao\assets\js
define('IMAGES_PATH', ASSETS_PATH . '/images');      // c:\xampp\htdocs\projeto_padrao\assets\images

// ============================================
// AMBIENTE E DEBUG
// ============================================

define('IS_DEVELOPMENT', APP_ENV === 'development');
define('IS_PRODUCTION', APP_ENV === 'production');
PHP;
    }

    private function getHelpersConfig(): string
    {
        return <<<'PHP'
<?php
use App\Config\Database;

if (!function_exists('db')) {
    function db(): PDO
    {
        return Database::getInstance()->getConnection();
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}

if (!function_exists('e')) {
    function e(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
PHP;
    }



    private function getUserModelPadrao(): string
    {
        return <<<'PHP'
<?php
namespace App\Models;

use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
        );
        return $stmt->execute([$data['name'], $data['email']]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );
        return $stmt->execute([$data['name'], $data['email'], $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
PHP;
    }

    private function getHomeControllerPadrao(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index(): void
    {
        // Título da página (view)
        $title = 'Template Padrão MVC - IPPLS';

        // Conteúdo da página (view)
        $content = PAGES_PATH . '/home.php';

        // Redireciona para a view do layout principal
        require LAYOUTS_PATH . '/main.php';
    }

    public function docs(): void
    {
        // Título da página de documentação (view)
        $title = 'Documentação do Template';

        // Conteúdo da página de documentação (view)
        $content = PAGES_PATH . '/docs.php';

        // Redireciona para a view do layout principal
        require LAYOUTS_PATH . '/main.php';
    }
}
PHP;
    }

    private function getUserControllerPadrao(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    private User $userModel;
    private array $message = [];

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Exibe lista de usuários
     */
    public function index(): void
    {
        $users = $this->userModel->all();
        $controller = $this; // Passa referência para a view
        // Título da página (view)
        $title = 'Kit Inicial - Gestão de Usuários';
        // Conteúdo da página (view)
        $content = PAGES_PATH . '/users.php';
        // Redireciona para a view do layout principal
        require LAYOUTS_PATH . '/main.php';
    }

    /**
     * Cria novo usuário
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        // Validações
        if (empty($name) || empty($email)) {
            $this->setMessage('error', 'Preencha todos os campos obrigatórios!');
            $this->redirect('index');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setMessage('error', 'Email inválido!');
            $this->redirect('index');
        }

        if ($this->userModel->emailExists($email)) {
            $this->setMessage('error', 'Email já cadastrado no sistema!');
            $this->redirect('index');
        }

        // Cria usuário
        if ($this->userModel->create(['name' => $name, 'email' => $email])) {
            $this->setMessage('success', '✅ Usuário criado com sucesso!');
        } else {
            $this->setMessage('error', '❌ Erro ao criar usuário. Tente novamente.');
        }

        $this->redirect('index');
    }

    /**
     * Atualiza usuário existente
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
        }

        $id = intval($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if ($id <= 0) {
            $this->setMessage('error', 'ID inválido!');
            $this->redirect('index');
        }

        if (empty($name) || empty($email)) {
            $this->setMessage('error', 'Preencha todos os campos!');
            $this->redirect('index', ['edit' => $id]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->setMessage('error', 'Email inválido!');
            $this->redirect('index', ['edit' => $id]);
        }

        if ($this->userModel->emailExists($email, $id)) {
            $this->setMessage('error', 'Email já cadastrado por outro usuário!');
            $this->redirect('index', ['edit' => $id]);
        }

        if ($this->userModel->update($id, ['name' => $name, 'email' => $email])) {
            $this->setMessage('success', '✅ Usuário atualizado com sucesso!');
        } else {
            $this->setMessage('error', '❌ Erro ao atualizar usuário.');
        }

        $this->redirect('index');
    }

    /**
     * Deleta usuário
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index');
        }

        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            $this->setMessage('error', 'ID inválido!');
            $this->redirect('index');
        }

        if ($this->userModel->delete($id)) {
            $this->setMessage('success', '✅ Usuário deletado com sucesso!');
        } else {
            $this->setMessage('error', '❌ Erro ao deletar usuário.');
        }

        $this->redirect('index');
    }

    /**
     * Obtém usuário por ID (para edição)
     */
    public function getUserById(int $id): ?array
    {
        return $this->userModel->find($id);
    }

    // ============================================
    // SISTEMA DE MENSAGENS FLASH
    // ============================================

    private function setMessage(string $type, string $message): void
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public function hasMessage(): bool
    {
        return isset($_SESSION['flash_message']);
    }

    public function getMessage(): string
    {
        return $_SESSION['flash_message']['message'] ?? '';
    }

    public function getMessageType(): string
    {
        return $_SESSION['flash_message']['type'] ?? 'info';
    }

    public function clearMessage(): void
    {
        unset($_SESSION['flash_message']);
    }

    // ============================================
    // HELPERS
    // ============================================

    private function redirect(string $action = 'index', array $params = []): void
    {
        $query = http_build_query(array_merge(['action' => $action], $params));
        header("Location: ?{$query}");
        exit;
    }
}
PHP;
    }

    private function getMainLayout(): string
    {
        return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'IPPLS Template' ?></title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <!-- Arquivo de importação dos Componentes CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Fonteawesome para icones -->
    <link rel="stylesheet" href="vendor/fontawesome/css/all.min.css">
</head>
<body>
    <!-- Barra de navegação (Menu) -->
    <?php require COMPONENTS_PATH . '/navbar.php'; ?>

    <!-- Conteúdo das páginas -->
    <?php require $content; ?>

    <!-- Rodapé -->
    <?php require COMPONENTS_PATH . '/footer.php'; ?>

    <!-- Script para Menu Mobile -->
    <script src="assets/js/components/navbar.js"></script>

    <!-- Scripts do Botão Voltar ao Topo ( O botão será criado automaticamente pelo JavaScript ) -->
    <script src="assets/js/components/backToTop.js"></script>

    <!-- Script Principal -->
    <script src="assets/js/main.js"></script>
</body>
</html>
HTML;
    }

    private function getHomeViewPadrao(): string
    {
        return <<<'HTML'
<!-- Página Inicial -->

<!-- Hero Section - Brutal Design with IPPLS Logo -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-grid">
            <!-- Left Section: Text Content -->
            <div class="hero-content">
                <!-- Welcome IPPLS -->
                <div class="welcome-container">
                    <span class="welcome-icon">👋</span>
                    <span class="welcome-text">Bem-vindo ao futuro do desenvolvimento no ITLS</span>
                </div>
                <h1 class="hero-title">
                    Template <span class="hero-title-highlight">MVC PADRÃO</span>
                </h1>
                <p class="hero-subtitle">
                    Arquitetura padrão para desenvolvimento profissional. Construa projetos com firmeza!
                </p>
                <div class="hero-buttons">
                    <a href="?page=home" class="btn-hero btn-hero-primary">
                        <i class="fas fa-rocket"></i> Começar Agora
                    </a>
                    <a href="?page=docs" class="btn-hero btn-hero-secondary">
                        <i class="fas fa-book"></i> Documentação
                    </a>
                </div>
            </div>
            <!-- Right Section: Visual Block -->
            <div class="hero-visual">
                <div class="decoration-block-top">
                    <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                </div>
                <div class="feature-card">
                    <h2 class="feature-card-title">Ousado. Forte. Real.</h2>
                    <p class="feature-card-subtitle">IPPLS - Instituto Politécnico</p>
                </div>
                <div class="decoration-block-bottom">
                    <img src="assets/images/logo/ippls-logo-removebg-preview.png" alt="IPPLS Logo" class="logo">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="skills-section">
    <h2 class="skills-title"><i class="fas fa-layer-group"></i> Requisitos Técnicos</h2>
    <div class="skills-grid">
        <a href="https://developer.mozilla.org/pt-BR/docs/Web/HTML" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/html5.svg" alt="HTML" class="skill-icon">
            <span class="skill-name">HTML5</span>
        </a>
        <a href="https://developer.mozilla.org/pt-BR/docs/Web/CSS" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/css3.svg" alt="CSS" class="skill-icon">
            <span class="skill-name">CSS3</span>
        </a>
        <a href="https://developer.mozilla.org/pt-BR/docs/Web/JavaScript" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/javascript.svg" alt="JavaScript" class="skill-icon">
            <span class="skill-name">JavaScript</span>
        </a>
        <a href="https://www.php.net/manual/pt_BR/" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/php.svg" alt="PHP" class="skill-icon">
            <span class="skill-name">PHP</span>
        </a>
        <a href="https://dev.mysql.com/doc/" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/mysql.svg" alt="MySQL" class="skill-icon">
            <span class="skill-name">MySQL</span>
        </a>
        <a href="https://httpd.apache.org/docs/" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/apache.svg" alt="Apache" class="skill-icon">
            <span class="skill-name">Apache</span>
        </a>
        <a href="https://www.apachefriends.org/" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/xampp.svg" alt="XAMPP" class="skill-icon">
            <span class="skill-name">XAMPP</span>
        </a>
        <a href="https://git-scm.com/doc" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/git.svg" alt="Git" class="skill-icon">
            <span class="skill-name">Git</span>
        </a>
        <a href="https://getcomposer.org/doc/" target="_blank" rel="noopener noreferrer" class="skill-card">
            <img src="assets/images/skills/composer.svg" alt="Composer" class="skill-icon">
            <span class="skill-name">Composer</span>
        </a>
    </div>
</section>
HTML;
    }

    private function getUsersViewPadrao(): string
    {
        return <<<'HTML'
<?php
    $title;
?>
<!-- Main Container -->
<div class="main-container">
    <!-- Alert Messages -->
    <?php if (isset($controller) && $controller->hasMessage()): ?>
        <div class="alert alert-<?= $controller->getMessageType() ?>">
            <span><?= $controller->getMessageType() === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-triangle"></i>' ?></span>
            <span><?= htmlspecialchars($controller->getMessage()) ?></span>
        </div>
        <?php $controller->clearMessage(); ?>
    <?php endif; ?>

    <h1 class="hero-title">
        CRUD - <span class="hero-title-highlight">CREATE</span> READ <span class="hero-title-highlight">UPDATE</span> DELETE
    </h1><br>

    <!-- Create/Edit User Card -->
    <div class="card" id="form">
        <div class="card-header">
            <h2><?= isset($_GET['edit']) ? '<i class="fas fa-user-edit"></i> Editar Usuário' : '<i class="fas fa-user-plus"></i> Criar Usuário' ?></h2>
        </div>
        <div class="card-body">
            <?php
            $editUser = null;
            if (isset($_GET['edit']) && isset($controller)) {
                $editUser = $controller->getUserById(intval($_GET['edit']));
            }
            ?>
            <form method="POST" action="?action=<?= $editUser ? 'update' : 'create' ?>">
                <?php if ($editUser): ?>
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="name"><i class="fas fa-user"></i> Nome Completo *</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input"
                            value="<?= htmlspecialchars($editUser['name'] ?? '') ?>"
                            placeholder="Digite o nome"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email *</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            value="<?= htmlspecialchars($editUser['email'] ?? '') ?>"
                            placeholder="exemplo@ippls.edu.ao"
                            required
                        >
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas <?= $editUser ? 'fa-save' : 'fa-plus-circle' ?>"></i>
                        <?= $editUser ? 'ATUALIZAR' : 'CRIAR' ?>
                    </button>
                    <?php if ($editUser): ?>
                        <a href="?page=users" class="btn btn-secondary"><i class="fas fa-times"></i> CANCELAR</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Users List Card -->
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-list"></i> Usuários Cadastrados (<?= count($users ?? []) ?>)</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag"></i> ID</th>
                                <th><i class="fas fa-user"></i> Nome</th>
                                <th><i class="fas fa-envelope"></i> Email</th>
                                <th><i class="fas fa-calendar"></i> Data</th>
                                <th><i class="fas fa-cog"></i> Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><strong>#<?= $user['id'] ?></strong></td>
                                    <td><?= htmlspecialchars($user['name']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="?page=users&edit=<?= $user['id'] ?>" class="btn btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> EDITAR
                                            </a>
                                            <form method="POST" action="?action=delete" class="inline-form"
                                                    onsubmit="return confirm('⚠️ Tem certeza que deseja excluir este usuário?');">
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i> DELETAR
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-inbox fa-4x"></i></div>
                    <h3>Nenhum Usuário</h3>
                    <p>Crie o primeiro usuário usando o formulário acima.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
HTML;
    }

    private function getDocsViewsPadrao(): string{
        return <<<'PHP'
<?php
/**
 * Página de Documentação - Template Padrão IPPLS
 * Design moderno e totalmente responsivo
 */

// Caminho para o README.md
$readmePath = __DIR__ . '/../../README.md';
$readmeExists = file_exists($readmePath);

// Processa o README se existir
if ($readmeExists) {
    $readmeContent = file_get_contents($readmePath);
    $html = convertMarkdownToHtml($readmeContent);
    list($html, $navigation) = generateNavigationAndIds($html);
    $html = sanitizeHtml($html);
    // Substitui emojis por ícones Font Awesome apenas na renderização
    if (!function_exists('replaceEmojisWithFA')) {
        // função definida mais abaixo
    }
    $html = replaceEmojisWithFA($html);
}

/**
 * Converte Markdown para HTML
 */
function convertMarkdownToHtml($text) {
    $text = str_replace(["\r\n", "\r"], "\n", $text);

    // Blocos de código
    $text = preg_replace_callback('/```(\w+)?\n(.*?)\n```/s', function($m) {
        $lang = $m[1] ?? 'plaintext';
        $code = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
        return '<pre><code class="language-' . $lang . '">' . $code . '</code></pre>';
    }, $text);

    // Headings
    for ($i = 6; $i >= 1; $i--) {
        $text = preg_replace('/^' . str_repeat('#', $i) . '\s+(.+)$/m', '<h' . $i . '>$1</h' . $i . '>', $text);
    }

    // Badges
    $text = preg_replace('/!\[([^\]]*)\]\((https:\/\/img\.shields\.io[^\)]+)\)/', '<img src="$2" alt="$1" class="badge-img">', $text);

    // Imagens
    $text = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1" class="content-img">', $text);

    // Links
    $text = preg_replace_callback('/\[([^\]]+)\]\(([^\)]+)\)/', function($m) {
        $text = $m[1];
        $url = trim($m[2]);
        $isExternal = strpos($url, 'http') === 0;
        $target = $isExternal ? ' target="_blank" rel="noopener"' : '';
        return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '"' . $target . '>' . $text . '</a>';
    }, $text);

    // Linha horizontal
    $text = preg_replace('/^-{3,}\s*$/m', '<hr class="docs-divider">', $text);

    // Bold e Italic
    $text = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $text);

    // Inline code
    $text = preg_replace('/`([^`]+)`/', '<code class="inline-code">$1</code>', $text);

    // Task lists
    $text = preg_replace('/^\s*-\s+\[x\]\s+(.+)$/m', '<li class="task-item checked"><i class="fas fa-check-square"></i> $1</li>', $text);
    $text = preg_replace('/^\s*-\s+\[\s\]\s+(.+)$/m', '<li class="task-item"><i class="far fa-square"></i> $1</li>', $text);

    // Listas
    $text = preg_replace('/^\s*[-\*]\s+(.+)$/m', '<li>$1</li>', $text);
    $text = preg_replace_callback('/((?:<li(?:\s+class="[^"]*")?>.*?<\/li>\s*)+)/s', function($m) {
        if (strpos($m[0], 'task-item') !== false) {
            return '<ul class="task-list">' . $m[0] . '</ul>';
        }
        return '<ul>' . $m[0] . '</ul>';
    }, $text);

    // Tabelas
    $text = preg_replace_callback('/(\|.+\|[\r\n]+)+/s', function($m) {
        $table = trim($m[0]);
        $rows = array_filter(explode("\n", $table));

        if (count($rows) < 2) return $m[0];

        $html = '<div class="table-container"><table class="docs-table">';
        $isHeader = true;

        foreach ($rows as $i => $row) {
            if ($i === 1 && preg_match('/^\|[\s:-]+\|/', $row)) continue;

            $cells = array_map('trim', explode('|', trim($row, '|')));
            $tag = $isHeader ? 'th' : 'td';

            $html .= '<tr>';
            foreach ($cells as $cell) {
                $html .= "<$tag>" . trim($cell) . "</$tag>";
            }
            $html .= '</tr>';

            if ($isHeader) $isHeader = false;
        }

        $html .= '</table></div>';
        return $html;
    }, $text);

    // Blockquotes
    $text = preg_replace('/^>\s+(.+)$/m', '<blockquote class="docs-quote">$1</blockquote>', $text);

    // Parágrafos
    $blocks = preg_split('/\n\s*\n/', trim($text));
    $result = [];
    foreach ($blocks as $block) {
        $block = trim($block);
        if (preg_match('/^<(h[1-6]|ul|ol|pre|blockquote|hr|table|div)/i', $block)) {
            $result[] = $block;
        } else if (!empty($block)) {
            $result[] = '<p>' . $block . '</p>';
        }
    }

    return implode("\n\n", $result);
}

/**
 * Gera navegação e adiciona IDs
 */
function generateNavigationAndIds($html) {
    $navigation = [];

    if (preg_match_all('/<h([1-3])>(.*?)<\/h\1>/i', $html, $matches, PREG_SET_ORDER)) {
        $ids = [];

        foreach ($matches as $m) {
            $level = (int)$m[1];
            $text = strip_tags($m[2]);
            $id = slugify($text);

            $originalId = $id;
            $counter = 1;
            while (in_array($id, $ids)) {
                $id = $originalId . '-' . $counter++;
            }
            $ids[] = $id;

            $navigation[] = [
                'id' => $id,
                'text' => $text,
                'level' => $level
            ];

            $html = preg_replace(
                '/<h' . $level . '>' . preg_quote($m[2], '/') . '<\/h' . $level . '>/i',
                '<h' . $level . ' id="' . $id . '">' . $m[2] . '</h' . $level . '>',
                $html,
                1
            );
        }
    }

    return [$html, $navigation];
}

function slugify($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-') ?: 'section';
}

function sanitizeHtml($html) {
    $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/', '', $html);
    $html = preg_replace('/(href|src)\s*=\s*["\']javascript:[^"\']*["\']/', '$1="#"', $html);
    return $html;
}

/**
 * Mapeamento de emojis para classes do Font Awesome
 */
function emojiToFaClassMap(): array {
    return [
        '📚' => 'fa-book-open',
        '📖' => 'fa-book',
        '🚀' => 'fa-rocket',
        '🔍' => 'fa-search',
        '🔎' => 'fa-search',
        '🐛' => 'fa-bug',
        '🏗️' => 'fa-project-diagram',
        '✅' => 'fa-check-circle',
        '⚠️' => 'fa-exclamation-triangle',
        '📁' => 'fa-folder',
        '✨' => 'fa-star',
        '💡' => 'fa-lightbulb',
    ];
}

/**
 * Substitui emojis por elementos <i class="fas fa-..."> apenas em text nodes
 * Ignora nodes dentro de <code>, <pre>, <a>, <img>, <script>, <style>, <textarea>
 */
function replaceEmojisWithFA(string $html): string {
    $map = emojiToFaClassMap();
    if (empty($map) || trim($html) === '') return $html;

    libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'UTF-8');
    // wrapper para trabalhar com fragmento
    $ok = $dom->loadHTML('<?xml encoding="utf-8" ?><div id="__root__">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    if (!$ok) return $html;

    $xpath = new DOMXPath($dom);
    $nodes = $xpath->query('//text()[not(ancestor::code) and not(ancestor::pre) and not(ancestor::a) and not(ancestor::img) and not(ancestor::script) and not(ancestor::style) and not(ancestor::textarea)]');

    foreach ($nodes as $textNode) {
        $text = $textNode->nodeValue;
        if ($text === null || $text === '') continue;

        // verificar presença de qualquer emoji do mapa
        $found = false;
        foreach ($map as $emoji => $_) {
            if (mb_strpos($text, $emoji) !== false) { $found = true; break; }
        }
        if (!$found) continue;

        $parent = $textNode->parentNode;

        // reconstruir: dividir por cada emoji encontrado (iterativo)
        $working = $text;
        // iremos processar a cada emoji do mapa substituindo por sequência de nós
        // para evitar múltiplos passes complexos, faremos uma varredura por emoji usando explode
        $fragmentParts = [$working];
        foreach ($map as $emoji => $faClass) {
            $newParts = [];
            foreach ($fragmentParts as $part) {
                if (strpos($part, $emoji) === false) {
                    $newParts[] = $part;
                    continue;
                }
                $pieces = explode($emoji, $part);
                $count = count($pieces);
                for ($i = 0; $i < $count; $i++) {
                    $newParts[] = $pieces[$i];
                    if ($i !== $count - 1) {
                        // marker para emoji
                        $newParts[] = $emoji; // vamos usar o emoji literal como placeholder
                    }
                }
            }
            $fragmentParts = $newParts;
        }

        // inserir nós antes do textNode
        foreach ($fragmentParts as $part) {
            if ($part === '') continue;
            if (array_key_exists($part, $map)) {
                $i = $dom->createElement('i');
                $i->setAttribute('class', 'fas ' . $map[$part]);
                $i->setAttribute('aria-hidden', 'true');
                $parent->insertBefore($i, $textNode);
            } else {
                $parent->insertBefore($dom->createTextNode($part), $textNode);
            }
        }

        // remover o text node original
        $parent->removeChild($textNode);
    }

    // recuperar innerHTML do wrapper
    $root = $dom->getElementById('__root__');
    if (!$root) return $html;

    $inner = '';
    foreach ($root->childNodes as $n) {
        $inner .= $dom->saveHTML($n);
    }

    return $inner;
}
?>

<!-- Container Principal -->
<div class="docs-wrapper">

    <!-- Sidebar -->
    <aside class="docs-sidebar" id="docsSidebar">
        <div class="docs-sidebar-header">
            <h3><i class="fas fa-book-open"></i> Navegação</h3>
            <button class="docs-sidebar-close" id="sidebarClose" aria-label="Fechar menu">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="docs-sidebar-search">
            <i class="fas fa-search"></i>
            <input type="text" id="docsSearch" placeholder="Pesquisar..." autocomplete="off">
        </div>

        <nav class="docs-sidebar-nav" id="sidebarNav">
            <?php if ($readmeExists && !empty($navigation)): ?>
                <?php foreach ($navigation as $item): ?>
                    <a href="#<?= $item['id'] ?>"
                       class="docs-nav-item docs-nav-level-<?= $item['level'] ?>"
                       data-section="<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['text'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>

        <div class="docs-sidebar-footer">
            <a href="https://github.com/ippls/template-padrao" target="_blank" class="docs-github-link">
                <i class="fab fa-github"></i> GitHub
            </a>
        </div>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="docs-content-wrapper">

        <!-- Header -->
        <header class="docs-header">
            <button class="docs-menu-toggle" id="menuToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>

            <div class="docs-header-content">
                <div class="docs-header-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="docs-header-text">
                    <h1 class="docs-header-title">Documentação</h1>
                    <p class="docs-header-subtitle">Template Padrão MVC - IPPLS</p>
                </div>
            </div>

            <div class="docs-header-actions">
                <button class="docs-theme-toggle" id="themeToggle" title="Alternar tema">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </header>

        <!-- Breadcrumb -->
        <nav class="docs-breadcrumb">
            <a href="?page=home"><i class="fas fa-home"></i> Início</a>
            <i class="fas fa-chevron-right"></i>
            <span>Documentação</span>
        </nav>

        <!-- Conteúdo -->
        <article class="docs-content" id="docsContent">
            <?php if ($readmeExists): ?>
                <?= $html ?>
                <footer class="docs-content-footer">
                    <div class="docs-footer-section">
                        <h4><i class="fas fa-question-circle"></i> Encontrou um problema?</h4>
                        <p>Ajude-nos a melhorar esta documentação.</p>
                        <div class="docs-footer-links">
                            <a href="https://github.com/ippls/template-padrao/issues" target="_blank">
                                <i class="fab fa-github"></i> Reportar
                            </a>
                        </div>
                    </div>

                    <div class="docs-footer-section">
                        <h4><i class="fas fa-heart"></i> Precisa de ajuda?</h4>
                        <p>Entre em contato com a equipe IPPLS.</p>
                        <div class="docs-footer-links">
                            <a href="mailto:suporte@ippls.ao">
                                <i class="fas fa-envelope"></i> Email
                            </a>
                        </div>
                    </div>
                </footer>
            <?php else: ?>
                <div class="docs-empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h2>Documentação não disponível</h2>
                    <p>Crie um arquivo README.md na raiz do projeto.</p>
                </div>
            <?php endif; ?>
        </article>
    </main>
</div>

<!-- Overlay para mobile -->
<div class="docs-overlay" id="docsOverlay"></div>

<!-- Scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="assets/js/components/docs.js"></script>

<script>
// Highlight.js
document.addEventListener('DOMContentLoaded', function() {
    if (window.hljs) {
        document.querySelectorAll('pre code').forEach(block => {
            hljs.highlightElement(block);
        });
    }
});
</script>
PHP;
    }

    private function getReadmePadrao(): string
    {
        return <<<'MD'
# 📚 Template Padrão MVC - IPPLS

<div align="left">

**Template de Padronização para Projetos Acadêmicos**

[<img src="assets/images/logo/php.svg" alt="PHP" height="80" style="margin-left: .5rem;">](https://www.php.net/)
[<img src="assets/images/logo/composer.svg" alt="Composer" height="80"" style="margin-left: .5rem;">](https://getcomposer.org/)
[<img src="assets/images/logo/mysql.svg" alt="MySQL" height="80"" style="margin-left: .5rem;">](https://www.mysql.com/)
[<img src="assets/images/logo/license.svg" alt="License" height="50"" style="margin-left: .5rem;">](LICENSE)

[🚀 Instalação](#instalao) · [📖 Estrutura](#estrutura-do-projeto) · [💡 Criar Módulo](#criando-um-novo-mdulo) · [🐛 Problemas](#troubleshooting)

</div>

---

## <i class="fas fa-info-circle"></i> Sobre o Template

O **Template Padrão MVC - IPPLS** é uma solução profissional desenvolvida pelo **António Ambrósio Ngola** para ensinar e padronizar o desenvolvimento web, usando arquitetura MVC com foco no mercado de trabalho. Este template ajuda ao utilizador a se alinhar com boas práticas e profissionalismo na indústria de software, evitando perda de tempo no setup inicial de seus projetos de programação web. Explore o template apartir da documentação e sinta o poder dessa stack!

### ✨ Características

- 🏗️ **Arquitetura MVC** - Model, View, Controller bem definidos
- 📦 **Composer PSR-4** - Autoloading automático de classes
- 🛣️ **Sistema de Rotas** - Centralizado em `routes/web.php`
- 🏷️ **Namespaces** - Organização moderna com `App\`
- 🔒 **Segurança** - Prepared statements e sanitização
- 📱 **Design Responsivo** - Mobile-first com CSS modular
- 📚 **Documentação Web** - Interface moderna integrada

### 🎓 Ideal Para

- ✅ Estudantes aprendendo PHP e MVC
- ✅ Projetos acadêmicos do IPPLS
- ✅ Protótipos rápidos
- ✅ Base para projetos pequenos/médios

---

## 📊 Níveis de Template

| Template     |   Complexidade   | Características             |
| ------------ | :--------------: | --------------------------- |
| **Base**     |    🟢 Básico     | MVC simples sem autoloading |
| **Padrão**   | 🟡 Intermediário | **Este template** 👈        |
| **Avançado** |   🔴 Avançado    | Services, Middleware, API   |

---

## 📋 Requisitos

### Obrigatórios

```plaintext
✅ PHP >= 8.0
✅ Composer >= 2.0
✅ MySQL >= 5.7 ou MariaDB >= 10.2
✅ Apache com mod_rewrite
✅ Extensões: PDO, PDO_MySQL, mbstring
```

### Recomendado

```plaintext
🚀 PHP 8.2+
🚀 MySQL 8.0+
🚀 512MB RAM
```

---

## 🚀 Instalação

### 1. Clone ou Baixe

```bash
# Via Git
git clone https://github.com/ippls/template-padrao.git meu-projeto
cd meu-projeto
```

Ou baixe o ZIP apartir da plataforma e extraia

### 1.1 Configurar Servidor Local

Coloque os arquivos na pasta do seu servidor web:<br>

- **XAMPP**: `C:\xampp\htdocs\meu-projeto`
- **WAMP**: `C:\wamp64\www\meu-projeto`
- **MAMP**: `/Applications/MAMP/htdocs/meu-projeto`<br>
  Abre o projeto (meu-projeto) em um editor de código como:
- **VSCODE**

### 2. Instale Dependências

```bash
composer install
```

Ou se preferir especificar o autoload diretamente

```bash
composer dump-autoload
```

> **💡 Não tem Composer?** [Baixe aqui](https://getcomposer.org)

### 3. Configure o Banco

#### Criar banco:

```sql
CREATE DATABASE meu_projeto
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

#### Criar tabela users para teste:

```sql
USE meu_projeto;
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### Dados para teste (CRUD):

```sql
INSERT INTO users (name, email) VALUES
('Pai Grande Ngola', 'paigrandengola@gmail.com'),
('Kelson Filipe Dev', 'kelsonfilipedev@gmail.com');
('Anacleto Hebo', 'anacletohebo@gmail.com');
('Iliano Nicolau', 'ilianonicolau@gmail.com');
('José Adriano Mbala', 'adrianombala@gmail.com');
('José Lengo Júnior', 'lengojunior@gmail.com');
('João Victorino Bin', 'joaovictorinobin@gmail.com');
('Adário Mutembele Assunção', 'adarioassuncao@gmail.com');
('Zenaida Barbose', 'zenaidabarbose@gmail.com');
('Eng. Vanilson Manuel', 'vanilsonmanuel@gmail.com');
```

### 4. Configure Conexão

Edite `app/config/database.php`:

```php
$host = getenv('DB_HOST') ?: 'localhost';
$name = getenv('DB_NAME') ?: 'projeto_padrao';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
```

### 5. Acesse o Sistema

```
http://localhost/meu-projeto
```

**URLs disponíveis:**

- `/` - Página inicial
- `/?page=users` - Gestão de usuários com CRUD completo
- `/?page=docs` - Documentação do Template/Projeto

---

## 📁 Estrutura do Projeto

```
meu-projeto/
│
├── 📄 index.php                 # Ponto de entrada
├── 📄 composer.json             # Dependências e PSR-4
├── 📄 .htaccess                 # Reescrita de URLs
├── 📄 README.md                 # Esta documentação
│
├── 📁 app/                      # Código da aplicação
│   ├── config/                  # Configurações
│   │   ├── app.php             # Config gerais
│   │   ├── database.php        # Conexão PDO
│   │   ├── helpers.php         # Funções globais
│   │   └── constants.php       # Constantes de paths
│   ├── Http/Controllers/       # Controllers
│   │   ├── HomeController.php
│   │   └── UserController.php
│   └── Models/                  # Models
│       └── User.php
│
├── 📁 routes/                   # Sistema de rotas
│   └── web.php                 # Rotas da aplicação
│
├── 📁 views/                    # Templates PHP
│   ├── layouts/                # Layouts base
│   │   └── main.php
│   ├── pages/                  # Páginas
│   │   ├── home.php
│   │   ├── users.php
│   │   └── docs.php
│   ├── components/             # Componentes
│   │   ├── navbar.php
│   │   └── footer.php
│   └── errors/                 # Páginas de erro
│       ├── 404.php
│       └── 500.php
│
├── 📁 assets/                  # Recursos estáticos
│   ├── css/                    # Estilos
│   │   ├── components/         # Componentes CSS
│   │   ├── sections/           # Componentes de Secções
│   │   ├── base.css            # Reset e variáveis
│   │   └── style.css           # Importação central
│   ├── js/                     # JavaScript
│   │   ├── components/
│   │   ├────── navbar.js
│   │   ├────── docs.js
│   │   ├────── backToTop.js
│   │   ├── main.js
│   └── images/                 # Imagens
│
└── 📁 vendor/                   # Dependências Composer
```

---

## 🎓 Como Funciona

### Fluxo de Execução

```
1. index.php
   ↓
2. Composer Autoload (PSR-4)
   ↓
3. Configurações (app.php, database.php, helpers.php)
   ↓
4. Session Start
   ↓
5. routes/web.php (Roteamento)
   ↓
6. Controller (processa requisição)
   ↓
7. Model (acessa banco de dados)
   ↓
8. View (renderiza HTML)
```

### Padrão MVC

```
┌─────────┐      ┌────────────┐      ┌──────┐
│  Model  │◄─────│ Controller │─────►│ View │
│  (BD)   │      │  (Lógica)  │      │ (UI) │
└─────────┘      └────────────┘      └──────┘
```

### Sistema de Rotas

```php
/**
 * Rotas Web - Template Padrão IPPLS
 * Sistema de roteamento centralizado com tratamento de erros
 */
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
// ===============================
// CAPTURA DA URL
// ===============================
// page = páginas normais
// action = ações de CRUD
$page   = $_GET['page']   ?? null;
$action = $_GET['action'] ?? null;
try {
    // ===============================
    // 1. ROTAS DE PÁGINAS
    // ===============================
    if ($page) {
        switch ($page) {
            case 'home':
                $controller = new HomeController();
                return $controller->index();
            case 'users':
                $controller = new UserController();
                return $controller->index();
            case 'docs':
                $controller = new HomeController();
                return $controller->docs();
                exit;
            default:
                http_response_code(404);
                require ERRORS_PATH . '/404.php';
                exit;
        }
    }
    // ===============================
    // 2. ROTAS DE AÇÕES (CRUD)
    // ===============================
    if ($action) {
        switch ($action) {
            case 'index':
                $controller = new UserController();
                return $controller->index();
            case 'create':
                $controller = new UserController();
                return $controller->create();
            case 'update':
                $controller = new UserController();
                return $controller->update();
            case 'delete':
                $controller = new UserController();
                return $controller->delete();
            default:
                http_response_code(404);
                require ERRORS_PATH . '/404.php';
                exit;
        }
    }
    // ===============================
    // 3. SE NADA FOI DEFINIDO → HOME
    // ===============================
    $controller = new HomeController();
    return $controller->index();
} catch (\Exception $e) {
    // ===============================
    // TRATAMENTO DE ERROS 500
    // ===============================
    error_log("ERRO NO SISTEMA: " . $e->getMessage());
    error_log("ARQUIVO: " . $e->getFile());
    error_log("LINHA: " . $e->getLine());
    http_response_code(500);
    if (APP_ENV === 'development') {
        echo "<h1>Erro 500 - Desenvolvimento</h1>";
        echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        require ERRORS_PATH . '/500.php';
    }
}
```

### Autoloading PSR-4

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/"
    }
  }
}
```

---

## 🛠️ Criando um Novo Módulo

### Exemplo Completo: Produtos

#### 1️⃣ Criar Tabela

```sql
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

#### 2️⃣ Criar Model

```php
<?php
// app/Models/Product.php
namespace App\Models;
use PDO;
class Product {
    private PDO $db;
    public function __construct() {
        $this->db = db();
    }
    public function all(): array {
        $query = "SELECT * FROM products ORDER BY name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function find(int $id): ?array {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    public function create(array $data): bool {
        $query = "INSERT INTO products (name, price, stock)
                  VALUES (:name, :price, :stock)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }
    public function delete(int $id): bool {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
```

#### 3️⃣ Criar Controller

```php
<?php
// app/Http/Controllers/ProductController.php
namespace App\Http\Controllers;
use App\Models\Product;
class ProductController {
    private Product $product;
    public function __construct() {
        $this->product = new Product();
    }
    public function index(): void {
        $products = $this->product->all();
        $title = 'Produtos';
        $content = PAGES_PATH . '/products.php';
        require LAYOUTS_PATH . '/main.php';
    }
    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'stock' => $_POST['stock'] ?? 0
            ];
            if ($this->product->create($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Produto criado com sucesso!'
                ];
                redirect('/?page=products');
            }
        }
        $title = 'Novo Produto';
        $content = PAGES_PATH . '/product-form.php';
        require LAYOUTS_PATH . '/main.php';
    }
}
```

#### 4️⃣ Criar View

```php
<?php
// views/pages/products.php
?>
<div class="main-container">
    <div class="page-header">
        <h1><i class="fas fa-box"></i> Produtos</h1>
        <a href="/?page=products&action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo
        </a>
    </div>
    <div class="card">
        <table class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Estoque</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= e($product['name']) ?></td>
                        <td>R$ <?= number_format($product['price'], 2, ',', '.') ?></td>
                        <td><?= $product['stock'] ?></td>
                        <td>
                            <a href="/?page=products&action=delete&id=<?= $product['id'] ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Tem certeza?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
```

#### 5️⃣ Adicionar Rota

```php
<?php
// routes/web.php
use App\Http\Controllers\ProductController;
// Adicione este case no switch:
case 'products':
    $controller = new ProductController();
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'create':
                $controller->create();
                break;
            case 'delete':
                $controller->delete();
                break;
            default:
                $controller->index();
        }
    } else {
        $controller->index();
    }
    break;
```

---

## 🔒 Segurança

### ✅ Prepared Statements

```php
// ✅ CORRETO - Seguro contra SQL Injection
$stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
// ❌ ERRADO - Vulnerável
$query = "SELECT * FROM users WHERE email = '$email'";
```

### ✅ Sanitização HTML

```php
// Use a função e() incluída no template
echo e($user['name']); // Escapado com htmlspecialchars()
// Ou diretamente:
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
```

### ✅ Validação de Dados

```php
// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email inválido';
}
// Números
$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
// Não vazio
if (empty(trim($_POST['name']))) {
    $errors[] = 'Nome é obrigatório';
}
```

### ✅ Sessões Seguras

```php
// app/config/app.php
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,  // Apenas HTTPS
    'cookie_samesite' => 'Strict'
]);
```

---

## 💡 Boas Práticas

### 1. Use Type Hints

```php
public function find(int $id): ?array {
    // ...
}
public function create(array $data): bool {
    // ...
}
```

### 2. Separe Responsabilidades

```php
// ✅ BOM: Lógica no Model
class User {
    public function findByEmail(string $email): ?array {
        // SQL aqui
    }
}
// ❌ RUIM: SQL no Controller
class UserController {
    public function index() {
        $query = "SELECT * FROM users"; // Não faça isso
    }
}
```

### 3. Mensagens Flash

```php
// Controller
$_SESSION['flash_message'] = [
    'type' => 'success',
    'message' => 'Salvo com sucesso!'
];
redirect('/?page=users');
// View (já implementado no layout)
// As mensagens são exibidas automaticamente
```

### 4. Use Constantes de Path

```php
// ✅ CORRETO
require PAGES_PATH . '/home.php';
require COMPONENTS_PATH . '/navbar.php';
// ❌ EVITE
require __DIR__ . '/../../../views/pages/home.php';
```

---

## 🎨 Customização

### Alterar Cores

Edite `assets/css/base/reset.css`:

```css
:root {
  --ippls-blue-dark: #002b5b;
  --ippls-gold: #ffd700;
  --ippls-red: #c1272d;
}
```

### Adicionar Estilos

```css
/* assets/css/components/meu-componente.css */
.meu-componente {
  /* seus estilos */
}
```

```css
/* assets/css/style.css - Importar */
@import "components/meu-componente.css";
```

---

## 🐛 Troubleshooting

### ❌ "Class not found"

```bash
composer dump-autoload
```

### ❌ "Database connection failed"

1. Verifique credenciais em `app/config/database.php`<br>
2. Confirme que MySQL está rodando<br>
3. Teste: `mysql -u root -p`

### ❌ Erro 404 em todas as páginas

1. Verifique `mod_rewrite`:

```bash
apache2ctl -M | grep rewrite
```

2. Confirme que `.htaccess` existe<br
3. Verifique `AllowOverride All` no Apache

### ❌ CSS/JS não carregam

Verifique caminhos no `main.php`:

```php
<link rel="stylesheet" href="assets/css/style.css">
```

---

## 📚 Funções Auxiliares

O template inclui funções em `app/config/helpers.php`:

### `db()`

```php
// Retorna instância PDO
$db = db();
$stmt = $db->prepare("SELECT * FROM users");
```

### `e()`

```php
// Escapa HTML
echo e($user['name']);
```

### `redirect()`

```php
// Redireciona e para execução
redirect('/?page=home');
```

---

## 📖 Documentação Web

Ao acessar `/?page=docs` poderás visualizar:

- ✅ Navegação interativa
- ✅ Pesquisa em tempo real
- ✅ Tema claro/escuro
- ✅ Syntax highlighting
- ✅ Design responsivo

---

## 🤝 Contribuindo

1. Fork o repositório<br>
2. Crie uma branch (`git checkout -b feature/MinhaFeature`)<br>
3. Commit (`git commit -m 'Adiciona MinhaFeature'`)<br>
4. Push (`git push origin feature/MinhaFeature`)<br>
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está sob a licença MIT.

---

## 🏫 Créditos

**Instituto Politécnico Privado Lucrêcio dos Santos (IPPLS)**

- 🌍 Luanda, Angola
- 📧 suporte@ippls.ao
- 🌐 [ippls.ao](https://ippls.ao)

---

<div align="center">

**Desenvolvido com 💙 para o IPPLS**

_Template Padrão MVC v1.0.0 © 2025_

</div>
MD;
    }

    /* ==========================================
    // TEMPLATE AVANÇADO - NOVOS MÉTODOS
    // ==========================================

    private function getIndexAvancado(): string
    {
        return <<<'PHP'
<?php
/**
 * Template Avançado - Service Layer e Injeção de Dependências
 * IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos
 *

// Autoloader do Composer
require_once __DIR__ . '/vendor/autoload.php';

// Configurações
require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/services.php';

// Iniciar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Container de Dependências
$container = new \App\Container();
$container->registerServices();

// Sistema de Rotas
require_once __DIR__ . '/routes/web.php';
PHP;
    }

    private function getComposerJsonAvancado(): string
    {
        return <<<'JSON'
{
    "name": "ippls/template-avancado",
    "description": "Template Avançado com Service Layer e DI - IPPLS",
    "type": "project",
    "license": "MIT",
    "require": {
        "php": ">=8.1"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/helpers.php"
        ]
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "test": "phpunit",
        "test:unit": "phpunit --testsuite Unit",
        "test:feature": "phpunit --testsuite Feature"
    },
    "config": {
        "optimize-autoloader": true,
        "sort-packages": true
    }
}
JSON;
    }*/

    private function getPhpunitXml(): string
    {
        return <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<phpunit bootstrap="vendor/autoload.php"
         colors="true"
         stopOnFailure="false">
    <testsuites>
        <testsuite name="Unit">
            <directory suffix="Test.php">./tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory suffix="Test.php">./tests/Feature</directory>
        </testsuite>
    </testsuites>
</phpunit>
XML;
    }

    /*private function getWebRoutesAvancado(): string
    {
        return <<<'PHP'
<?php
/**
 * Rotas Web - Template Avançado
 * Sistema de roteamento com injeção de dependências
 *

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

// Captura página e ação
$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// Roteamento com DI
try {
    switch ($page) {
        case 'home':
            $controller = $container->make(HomeController::class);
            break;

        case 'users':
            $controller = $container->make(UserController::class);
            break;

        default:
            http_response_code(404);
            require __DIR__ . '/../views/errors/404.php';
            exit;
    }

    // Executar ação
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->index();
    }

} catch (\Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo "Erro interno do servidor";
}
PHP;
    }

    private function getApiRoutes(): string
    {
        return <<<'PHP'
<?php
/**
 * Rotas API - Template Avançado
 *

header('Content-Type: application/json');

use App\Http\Controllers\Api\UserApiController;

$method = $_SERVER['REQUEST_METHOD'];
$path = $_GET['path'] ?? '';

try {
    $controller = $container->make(UserApiController::class);

    switch ($path) {
        case 'users':
            if ($method === 'GET') {
                $controller->index();
            } elseif ($method === 'POST') {
                $controller->store();
            }
            break;

        case 'users/show':
            $controller->show();
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint não encontrado']);
    }

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
PHP;
    }*

    private function getServicesConfig(): string
    {
        return <<<'PHP'
<?php
/**
 * Container de Injeção de Dependências
 *

namespace App;

class Container
{
    private array $services = [];

    public function registerServices(): void
    {
        // Registrar Repositories
        $this->services[\App\Repositories\UserRepository::class] = function() {
            return new \App\Repositories\UserRepository(db());
        };

        // Registrar Services
        $this->services[\App\Services\UserService::class] = function() {
            $userRepo = $this->make(\App\Repositories\UserRepository::class);
            return new \App\Services\UserService($userRepo);
        };

        $this->services[\App\Services\AuthService::class] = function() {
            return new \App\Services\AuthService();
        };
    }

    public function make(string $class)
    {
        if (isset($this->services[$class])) {
            return $this->services[$class]();
        }

        return new $class();
    }
}
PHP;
    }

    private function getUserModelAvancado(): string
    {
        return <<<'PHP'
<?php

namespace App\Models;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private ?\DateTime $created_at = null;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill(array $data): self
    {
        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';

        if (isset($data['created_at'])) {
            $this->created_at = new \DateTime($data['created_at']);
        }

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s')
        ];
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getCreatedAt(): ?\DateTime { return $this->created_at; }

    // Setters
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }
}
PHP;*
    }

    private function getUserService(): string
    {
        return <<<'PHP'
<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function createUser(array $data): User
    {
        // Validação
        $this->validateUserData($data);

        // Verificar email único
        if ($this->userRepository->emailExists($data['email'])) {
            throw new \Exception('Email já cadastrado');
        }

        // Criar usuário
        $user = new User();
        $user->setName($data['name'])
             ->setEmail($data['email']);

        return $this->userRepository->create($user);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->getUserById($id);

        if (!$user) {
            throw new \Exception('Usuário não encontrado');
        }

        $this->validateUserData($data);

        if ($this->userRepository->emailExists($data['email'], $id)) {
            throw new \Exception('Email já cadastrado');
        }

        $user->setName($data['name'])
             ->setEmail($data['email']);

        return $this->userRepository->update($user);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    private function validateUserData(array $data): void
    {
        if (empty($data['name'])) {
            throw new \Exception('Nome é obrigatório');
        }

        if (empty($data['email'])) {
            throw new \Exception('Email é obrigatório');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Email inválido');
        }
    }
}
PHP;
    }

    private function getAuthService(): string
    {
        return <<<'PHP'
<?php

namespace App\Services;

class AuthService
{
    public function login(string $email, string $password): bool
    {
        // Implementar lógica de autenticação
        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
}
PHP;
    }

    private function getUserRepository(): string
    {
        return <<<'PHP'
<?php

namespace App\Repositories;

use App\Models\User;
use PDO;

class UserRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        $data = $stmt->fetchAll();

        return array_map(fn($row) => new User($row), $data);
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();

        return $data ? new User($data) : null;
    }

    public function create(User $user): User
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
        );

        $stmt->execute([
            $user->getName(),
            $user->getEmail()
        ]);

        $user->fill(['id' => $this->db->lastInsertId()]);
        return $user;
    }

    public function update(User $user): User
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );

        $stmt->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getId()
        ]);

        return $user;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
PHP;
    }

    private function getRepositoryInterface(): string
    {
        return <<<'PHP'
<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function findAll(): array;
    public function findById(int $id);
    public function create(object $entity): object;
    public function update(object $entity): object;
    public function delete(int $id): bool;
}
PHP;
    }

    private function getHomeControllerAvancado(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class HomeController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): void
    {
        $title = 'Template Avançado - Service Layer';
        $usersCount = count($this->userService->getAllUsers());

        require __DIR__ . '/../../../views/pages/home.php';
    }
}
PHP;
    }

    private function getUserControllerAvancado(): string
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): void
    {
        try {
            $users = $this->userService->getAllUsers();
            require __DIR__ . '/../../../views/pages/users.php';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: ?page=home');
        }
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=users');
            exit;
        }

        try {
            $this->userService->createUser([
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? ''
            ]);

            $_SESSION['success'] = 'Usuário criado com sucesso!';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ?page=users');
        exit;
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=users');
            exit;
        }

        try {
            $this->userService->updateUser(
                intval($_POST['id'] ?? 0),
                [
                    'name' => $_POST['name'] ?? '',
                    'email' => $_POST['email'] ?? ''
                ]
            );

            $_SESSION['success'] = 'Usuário atualizado!';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ?page=users');
        exit;
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?page=users');
            exit;
        }

        try {
            $this->userService->deleteUser(intval($_POST['id'] ?? 0));
            $_SESSION['success'] = 'Usuário deletado!';
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
        }

        header('Location: ?page=users');
        exit;
    }
}
PHP;
    }

    private function getHomeViewAvancado(): string
    {
        return <<<'HTML'
<div class="hero-section">
    <div class="hero-container">
        <h1>Template Avançado</h1>
        <p class="hero-subtitle">Service Layer e Injeção de Dependências</p>
        <div class="hero-stats">
            <div class="stat-card">
                <span class="stat-number"><?= $usersCount ?? 0 ?></span>
                <span class="stat-label">Usuários</span>
            </div>
        </div>
        <div class="hero-buttons">
            <a href="?page=users" class="btn-hero btn-hero-primary">Gerenciar Usuários</a>
            <a href="README.md" class="btn-hero btn-hero-secondary">Documentação</a>
        </div>
    </div>
</div>

<div class="features-grid">
    <div class="feature-card">
        <h3>⚡ Service Layer</h3>
        <p>Lógica de negócio separada</p>
    </div>
    <div class="feature-card">
        <h3>💉 Injeção de Dependências</h3>
        <p>Baixo acoplamento</p>
    </div>
    <div class="feature-card">
        <h3>🧪 Testes Unitários</h3>
        <p>PHPUnit integrado</p>
    </div>
    <div class="feature-card">
        <h3>📦 Repository Pattern</h3>
        <p>Abstração de dados</p>
    </div>
</div>
HTML;
    }*

    private function getAlertComponent(): string
    {
        return <<<'PHP'
<?php
/**
 * Componente de Alerta Reutilizável
 * Uso: require 'components/alert.php';
 *
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <span>✓</span>
        <span><?= htmlspecialchars($_SESSION['success']) ?></span>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <span>⚠</span>
        <span><?= htmlspecialchars($_SESSION['error']) ?></span>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
PHP;
    }

    private function getTableComponent(): string
    {
        return <<<'PHP'
<?php
/**
 * Componente de Tabela Reutilizável
 * Uso: require 'components/table.php';
 * Requer: $headers (array), $data (array)
 *
?>
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?= htmlspecialchars($header) ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data)): ?>
                <tr>
                    <td colspan="<?= count($headers) ?>" style="text-align:center">
                        Nenhum registro encontrado
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?= htmlspecialchars($cell) ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
PHP;
    }

    private function getUserServiceTest(): string
    {
        return <<<'PHP'
<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\UserService;
use App\Repositories\UserRepository;
use App\Models\User;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    private $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userService = new UserService($this->userRepository);
    }

    public function testCreateUserWithValidData(): void
    {
        $data = [
            'name' => 'João Silva',
            'email' => 'joao@ippls.edu.ao'
        ];

        $user = new User(['id' => 1, ...$data]);

        $this->userRepository
            ->expects($this->once())
            ->method('emailExists')
            ->with($data['email'])
            ->willReturn(false);

        $this->userRepository
            ->expects($this->once())
            ->method('create')
            ->willReturn($user);

        $result = $this->userService->createUser($data);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('João Silva', $result->getName());
    }

    public function testCreateUserWithDuplicateEmail(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Email já cadastrado');

        $data = [
            'name' => 'João Silva',
            'email' => 'joao@ippls.edu.ao'
        ];

        $this->userRepository
            ->method('emailExists')
            ->willReturn(true);

        $this->userService->createUser($data);
    }
}
PHP;
    }

    private function getUserControllerTest(): string
    {
        return <<<'PHP'
<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{
    public function testIndexReturnsUsers(): void
    {
        // Teste de integração aqui
        $this->assertTrue(true);
    }
}
PHP;
    }

    private function getReadmeAvancado(): string
    {
        return <<<'MD'
# Template Avançado - Service Layer e DI

Arquitetura enterprise com Service Layer, Injeção de Dependências e testes automatizados.

## 🎯 Novidades vs Template Padrão

- ✅ **Service Layer** para lógica de negócio
- ✅ **Injeção de Dependências** com container
- ✅ **Repository Pattern** para abstração de dados
- ✅ **PHPUnit** para testes unitários e de integração
- ✅ **Componentes reutilizáveis**
- ✅ **API REST** básica

## 📋 Requisitos

- PHP >= 8.1
- Composer >= 2.5
- PHPUnit >= 10.0
- MySQL >= 8.0

## 🚀 Instalação

### 1. Instalar Dependências
```bash
composer install
```

### 2. Configurar Banco de Dados
```sql
CREATE DATABASE projeto_avancado;
-- (mesmo schema do template padrão)
```

### 3. Rodar Testes
```bash
composer test
```

## 📁 Estrutura

```
projeto_avancado/
├── app/
│   ├── Http/
│   │   └── Controllers/         # Controllers com DI
│   ├── Models/                  # Entities (objetos de domínio)
│   ├── Services/                # Lógica de negócio
│   ├── Repositories/            # Acesso a dados
│   └── Interfaces/              # Contratos
├── routes/                      # Rotas web e API
├── tests/                       # Testes automatizados
│   ├── Unit/                    # Testes unitários
│   └── Feature/                 # Testes de integração
├── config/
│   └── services.php             # Container de DI
└── phpunit.xml                  # Configuração PHPUnit
```

## 🎓 Conceitos Avançados

### Service Layer
```php
class UserService {
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function createUser(array $data): User {
        $this->validateUserData($data);
        // Lógica de negócio aqui
        return $this->userRepository->create($user);
    }
}
```

### Injeção de Dependências
```php
// Container registra serviços
$container->registerServices();

// Controller recebe dependências
class UserController {
    public function __construct(
        private UserService $userService
    ) {}
}
```

### Repository Pattern
```php
class UserRepository {
    public function __construct(private PDO $db) {}

    public function findAll(): array {
        // Acesso ao banco abstraído
    }
}
```

### Testes Unitários
```bash
# Rodar todos os testes
composer test

# Apenas testes unitários
composer test:unit

# Apenas testes de integração
composer test:feature
```

## 🔄 Progressão Arquitetural

| Característica | Base | Padrão | **Avançado** |
|---|---|---|---|
| Service Layer | ❌ | ❌ | **✅** |
| DI Container | ❌ | ❌ | **✅** |
| Repository | ❌ | ❌ | **✅** |
| Testes | ❌ | ❌ | **✅ PHPUnit** |
| API REST | ❌ | ❌ | **✅** |
| Componentes | ❌ | ❌ | **✅** |

## 💡 Boas Práticas Enterprise

- Separe lógica de negócio em Services
- Use DI para baixo acoplamento
- Escreva testes para código crítico
- Abstraia acesso a dados com Repositories
- Documente APIs com comentários
- Use interfaces para contratos
- Componentes reutilizáveis para views

## 🧪 Exemplo de Teste

```php
public function testCreateUserWithValidData(): void {
    $data = ['name' => 'João', 'email' => 'joao@ippls.edu.ao'];
    $result = $this->userService->createUser($data);
    $this->assertInstanceOf(User::class, $result);
}
```

---

**Desenvolvido com ❤️ para o IPPLS**
MD;
    }*/

    private function getInstrucoesPadrao(): string
    {
        return "# Guia de Instalação - Template Padrão\n\n## 1. Instalar Composer\n## 2. Configurar Banco\n## 3. Rodar composer install\n## 4. Configurar .htaccess\n## 5. Acessar Aplicação";
    }

    // private function getInstrucoesAvancado(): string
    // {
    //     return "# Guia de Instalação - Template Avançado\n\n## 1. Instalar Dependências\n## 2. Configurar Ambiente\n## 3. Rodar Migrações\n## 4. Executar Testes\n## 5. Desenvolvimento";
    // }
































    // ==========================================
// TEMPLATE AVANÇADO - MÉTODOS AUXILIARES PARTE 1
// Core: index.php, .htaccess, rotas, configurações
// ==========================================

private function getIndexAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Template Avançado - MVC com URLs Amigáveis
 * IPPLS - Instituto Politécnico Privado Lucrêcio dos Santos
 *
 * ORDEM DE CARREGAMENTO:
 * 1. Composer Autoload (PSR-4)
 * 2. Configurações (app, database, constants, helpers)
 * 3. Sessão
 * 4. Middleware
 * 5. Rotas (web.php ou api.php)
 */

// ============================================
// 1. AUTOLOADER DO COMPOSER (PSR-4)
// ============================================
require_once __DIR__ . '/vendor/autoload.php';

// ============================================
// 2. CONFIGURAÇÕES DA APLICAÇÃO
// ============================================
require_once __DIR__ . '/app/config/app.php';
require_once __DIR__ . '/app/config/constants.php';
require_once __DIR__ . '/app/config/database.php';
require_once __DIR__ . '/app/config/helpers.php';

// ============================================
// 3. INICIAR SESSÃO
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict'
    ]);
}

// ============================================
// 4. DETECTAR TIPO DE REQUISIÇÃO (WEB ou API)
// ============================================
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

// Remover base path da URI
$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?'); // Remover query string
$uri = trim($uri, '/');

// Verificar se é requisição API
if (str_starts_with($uri, 'api/') || str_starts_with($uri, 'api')) {
    // API REST
    header('Content-Type: application/json; charset=utf-8');
    require_once ROUTES_PATH . '/api.php';
    exit;
}

// ============================================
// 5. ROTAS WEB
// ============================================
require_once ROUTES_PATH . '/web.php';
PHP;
}

private function getHtaccessAvancado(): string
{
    return <<<'HTACCESS'
# Template Avançado IPPLS - URLs Amigáveis
# Configuração Apache para URLs profissionais

<IfModule mod_rewrite.c>
    RewriteEngine On

    # Definir base path (ajuste se necessário)
    RewriteBase /projeto_avancado/

    # Redirecionar www para não-www (opcional)
    # RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
    # RewriteRule ^(.*)$ http://%1/$1 [R=301,L]

    # Permitir acesso direto a arquivos existentes
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d

    # Redirecionar tudo para index.php
    RewriteRule ^(.*)$ index.php [QSA,L]
</IfModule>

# Desabilitar listagem de diretórios
Options -Indexes

# Proteger arquivos sensíveis
<FilesMatch "^(composer\.(json|lock)|\.env|\.git.*|\.htaccess)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Configurações PHP (se permitido)
<IfModule mod_php.c>
    php_flag display_errors On
    php_value upload_max_filesize 10M
    php_value post_max_size 10M
    php_value max_execution_time 300
</IfModule>

# Compressão GZIP
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Cache de arquivos estáticos
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Headers de segurança
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
</IfModule>
HTACCESS;
}

private function getComposerJsonAvancado(): string
{
    return <<<'JSON'
{
    "name": "ippls/template-avancado",
    "description": "Template Avançado MVC - URLs Amigáveis, Middleware e Recursos Expandidos",
    "type": "project",
    "license": "MIT",
    "authors": [
        {
            "name": "IPPLS",
            "email": "suporte@ippls.ao"
        }
    ],
    "require": {
        "php": ">=8.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "config": {
        "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true
    },
    "scripts": {
        "post-install-cmd": [
            "@php -r \"echo 'Template Avançado instalado com sucesso!\\n';\""
        ]
    }
}
JSON;
}

private function getWebRoutesAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Rotas Web - Template Avançado
 * Sistema de roteamento com URLs amigáveis
 */

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;

// ===============================
// PARSEAMENTO DA URL
// ===============================
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

// Remover base path e query string
$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?');
$uri = trim($uri, '/');

// Dividir URI em segmentos
$segments = $uri ? explode('/', $uri) : [];
$page = $segments[0] ?? 'home';
$action = $segments[1] ?? null;
$id = $segments[2] ?? null;

// ===============================
// ROTAS PÚBLICAS (SEM AUTENTICAÇÃO)
// ===============================

try {
    // HOME
    if ($page === '' || $page === 'home') {
        $controller = new HomeController();
        $controller->index();
        exit;
    }

    // DOCUMENTAÇÃO
    if ($page === 'docs') {
        $controller = new HomeController();
        $controller->docs();
        exit;
    }

    // AUTENTICAÇÃO
    if ($page === 'login') {
        $controller = new AuthController();
        $controller->showLogin();
        exit;
    }

    if ($page === 'register') {
        $controller = new AuthController();
        $controller->showRegister();
        exit;
    }

    if ($page === 'logout') {
        $controller = new AuthController();
        $controller->logout();
        exit;
    }

    // Processar login/registro
    if ($page === 'auth') {
        $controller = new AuthController();
        if ($action === 'login') {
            $controller->login();
        } elseif ($action === 'register') {
            $controller->register();
        }
        exit;
    }

    // ===============================
    // MIDDLEWARE DE AUTENTICAÇÃO
    // ===============================
    // AuthMiddleware::handle();

    // ===============================
    // ROTAS PROTEGIDAS (COM AUTENTICAÇÃO)
    // ===============================

    // DASHBOARD
    if ($page === 'dashboard') {
        $controller = new HomeController();
        $controller->dashboard();
        exit;
    }

    // USUÁRIOS
    if ($page === 'users') {
        $controller = new UserController();

        if ($action === null) {
            $controller->index();
        } elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } elseif ($action === 'edit' && $id) {
            $controller->edit((int)$id);
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        } elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            $controller->index();
        }
        exit;
    }

    // PRODUTOS
    if ($page === 'products') {
        $controller = new ProductController();

        if ($action === null) {
            $controller->index();
        } elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->create();
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->update();
        } elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->delete();
        } else {
            $controller->index();
        }
        exit;
    }

    // ===============================
    // ROTA 404
    // ===============================
    http_response_code(404);
    require ERRORS_PATH . '/404.php';
    exit;

} catch (\Exception $e) {
    // ===============================
    // TRATAMENTO DE ERROS 500
    // ===============================
    error_log("ERRO NO SISTEMA: " . $e->getMessage());
    error_log("ARQUIVO: " . $e->getFile() . " | LINHA: " . $e->getLine());

    http_response_code(500);

    if (APP_ENV === 'development') {
        echo "<h1>Erro 500 - Desenvolvimento</h1>";
        echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
        echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    } else {
        require ERRORS_PATH . '/500.php';
    }
}
PHP;
}

private function getApiRoutesAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Rotas API - Template Avançado
 * API REST para integrações
 */

use App\Http\Controllers\ApiController;

// Configurar resposta JSON
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // Ajuste conforme necessário
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Parseamento da URL
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$basePath = rtrim($scriptName, '/');

$uri = substr($requestUri, strlen($basePath));
$uri = strtok($uri, '?');
$uri = trim($uri, '/');

// Remover prefixo 'api/'
$uri = preg_replace('/^api\/?/', '', $uri);
$segments = $uri ? explode('/', $uri) : [];

$resource = $segments[0] ?? null;
$id = $segments[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

try {
    $controller = new ApiController();

    // USERS API
    if ($resource === 'users') {
        if ($method === 'GET' && $id === null) {
            $controller->getUsers();
        } elseif ($method === 'GET' && $id !== null) {
            $controller->getUser((int)$id);
        } elseif ($method === 'POST') {
            $controller->createUser();
        } elseif ($method === 'PUT' && $id !== null) {
            $controller->updateUser((int)$id);
        } elseif ($method === 'DELETE' && $id !== null) {
            $controller->deleteUser((int)$id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
        }
        exit;
    }

    // PRODUCTS API
    if ($resource === 'products') {
        if ($method === 'GET' && $id === null) {
            $controller->getProducts();
        } elseif ($method === 'GET' && $id !== null) {
            $controller->getProduct((int)$id);
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido']);
        }
        exit;
    }

    // ENDPOINT NÃO ENCONTRADO
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint não encontrado']);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Erro interno do servidor',
        'message' => APP_ENV === 'development' ? $e->getMessage() : null
    ]);
}
PHP;
}

// ==========================================
// TEMPLATE AVANÇADO - MÉTODOS AUXILIARES PARTE 2
// Configurações e Middleware
// ==========================================

private function getAppConfigAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Configuração da Aplicação - Template Avançado
 */

define('APP_NAME', 'Template Avançado IPPLS');
define('APP_URL', 'http://localhost');
define('APP_ENV', 'development'); // production, development
define('APP_VERSION', '1.0.0');

// Timezone
date_default_timezone_set('Africa/Luanda');

// Error reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/app.log');
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/app.log');
}

// Upload settings
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_execution_time', '300');

// Sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// CSRF Token (gerar se não existir)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
PHP;
}

private function getDatabaseConfigAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Configuração de Banco de Dados - Template Avançado
 */

namespace App\Config;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = getenv('DB_HOST') ?: 'localhost';
        $name = getenv('DB_NAME') ?: 'projeto_avancado';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_PASS') ?: '';
        $charset = 'utf8mb4';

        try {
            $dsn = "mysql:host={$host};dbname={$name};charset={$charset}";
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}"
            ];

            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            error_log("Erro de conexão com banco: " . $e->getMessage());

            if (APP_ENV === 'development') {
                die("Erro de conexão: " . $e->getMessage());
            } else {
                die("Erro ao conectar ao banco de dados. Contate o administrador.");
            }
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): \PDO
    {
        return $this->pdo;
    }
}
PHP;
}

private function getConstantsConfigAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Constantes Globais - Template Avançado
 */

// ============================================
// CAMINHOS BASE
// ============================================
define('BASE_PATH', dirname(__DIR__, 2));
define('APP_PATH', BASE_PATH . '/app');
define('VIEWS_PATH', BASE_PATH . '/views');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('CONFIG_PATH', APP_PATH . '/config');
define('CONTROLLERS_PATH', APP_PATH . '/Http/Controllers');
define('MIDDLEWARE_PATH', APP_PATH . '/Http/Middleware');
define('MODELS_PATH', APP_PATH . '/Models');
define('ROUTES_PATH', BASE_PATH . '/routes');
define('VENDOR_PATH', BASE_PATH . '/vendor');

// ============================================
// CAMINHOS DE VIEWS
// ============================================
define('LAYOUTS_PATH', VIEWS_PATH . '/layouts');
define('PAGES_PATH', VIEWS_PATH . '/pages');
define('COMPONENTS_PATH', VIEWS_PATH . '/components');
define('ERRORS_PATH', VIEWS_PATH . '/errors');

// ============================================
// CAMINHOS DE ASSETS
// ============================================
define('ASSETS_PATH', PUBLIC_PATH . '/assets');
define('CSS_PATH', ASSETS_PATH . '/css');
define('JS_PATH', ASSETS_PATH . '/js');
define('IMAGES_PATH', ASSETS_PATH . '/images');
define('UPLOADS_PATH', PUBLIC_PATH . '/uploads');

// ============================================
// CAMINHOS DE STORAGE
// ============================================
define('LOGS_PATH', STORAGE_PATH . '/logs');
define('CACHE_PATH', STORAGE_PATH . '/cache');
define('SESSIONS_PATH', STORAGE_PATH . '/sessions');

// ============================================
// AMBIENTE
// ============================================
define('IS_DEVELOPMENT', APP_ENV === 'development');
define('IS_PRODUCTION', APP_ENV === 'production');

// ============================================
// PAGINAÇÃO
// ============================================
define('ITEMS_PER_PAGE', 10);

// ============================================
// UPLOAD
// ============================================
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
define('ALLOWED_DOCUMENT_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
PHP;
}

private function getHelpersConfigAvancado(): string
{
    return <<<'PHP'
<?php
/**
 * Funções Auxiliares - Template Avançado
 */

use App\Config\Database;

// ============================================
// DATABASE
// ============================================

if (!function_exists('db')) {
    /**
     * Retorna instância PDO do banco de dados
     */
    function db(): PDO
    {
        return Database::getInstance()->getConnection();
    }
}

// ============================================
// REDIRECT
// ============================================

if (!function_exists('redirect')) {
    /**
     * Redireciona para URL especificada
     */
    function redirect(string $url): void
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $fullUrl = $baseUrl . '/' . ltrim($url, '/');
        header("Location: {$fullUrl}");
        exit;
    }
}

if (!function_exists('back')) {
    /**
     * Redireciona para página anterior
     */
    function back(): void
    {
        $referrer = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: {$referrer}");
        exit;
    }
}

// ============================================
// ESCAPE / SANITIZE
// ============================================

if (!function_exists('e')) {
    /**
     * Escapa HTML
     */
    function e($text): string
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('clean')) {
    /**
     * Remove tags HTML e espaços
     */
    function clean($text): string
    {
        return trim(strip_tags($text ?? ''));
    }
}

// ============================================
// FLASH MESSAGES
// ============================================

if (!function_exists('flash')) {
    /**
     * Define mensagem flash
     */
    function flash(string $type, string $message): void
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('getFlash')) {
    /**
     * Recupera e limpa mensagem flash
     */
    function getFlash(): ?array
    {
        $flash = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        return $flash;
    }
}

// ============================================
// URL
// ============================================

if (!function_exists('url')) {
    /**
     * Gera URL absoluta
     */
    function url(string $path = ''): string
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    /**
     * Gera URL para asset
     */
    function asset(string $path): string
    {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        return $baseUrl . '/public/assets/' . ltrim($path, '/');
    }
}

// ============================================
// VALIDAÇÃO
// ============================================

if (!function_exists('validateEmail')) {
    /**
     * Valida email
     */
    function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('validateRequired')) {
    /**
     * Valida campo obrigatório
     */
    function validateRequired($value): bool
    {
        return !empty(trim($value ?? ''));
    }
}

// ============================================
// UPLOAD
// ============================================

if (!function_exists('uploadFile')) {
    /**
     * Faz upload de arquivo
     */
    function uploadFile(array $file, string $destination = 'uploads'): ?string
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        if ($file['size'] > MAX_FILE_SIZE) {
            return null;
        }

        $uploadDir = PUBLIC_PATH . '/' . trim($destination, '/') . '/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $filepath = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return $destination . '/' . $filename;
        }

        return null;
    }
}

// ============================================
// PAGINAÇÃO
// ============================================

if (!function_exists('paginate')) {
    /**
     * Calcula valores de paginação
     */
    function paginate(int $total, int $perPage = ITEMS_PER_PAGE): array
    {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $totalPages = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        return [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'offset' => $offset,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages
        ];
    }
}

// ============================================
// CSRF
// ============================================

if (!function_exists('csrfToken')) {
    /**
     * Retorna token CSRF
     */
    function csrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }
}

if (!function_exists('csrfField')) {
    /**
     * Gera campo hidden com token CSRF
     */
    function csrfField(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
    }
}

if (!function_exists('verifyCsrf')) {
    /**
     * Verifica token CSRF
     */
    function verifyCsrf(): bool
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return hash_equals(csrfToken(), $token);
    }
}
PHP;
}

private function getAuthMiddleware(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Middleware;

class AuthMiddleware
{
    /**
     * Verifica se usuário está autenticado
     */
    public static function handle(): void
    {
        if (!isset($_SESSION['user_id'])) {
            flash('error', 'Você precisa estar autenticado para acessar esta página.');
            redirect('/login');
        }
    }

    /**
     * Verifica se usuário é admin
     */
    public static function isAdmin(): bool
    {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Redireciona se não for admin
     */
    public static function requireAdmin(): void
    {
        if (!self::isAdmin()) {
            flash('error', 'Acesso negado. Apenas administradores.');
            redirect('/');
        }
    }
}
PHP;
}

private function getCsrfMiddleware(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Middleware;

class CsrfMiddleware
{
    /**
     * Verifica token CSRF em requisições POST
     */
    public static function handle(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!verifyCsrf()) {
                http_response_code(419);
                die('Token CSRF inválido. Recarregue a página e tente novamente.');
            }
        }
    }

    /**
     * Gera novo token CSRF
     */
    public static function generateToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
PHP;
}


// ==========================================
// TEMPLATE AVANÇADO - MÉTODOS AUXILIARES PARTE 3
// Models e Controllers
// ==========================================

private function getUserModelAvancado(): string
{
    return <<<'PHP'
<?php

namespace App\Models;

use PDO;

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    /**
     * Lista usuários com paginação
     */
    public function paginate(int $offset = 0, int $limit = ITEMS_PER_PAGE): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM users ORDER BY id DESC LIMIT :offset, :limit"
        );
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Conta total de usuários
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Busca usuário por ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Cria usuário
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())"
        );
        return $stmt->execute([$data['name'], $data['email']]);
    }

    /**
     * Atualiza usuário
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );
        return $stmt->execute([$data['name'], $data['email'], $id]);
    }

    /**
     * Deleta usuário
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Verifica se email já existe
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn() > 0;
    }
}
PHP;
}

private function getProductModel(): string
{
    return <<<'PHP'
<?php

namespace App\Models;

use PDO;

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = db();
    }

    /**
     * Lista produtos com paginação
     */
    public function paginate(int $offset = 0, int $limit = ITEMS_PER_PAGE): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM products ORDER BY id DESC LIMIT :offset, :limit"
        );
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Conta total de produtos
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM products");
        return (int)$stmt->fetchColumn();
    }

    /**
     * Busca produto por ID
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Cria produto
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO products (name, description, price, image, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['price'],
            $data['image'] ?? null
        ]);
    }

    /**
     * Atualiza produto
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?"
        );
        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['price'],
            $data['image'] ?? null,
            $id
        ]);
    }

    /**
     * Deleta produto
     */
    public function delete(int $id): bool
    {
        // Buscar e deletar imagem se existir
        $product = $this->find($id);
        if ($product && $product['image']) {
            $imagePath = PUBLIC_PATH . '/' . $product['image'];
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }

        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
PHP;
}

private function getHomeControllerAvancado(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

class HomeController
{
    public function index(): void
    {
        $title = 'Template Avançado MVC - IPPLS';
        $content = PAGES_PATH . '/home.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function docs(): void
    {
        $title = 'Documentação - Template Avançado';
        $content = PAGES_PATH . '/docs.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function dashboard(): void
    {
        $title = 'Dashboard - Template Avançado';
        $content = PAGES_PATH . '/dashboard.php';
        require LAYOUTS_PATH . '/dashboard.php';
    }
}
PHP;
}

private function getUserControllerAvancado(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Lista usuários com paginação
     */
    public function index(): void
    {
        $total = $this->userModel->count();
        $pagination = paginate($total);
        $users = $this->userModel->paginate($pagination['offset'], $pagination['per_page']);

        $controller = $this;
        $title = 'Gestão de Usuários';
        $content = PAGES_PATH . '/users.php';
        require LAYOUTS_PATH . '/main.php';
    }

    /**
     * Cria usuário
     */
    public function create(): void
    {
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');

        // Validação
        if (!validateRequired($name) || !validateRequired($email)) {
            flash('error', 'Preencha todos os campos obrigatórios.');
            redirect('/users');
        }

        if (!validateEmail($email)) {
            flash('error', 'Email inválido.');
            redirect('/users');
        }

        if ($this->userModel->emailExists($email)) {
            flash('error', 'Este email já está cadastrado.');
            redirect('/users');
        }

        if ($this->userModel->create(['name' => $name, 'email' => $email])) {
            flash('success', 'Usuário criado com sucesso!');
        } else {
            flash('error', 'Erro ao criar usuário.');
        }

        redirect('/users');
    }

    /**
     * Edita usuário
     */
    public function edit(int $id): void
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            flash('error', 'Usuário não encontrado.');
            redirect('/users');
        }

        $controller = $this;
        $title = 'Editar Usuário';
        $content = PAGES_PATH . '/users.php';
        $editUser = $user;
        require LAYOUTS_PATH . '/main.php';
    }

    /**
     * Atualiza usuário
     */
    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $name = clean($_POST['name'] ?? '');
        $email = clean($_POST['email'] ?? '');

        if ($id <= 0) {
            flash('error', 'ID inválido.');
            redirect('/users');
        }

        if (!validateRequired($name) || !validateRequired($email)) {
            flash('error', 'Preencha todos os campos.');
            redirect("/users/edit/{$id}");
        }

        if (!validateEmail($email)) {
            flash('error', 'Email inválido.');
            redirect("/users/edit/{$id}");
        }

        if ($this->userModel->emailExists($email, $id)) {
            flash('error', 'Este email já está cadastrado.');
            redirect("/users/edit/{$id}");
        }

        if ($this->userModel->update($id, ['name' => $name, 'email' => $email])) {
            flash('success', 'Usuário atualizado com sucesso!');
        } else {
            flash('error', 'Erro ao atualizar usuário.');
        }

        redirect('/users');
    }

    /**
     * Deleta usuário
     */
    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash('error', 'ID inválido.');
            redirect('/users');
        }

        if ($this->userModel->delete($id)) {
            flash('success', 'Usuário deletado com sucesso!');
        } else {
            flash('error', 'Erro ao deletar usuário.');
        }

        redirect('/users');
    }
}
PHP;
}

private function getAuthController(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

class AuthController
{
    public function showLogin(): void
    {
        $title = 'Login - Template Avançado';
        require PAGES_PATH . '/auth/login.php';
    }

    public function showRegister(): void
    {
        $title = 'Registro - Template Avançado';
        require PAGES_PATH . '/auth/register.php';
    }

    public function login(): void
    {
        // Implementar lógica de login real
        $email = clean($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Exemplo básico - implementar validação real
        if ($email && $password) {
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Usuário Teste';
            $_SESSION['user_email'] = $email;
            flash('success', 'Login realizado com sucesso!');
            redirect('/dashboard');
        } else {
            flash('error', 'Credenciais inválidas.');
            redirect('/login');
        }
    }

    public function register(): void
    {
        // Implementar lógica de registro
        flash('success', 'Registro realizado com sucesso!');
        redirect('/login');
    }

    public function logout(): void
    {
        session_destroy();
        redirect('/login');
    }
}
PHP;
}

private function getProductController(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $total = $this->productModel->count();
        $pagination = paginate($total);
        $products = $this->productModel->paginate($pagination['offset'], $pagination['per_page']);

        $controller = $this;
        $title = 'Gestão de Produtos';
        $content = PAGES_PATH . '/products.php';
        require LAYOUTS_PATH . '/main.php';
    }

    public function create(): void
    {
        $name = clean($_POST['name'] ?? '');
        $description = clean($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);

        if (!validateRequired($name) || $price <= 0) {
            flash('error', 'Preencha todos os campos obrigatórios.');
            redirect('/products');
        }

        // Upload de imagem (se houver)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = uploadFile($_FILES['image'], 'uploads/products');
        }

        if ($this->productModel->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image
        ])) {
            flash('success', 'Produto criado com sucesso!');
        } else {
            flash('error', 'Erro ao criar produto.');
        }

        redirect('/products');
    }

    public function update(): void
    {
        // Similar ao create, implementar atualização
        flash('success', 'Produto atualizado com sucesso!');
        redirect('/products');
    }

    public function delete(): void
    {
        $id = (int)($_POST['id'] ?? 0);

        if ($this->productModel->delete($id)) {
            flash('success', 'Produto deletado com sucesso!');
        } else {
            flash('error', 'Erro ao deletar produto.');
        }

        redirect('/products');
    }
}
PHP;
}

private function getApiController(): string
{
    return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;

class ApiController
{
    /**
     * GET /api/users
     */
    public function getUsers(): void
    {
        $userModel = new User();
        $users = $userModel->paginate(0, 100);

        echo json_encode([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * GET /api/users/{id}
     */
    public function getUser(int $id): void
    {
        $userModel = new User();
        $user = $userModel->find($id);

        if ($user) {
            echo json_encode([
                'success' => true,
                'data' => $user
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Usuário não encontrado'
            ]);
        }
    }

    /**
     * POST /api/users
     */
    public function createUser(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userModel = new User();

        if ($userModel->create($data)) {
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Usuário criado com sucesso'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao criar usuário'
            ]);
        }
    }

    /**
     * PUT /api/users/{id}
     */
    public function updateUser(int $id): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $userModel = new User();

        if ($userModel->update($id, $data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuário atualizado'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao atualizar'
            ]);
        }
    }

    /**
     * DELETE /api/users/{id}
     */
    public function deleteUser(int $id): void
    {
        $userModel = new User();

        if ($userModel->delete($id)) {
            echo json_encode([
                'success' => true,
                'message' => 'Usuário deletado'
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Erro ao deletar'
            ]);
        }
    }

    /**
     * GET /api/products
     */
    public function getProducts(): void
    {
        $productModel = new Product();
        $products = $productModel->paginate(0, 100);

        echo json_encode([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * GET /api/products/{id}
     */
    public function getProduct(int $id): void
    {
        $productModel = new Product();
        $product = $productModel->find($id);

        if ($product) {
            echo json_encode([
                'success' => true,
                'data' => $product
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Produto não encontrado'
            ]);
        }
    }
}
PHP;
}


// ==========================================
// TEMPLATE AVANÇADO - MÉTODOS AUXILIARES FINAIS
// Views, Components, Assets, README
// ==========================================

// ========== VIEWS - LAYOUTS ==========

private function getMainLayoutAvancado(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'IPPLS Template Avançado' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
    <?php require COMPONENTS_PATH . '/navbar.php'; ?>
    <?php require $content; ?>
    <?php require COMPONENTS_PATH . '/footer.php'; ?>
    <script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>
HTML;
}

private function getDashboardLayout(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
    <?php require COMPONENTS_PATH . '/navbar.php'; ?>
    <div class="dashboard-wrapper">
        <?php require $content; ?>
    </div>
    <?php require COMPONENTS_PATH . '/footer.php'; ?>
</body>
</html>
HTML;
}

// ========== VIEWS - PAGES ==========

private function getHomeViewAvancado(): string
{
    return <<<'HTML'
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="welcome-container">
                    <span class="welcome-icon">👋</span>
                    <span class="welcome-text">Bem-vindo ao Template Avançado</span>
                </div>
                <h1 class="hero-title">
                    Template <span class="hero-title-highlight">AVANÇADO</span>
                </h1>
                <p class="hero-subtitle">
                    URLs amigáveis, middleware, upload, paginação e API REST. Evolução natural do Template Padrão.
                </p>
                <div class="hero-buttons">
                    <a href="<?= url('/users') ?>" class="btn-hero btn-hero-primary">
                        <i class="fas fa-users"></i> Gestão de Usuários
                    </a>
                    <a href="<?= url('/docs') ?>" class="btn-hero btn-hero-secondary">
                        <i class="fas fa-book"></i> Documentação
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="decoration-block-top">
                    <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="logo">
                </div>
                <div class="feature-card">
                    <h2 class="feature-card-title">Profissional. Moderno. Prático.</h2>
                    <p class="feature-card-subtitle">IPPLS - Instituto Politécnico</p>
                </div>
                <div class="decoration-block-bottom">
                    <img src="<?= asset('images/logo/ippls-logo-removebg-preview.png') ?>" alt="IPPLS" class="logo">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <h2 class="section-title">Recursos Avançados</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-link fa-3x"></i>
                <h3>URLs Amigáveis</h3>
                <p>/users em vez de ?page=users</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-shield-alt fa-3x"></i>
                <h3>Middleware</h3>
                <p>Auth, CSRF e segurança</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-upload fa-3x"></i>
                <h3>Upload de Arquivos</h3>
                <p>Imagens e documentos</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-list-ol fa-3x"></i>
                <h3>Paginação</h3>
                <p>Navegação automática</p>
            </div>
        </div>
    </div>
</section>
HTML;
}

private function getUsersViewAvancado(): string
{
    return <<<'PHP'
<div class="main-container">
    <?php require COMPONENTS_PATH . '/breadcrumbs.php'; ?>

    <?php $flash = getFlash(); if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <i class="fas <?= $flash['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i>
            <span><?= e($flash['message']) ?></span>
        </div>
    <?php endif; ?>

    <div class="page-header">
        <h1><i class="fas fa-users"></i> Gestão de Usuários</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><?= isset($editUser) ? 'Editar Usuário' : 'Novo Usuário' ?></h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= isset($editUser) ? url('/users/update') : url('/users/create') ?>">
                <?= csrfField() ?>
                <?php if (isset($editUser)): ?>
                    <input type="hidden" name="id" value="<?= $editUser['id'] ?>">
                <?php endif; ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" class="form-input"
                               value="<?= e($editUser['name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" class="form-input"
                               value="<?= e($editUser['email'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?= isset($editUser) ? 'Atualizar' : 'Criar' ?>
                    </button>
                    <?php if (isset($editUser)): ?>
                        <a href="<?= url('/users') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Usuários Cadastrados</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><strong>#<?= $user['id'] ?></strong></td>
                                    <td><?= e($user['name']) ?></td>
                                    <td><?= e($user['email']) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= url("/users/edit/{$user['id']}") ?>" class="btn btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <form method="POST" action="<?= url('/users/delete') ?>" class="inline-form"
                                                  onsubmit="return confirm('Tem certeza?');">
                                                <?= csrfField() ?>
                                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i> Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php require COMPONENTS_PATH . '/pagination.php'; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x"></i>
                    <h3>Nenhum Usuário</h3>
                    <p>Crie o primeiro usuário usando o formulário acima.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
PHP;
}

private function getProductsView(): string
{
    return <<<'PHP'
<div class="main-container">
    <?php require COMPONENTS_PATH . '/breadcrumbs.php'; ?>

    <div class="page-header">
        <h1><i class="fas fa-box"></i> Gestão de Produtos</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Novo Produto</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= url('/products/create') ?>" enctype="multipart/form-data">
                <?= csrfField() ?>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nome *</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Preço *</label>
                        <input type="number" id="price" name="price" class="form-input" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <textarea id="description" name="description" class="form-input" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem</label>
                        <input type="file" id="image" name="image" class="form-input" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Criar Produto
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Produtos Cadastrados</h2>
        </div>
        <div class="card-body">
            <p>Implementar listagem de produtos...</p>
        </div>
    </div>
</div>
PHP;
}

private function getDocsViewAvancado(): string
{
    return $this->getDocsViewsPadrao(); // Reutilizar do Template Padrão
}

private function getDashboardView(): string
{
    return <<<'HTML'
<div class="dashboard-container">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>Usuários</h3>
                <p class="stat-number">150</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-info">
                <h3>Produtos</h3>
                <p class="stat-number">42</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-info">
                <h3>Pedidos</h3>
                <p class="stat-number">28</p>
            </div>
        </div>
    </div>
</div>
HTML;
}

private function getLoginView(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Template Avançado</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-sign-in-alt"></i> Login</h1>
                <p>Entre com suas credenciais</p>
            </div>

            <form method="POST" action="<?= url('/auth/login') ?>">
                <?= csrfField() ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </button>
            </form>

            <p class="auth-footer">
                Não tem conta? <a href="<?= url('/register') ?>">Registre-se</a>
            </p>
        </div>
    </div>
</body>
</html>
HTML;
}

private function getRegisterView(): string
{
    return <<<'HTML'
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Template Avançado</title>
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="stylesheet" href="<?= url('vendor/fontawesome/css/all.min.css') ?>">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1><i class="fas fa-user-plus"></i> Registro</h1>
                <p>Crie sua conta</p>
            </div>

            <form method="POST" action="<?= url('/auth/register') ?>">
                <?= csrfField() ?>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-user-plus"></i> Registrar
                </button>
            </form>

            <p class="auth-footer">
                Já tem conta? <a href="<?= url('/login') ?>">Faça login</a>
            </p>
        </div>
    </div>
</body>
</html>
HTML;
}

// ========== COMPONENTS ==========

private function getNavbarAvancado(): string
{
    return $this->getNavbarPadrao(); // Reutilizar do Padrão
}

private function getFooterAvancado(): string
{
    return $this->getFooterPadrao(); // Reutilizar do Padrão
}

private function getBreadcrumbs(): string
{
    return <<<'PHP'
<nav class="breadcrumbs">
    <a href="<?= url('/') ?>"><i class="fas fa-home"></i> Início</a>
    <i class="fas fa-chevron-right"></i>
    <span><?= $title ?? 'Página' ?></span>
</nav>
PHP;
}

private function getPaginationComponent(): string
{
    return <<<'PHP'
<?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
    <div class="pagination">
        <?php if ($pagination['has_prev']): ?>
            <a href="?page=<?= $pagination['current_page'] - 1 ?>" class="pagination-link">
                <i class="fas fa-chevron-left"></i> Anterior
            </a>
        <?php endif; ?>

        <span class="pagination-info">
            Página <?= $pagination['current_page'] ?> de <?= $pagination['total_pages'] ?>
        </span>

        <?php if ($pagination['has_next']): ?>
            <a href="?page=<?= $pagination['current_page'] + 1 ?>" class="pagination-link">
                Próxima <i class="fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
PHP;
}

// ========== ERRORS ==========

private function get404Avancado(): string
{
    return $this->get404Padrao(); // Reutilizar
}

private function get500Avancado(): string
{
    return $this->get500Padrao(); // Reutilizar
}

// ========== CSS ==========

private function getStyleCssAvancado(): string
{
    return <<<'CSS'
@import 'base.css';
@import 'components/navbar.css';
@import 'components/buttons.css';
@import 'components/forms.css';
@import 'components/cards.css';
@import 'components/tables.css';
@import 'components/alerts.css';
@import 'components/pagination.css';
@import 'components/breadcrumbs.css';
@import 'sections/hero.css';
@import 'sections/footer.css';
@import 'sections/dashboard.css';
CSS;
}

private function getBaseCssAvancado(): string
{
    return $this->getBaseCssPadrao(); // Reutilizar
}

private function getPaginationCss(): string
{
    return <<<'CSS'
.pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--gray-800);
    border-radius: 0.5rem;
    margin-top: 1rem;
}

.pagination-link {
    padding: 0.5rem 1rem;
    background: var(--ippls-gold);
    color: var(--ippls-blue-dark);
    text-decoration: none;
    border-radius: 0.25rem;
    font-weight: 600;
    transition: all 0.3s;
}

.pagination-link:hover {
    background: var(--ippls-gold-dark);
    transform: translateY(-2px);
}

.pagination-info {
    color: var(--gray-400);
    font-size: 0.875rem;
}
CSS;
}

private function getBreadcrumbsCss(): string
{
    return <<<'CSS'
.breadcrumbs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 0;
    font-size: 0.875rem;
    color: var(--gray-400);
}

.breadcrumbs a {
    color: var(--ippls-gold);
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumbs a:hover {
    color: var(--ippls-gold-dark);
}

.breadcrumbs i {
    font-size: 0.75rem;
}
CSS;
}

private function getDashboardCss(): string
{
    return <<<'CSS'
.dashboard-container {
    max-width: 1400px;
    margin: 2rem auto;
    padding: 0 1.25rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.stat-card {
    background: var(--gray-900);
    padding: 1.5rem;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-left: 4px solid var(--ippls-gold);
}

.stat-icon {
    font-size: 2.5rem;
    color: var(--ippls-gold);
}

.stat-info h3 {
    font-size: 0.875rem;
    color: var(--gray-400);
    margin: 0;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin: 0;
}
CSS;
}

// ========== JS ==========

private function getMainJsAvancado(): string
{
    return $this->getMainJs(); // Reutilizar
}

private function getUploadJs(): string
{
    return <<<'JS'
document.addEventListener('DOMContentLoaded', function() {
    const fileInputs = document.querySelectorAll('input[type="file"]');

    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                console.log('Arquivo selecionado:', file.name);
                // Preview de imagem (opcional)
                if (file.type.startsWith('image/')) {
                    // Implementar preview
                }
            }
        });
    });
});
JS;
}

private function getApiJs(): string
{
    return <<<'JS'
const API = {
    async getUsers() {
        const response = await fetch('/api/users');
        return response.json();
    },

    async createUser(data) {
        const response = await fetch('/api/users', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return response.json();
    }
};

// Exemplo de uso:
// API.getUsers().then(data => console.log(data));
JS;
}

// ========== README ==========

private function getReadmeAvancado(): string
{
    return <<<'MD'
# Template Avançado MVC - IPPLS

Evolução do Template Padrão com URLs amigáveis, middleware, upload de arquivos, paginação e API REST.

## 🚀 Características

- ✅ **URLs Amigáveis**: `/users` em vez de `?page=users`
- ✅ **Middleware**: Autenticação e CSRF
- ✅ **Upload de Arquivos**: Validação e armazenamento
- ✅ **Paginação**: Navegação automática de dados
- ✅ **API REST**: Endpoints JSON para integração
- ✅ **Múltiplos CRUDs**: Users, Products, etc.

## 📋 Requisitos

- PHP >= 8.0
- Composer >= 2.0
- MySQL >= 5.7
- Apache com mod_rewrite

## 🔧 Instalação

1. **Instalar dependências:**
```bash
composer install
```

2. **Criar banco de dados:**
```sql
CREATE DATABASE projeto_avancado;
USE projeto_avancado;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. **Configurar banco:**
```php
// app/config/database.php
DB_HOST = 'localhost';
DB_NAME = 'projeto_avancado';
DB_USER = 'root';
DB_PASS = '';
```

4. **Acessar:**
```
http://localhost/projeto_avancado
```

## 📚 URLs Disponíveis

### Web
- `/` - Home
- `/users` - CRUD de usuários
- `/products` - CRUD de produtos
- `/docs` - Documentação
- `/dashboard` - Dashboard (protegido)
- `/login` - Login
- `/register` - Registro

### API
- `GET /api/users` - Listar usuários
- `GET /api/users/{id}` - Buscar usuário
- `POST /api/users` - Criar usuário
- `PUT /api/users/{id}` - Atualizar usuário
- `DELETE /api/users/{id}` - Deletar usuário

## 🎯 Progressão dos Templates

| Recurso | Base | Padrão | **Avançado** |
|---------|------|--------|--------------|
| URLs Amigáveis | ❌ | ❌ | ✅ |
| Middleware | ❌ | ❌ | ✅ |
| Upload | ❌ | ❌ | ✅ |
| Paginação | ❌ | ❌ | ✅ |
| API REST | ❌ | ❌ | ✅ |

---

**Desenvolvido com ❤️ para o IPPLS**
MD;
}

private function getInstrucoesAvancado(): string
{
    return "# Guia de Instalação - Template Avançado\n\n## 1. Instalar Composer\n## 2. Criar Banco de Dados\n## 3. Configurar Conexão\n## 4. Acessar URLs Amigáveis\n## 5. Explorar API REST";
}


}
