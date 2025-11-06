<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Projeto;
use App\Models\InstanciaProjeto;
use App\Models\TemplateArquitetura;
use App\Models\Notificacao;

class DadosExemploSeeder extends Seeder
{
    public function run(): void
    {
        // Criar Curso Principal (conforme especificação do projeto)
        $cursoGRSI = Curso::create([
            'nome' => 'Gestão de Redes e Sistemas Informáticos',
            'codigo' => 'GRSI',
            'descricao' => 'Curso técnico superior focado na gestão de redes informáticas e sistemas',
            'ativo' => true
        ]);

        // Criar Turmas do curso GRSI
        $turmaGRSI3A = Turma::create([
            'nome' => 'GRSI-3A',
            'periodo' => 'Manhã',
            'curso_id' => $cursoGRSI->id,
            'ano_letivo' => 2025,
            'ativo' => true
        ]);

        $turmaGRSI3B = Turma::create([
            'nome' => 'GRSI-3B',
            'periodo' => 'Tarde',
            'curso_id' => $cursoGRSI->id,
            'ano_letivo' => 2025,
            'ativo' => true
        ]);

        $turmaGRSI2A = Turma::create([
            'nome' => 'GRSI-2A',
            'periodo' => 'Manhã',
            'curso_id' => $cursoGRSI->id,
            'ano_letivo' => 2025,
            'ativo' => true
        ]);

        // Criar Coordenador
        $coordenador = User::create([
            'name' => 'Dr. António Coordenador',
            'email' => 'coordenador@ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'coordenador',
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        // Criar Professores/Avaliadores
        $professor1 = User::create([
            'name' => 'Prof. Maria Fernandes',
            'email' => 'maria.fernandes@ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'professor',
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        $professor2 = User::create([
            'name' => 'Prof. João Santos',
            'email' => 'joao.santos@ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'professor',
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        // Criar Estudantes do curso GRSI
        $estudante1 = User::create([
            'name' => 'Ana Domingos',
            'email' => 'ana.domingos@student.ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'estudante',
            'telefone_encarregado' => '+244 923 456 789',
            'numero_estudante' => '2023001',
            'curso_id' => $cursoGRSI->id,
            'turma_id' => $turmaGRSI3A->id,
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        $estudante2 = User::create([
            'name' => 'Carlos Mendes',
            'email' => 'carlos.mendes@student.ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'estudante',
            'telefone_encarregado' => '+244 912 345 678',
            'numero_estudante' => '2023002',
            'curso_id' => $cursoGRSI->id,
            'turma_id' => $turmaGRSI3A->id,
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        $estudante3 = User::create([
            'name' => 'Sofia Pereira',
            'email' => 'sofia.pereira@student.ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'estudante',
            'telefone_encarregado' => '+244 934 567 890',
            'numero_estudante' => '2023003',
            'curso_id' => $cursoGRSI->id,
            'turma_id' => $turmaGRSI3B->id,
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        $estudante4 = User::create([
            'name' => 'Miguel Cardoso',
            'email' => 'miguel.cardoso@student.ippls.edu.ao',
            'password' => Hash::make('password'),
            'tipo' => 'estudante',
            'telefone_encarregado' => '+244 945 678 901',
            'numero_estudante' => '2024001',
            'curso_id' => $cursoGRSI->id,
            'turma_id' => $turmaGRSI2A->id,
            'ativo' => true,
            'email_verified_at' => now()
        ]);

        // Criar Templates de Arquitetura (conforme especificação)
        $templateBase = TemplateArquitetura::create([
            'nome' => 'Arquitetura Base - MVC Básico',
            'nivel' => 'base',
            'descricao' => 'Estrutura MVC básica com organização fundamental de diretórios (models, views, controllers)',
            'estrutura_diretorios' => json_encode([
                'projeto_base/' => [
                    'index.php',
                    'config/' => ['database.php'],
                    'models/',
                    'views/',
                    'controllers/',
                    'assets/' => ['css/', 'js/', 'images/'],
                    'README.md'
                ]
            ]),
            'arquivos_base' => json_encode(['index.php', 'config/database.php', 'README.md']),
            'instrucoes_uso' => 'Template básico para projetos MVC iniciantes. Configure a base de dados em config/database.php.',
            'ativo' => true
        ]);

        $templatePadrao = TemplateArquitetura::create([
            'nome' => 'Arquitetura Padrão - MVC Intermediário',
            'nivel' => 'padrao',
            'descricao' => 'Estrutura MVC intermediária com helpers, configurações avançadas e separação de camadas',
            'estrutura_diretorios' => json_encode([
                'projeto_padrao/' => [
                    'index.php',
                    'config/' => ['database.php', 'app.php'],
                    'app/' => ['models/', 'views/', 'controllers/', 'helpers/'],
                    'public/' => ['css/', 'js/', 'assets/'],
                    'storage/',
                    'vendor/'
                ]
            ]),
            'arquivos_base' => json_encode(['index.php', 'config/database.php', 'config/app.php']),
            'instrucoes_uso' => 'Template intermediário com estrutura organizada. Use o autoloader para classes.',
            'ativo' => true
        ]);

        $templateAvancado = TemplateArquitetura::create([
            'nome' => 'Arquitetura Avançada - MVC Completo',
            'nivel' => 'avancado',
            'descricao' => 'Estrutura MVC completa com middleware, services, testes e configuração para Docker',
            'estrutura_diretorios' => json_encode([
                'projeto_avancado/' => [
                    'index.php',
                    'config/',
                    'app/' => ['Core/', 'Models/', 'Views/', 'Controllers/', 'Middleware/', 'Services/'],
                    'public/',
                    'storage/',
                    'tests/',
                    'vendor/',
                    'docker/'
                ]
            ]),
            'arquivos_base' => json_encode(['index.php', 'composer.json', 'Dockerfile']),
            'dependencias' => json_encode(['PHP 8.0+', 'Composer', 'MySQL/PostgreSQL']),
            'instrucoes_uso' => 'Template avançado com arquitetura robusta. Use composer install para dependências.',
            'ativo' => true
        ]);

        // Criar Projetos (relacionados com GRSI)
        $projeto1 = Projeto::create([
            'titulo' => 'Sistema de Gestão de Rede Escolar',
            'descricao' => 'Desenvolver um sistema web para gestão e monitoramento da rede informática do IPPLS, incluindo inventário de equipamentos, controle de acesso e relatórios de performance.',
            'categoria' => 'Gestão de Redes',
            'nivel_dificuldade' => 'avancado',
            'tecnologias' => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap', 'SNMP'],
            'requisitos' => 'Conhecimentos de redes, protocolos TCP/IP, PHP e bases de dados',
            'duracao_estimada' => 45,
            'status' => 'ativo',
            'criado_por' => $professor1->id
        ]);

        $projeto2 = Projeto::create([
            'titulo' => 'Portal de Serviços TI',
            'descricao' => 'Criar um portal web para solicitação e acompanhamento de serviços de TI, com sistema de tickets e gestão de utilizadores.',
            'categoria' => 'Sistemas Informáticos',
            'nivel_dificuldade' => 'padrao',
            'tecnologias' => ['PHP', 'MySQL', 'CSS3', 'JavaScript'],
            'requisitos' => 'Conhecimentos de programação web, bases de dados e UX/UI',
            'duracao_estimada' => 30,
            'status' => 'ativo',
            'criado_por' => $professor1->id
        ]);

        $projeto3 = Projeto::create([
            'titulo' => 'Aplicação de Monitoramento de Servidor',
            'descricao' => 'Desenvolver uma aplicação web para monitoramento em tempo real de servidores, com alertas e dashboards.',
            'categoria' => 'Administração de Sistemas',
            'nivel_dificuldade' => 'avancado',
            'tecnologias' => ['PHP', 'MySQL', 'Chart.js', 'WebSocket', 'Linux'],
            'requisitos' => 'Conhecimentos de administração de sistemas Linux, programação web e APIs',
            'duracao_estimada' => 40,
            'status' => 'ativo',
            'criado_por' => $professor2->id
        ]);

        $projeto4 = Projeto::create([
            'titulo' => 'Sistema de Backup Automatizado',
            'descricao' => 'Criar um sistema web para gestão e monitoramento de backups automatizados com notificações.',
            'categoria' => 'Gestão de Dados',
            'nivel_dificuldade' => 'base',
            'tecnologias' => ['PHP', 'MySQL', 'Shell Script', 'HTML5', 'CSS3'],
            'requisitos' => 'Conhecimentos básicos de programação e sistemas operativos',
            'duracao_estimada' => 25,
            'status' => 'ativo',
            'criado_por' => $professor2->id
        ]);

        // Criar Instâncias de Projeto
        $instancia1 = InstanciaProjeto::create([
            'projeto_id' => $projeto1->id,
            'usuario_id' => $estudante1->id,
            'nivel_arquitetura' => 'avancado',
            'percentual_conclusao' => 75,
            'status' => 'em_desenvolvimento',
            'data_inicio' => now()->subDays(20),
            'observacoes' => 'Desenvolvimento progredindo bem. Sistema de inventário concluído, trabalhando nos relatórios.',
            'repositorio_url' => 'https://github.com/ana-domingos/gestao-rede-ippls'
        ]);

        $instancia2 = InstanciaProjeto::create([
            'projeto_id' => $projeto2->id,
            'usuario_id' => $estudante2->id,
            'nivel_arquitetura' => 'padrao',
            'percentual_conclusao' => 50,
            'status' => 'em_desenvolvimento',
            'data_inicio' => now()->subDays(15),
            'observacoes' => 'Sistema de tickets implementado, desenvolvendo interface de gestão.',
            'repositorio_url' => 'https://github.com/carlos-mendes/portal-servicos-ti'
        ]);

        $instancia3 = InstanciaProjeto::create([
            'projeto_id' => $projeto4->id,
            'usuario_id' => $estudante3->id,
            'nivel_arquitetura' => 'base',
            'percentual_conclusao' => 90,
            'status' => 'em_desenvolvimento',
            'data_inicio' => now()->subDays(25),
            'observacoes' => 'Quase concluído. Sistema de backup funcionando, finalizando interface web.',
            'repositorio_url' => 'https://github.com/sofia-pereira/backup-system'
        ]);

        $instancia4 = InstanciaProjeto::create([
            'projeto_id' => $projeto2->id,
            'usuario_id' => $estudante4->id,
            'nivel_arquitetura' => 'base',
            'percentual_conclusao' => 25,
            'status' => 'iniciado',
            'data_inicio' => now()->subDays(10),
            'observacoes' => 'Projeto recém iniciado. Configurando ambiente de desenvolvimento.',
            'repositorio_url' => 'https://github.com/miguel-cardoso/portal-ti-ippls'
        ]);

        // Criar Notificações
        Notificacao::create([
            'usuario_id' => $estudante1->id,
            'titulo' => 'Progresso Excelente!',
            'mensagem' => 'Seu projeto "Sistema de Gestão de Rede Escolar" está com 75% de conclusão. Continue o excelente trabalho!',
            'tipo' => 'sucesso',
            'lida' => false
        ]);

        Notificacao::create([
            'usuario_id' => $estudante2->id,
            'titulo' => 'Marco Atingido',
            'mensagem' => 'Parabéns! Você atingiu 50% de conclusão no projeto "Portal de Serviços TI".',
            'tipo' => 'info',
            'lida' => false
        ]);

        Notificacao::create([
            'usuario_id' => $estudante3->id,
            'titulo' => 'Projeto Quase Concluído',
            'mensagem' => 'Seu projeto "Sistema de Backup Automatizado" está 90% concluído. Prepare-se para a avaliação final!',
            'tipo' => 'aviso',
            'lida' => false
        ]);

        Notificacao::create([
            'usuario_id' => $estudante4->id,
            'titulo' => 'Bem-vindo ao Projeto',
            'mensagem' => 'Você iniciou o projeto "Portal de Serviços TI". Lembre-se de consultar os templates disponíveis.',
            'tipo' => 'info',
            'lida' => false
        ]);

        $this->command->info('✅ Dados do IPPLS criados com sucesso!');
        $this->command->line('');
        $this->command->line('🏫 <fg=yellow>Instituto Politécnico Privado Lucrêcio dos Santos</>');
        $this->command->line('📚 <fg=cyan>Curso: Gestão de Redes e Sistemas Informáticos</>');
        $this->command->line('');
        $this->command->line('🔑 <fg=yellow>Credenciais de acesso:</>');
        $this->command->line('');
        $this->command->line('👨‍💼 <fg=cyan>Coordenador:</>');
        $this->command->line('   Email: coordenador@ippls.edu.ao');
        $this->command->line('   Senha: password');
        $this->command->line('');
        $this->command->line('👩‍🏫 <fg=green>Professores:</>');
        $this->command->line('   Email: maria.fernandes@ippls.edu.ao | Senha: password');
        $this->command->line('   Email: joao.santos@ippls.edu.ao | Senha: password');
        $this->command->line('');
        $this->command->line('👨‍🎓 <fg=blue>Estudantes:</>');
        $this->command->line('   Email: ana.domingos@student.ippls.edu.ao | Senha: password');
        $this->command->line('   Email: carlos.mendes@student.ippls.edu.ao | Senha: password');
        $this->command->line('   Email: sofia.pereira@student.ippls.edu.ao | Senha: password');
        $this->command->line('   Email: miguel.cardoso@student.ippls.edu.ao | Senha: password');
        $this->command->line('');
        $this->command->line('📊 <fg=magenta>Templates Disponíveis:</>');
        $this->command->line('   • Arquitetura Base (Iniciantes)');
        $this->command->line('   • Arquitetura Padrão (Intermediário)');
        $this->command->line('   • Arquitetura Avançada (Avançado)');
    }
}