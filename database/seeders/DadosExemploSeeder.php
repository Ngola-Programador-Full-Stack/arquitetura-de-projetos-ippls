<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Curso;
use App\Models\Turma;
use App\Models\Projeto;
use App\Models\InstanciaProjeto;
use App\Models\Notificacao;

class DadosExemploSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🔄 Verificando e criando dados de exemplo...');

        // ✅ Criar ou atualizar Curso Principal (codigo é único)
        $cursoGRSI = Curso::updateOrCreate(
            ['codigo' => 'GRSI'], // Campo único para busca
            [
                'nome' => 'Gestão de Redes e Sistemas Informáticos',
                'descricao' => 'Curso técnico superior focado na gestão de redes informáticas e sistemas',
                'ativo' => true
            ]
        );
        $this->command->line('  ✓ Curso GRSI verificado/criado');

        // ✅ Criar ou atualizar Turmas do curso GRSI
        $turmaGRSI3A = Turma::firstOrCreate(
            [
                'nome' => 'GRSI-3A',
                'curso_id' => $cursoGRSI->id,
                'ano_letivo' => 2025
            ],
            [
                'periodo' => 'Manhã',
                'ativo' => true
            ]
        );

        $turmaGRSI3B = Turma::firstOrCreate(
            [
                'nome' => 'GRSI-3B',
                'curso_id' => $cursoGRSI->id,
                'ano_letivo' => 2025
            ],
            [
                'periodo' => 'Tarde',
                'ativo' => true
            ]
        );

        $turmaGRSI2A = Turma::firstOrCreate(
            [
                'nome' => 'GRSI-2A',
                'curso_id' => $cursoGRSI->id,
                'ano_letivo' => 2025
            ],
            [
                'periodo' => 'Manhã',
                'ativo' => true
            ]
        );
        $this->command->line('  ✓ Turmas verificadas/criadas');

        // ✅ Criar ou atualizar Coordenador (email é único)
        $coordenador = User::updateOrCreate(
            ['email' => 'coordenador@ippls.edu.ao'],
            [
                'name' => 'Dr. António Coordenador',
                'password' => Hash::make('password'),
                'tipo' => 'coordenador',
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );

        // ✅ Criar ou atualizar Professores/Avaliadores (email é único)
        $professor1 = User::updateOrCreate(
            ['email' => 'maria.fernandes@ippls.edu.ao'],
            [
                'name' => 'Prof. Maria Fernandes',
                'password' => Hash::make('password'),
                'tipo' => 'professor',
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );

        $professor2 = User::updateOrCreate(
            ['email' => 'joao.santos@ippls.edu.ao'],
            [
                'name' => 'Prof. João Santos',
                'password' => Hash::make('password'),
                'tipo' => 'professor',
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );
        $this->command->line('  ✓ Coordenador e Professores verificados/criados');

        // ✅ Criar ou atualizar Estudantes do curso GRSI (email é único)
        $estudante1 = User::updateOrCreate(
            ['email' => 'ana.domingos@student.ippls.edu.ao'],
            [
                'name' => 'Ana Domingos',
                'password' => Hash::make('password'),
                'tipo' => 'estudante',
                'telefone_encarregado' => '+244 923 456 789',
                'numero_estudante' => '2023001',
                'curso_id' => $cursoGRSI->id,
                'turma_id' => $turmaGRSI3A->id,
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );

        $estudante2 = User::updateOrCreate(
            ['email' => 'carlos.mendes@student.ippls.edu.ao'],
            [
                'name' => 'Carlos Mendes',
                'password' => Hash::make('password'),
                'tipo' => 'estudante',
                'telefone_encarregado' => '+244 912 345 678',
                'numero_estudante' => '2023002',
                'curso_id' => $cursoGRSI->id,
                'turma_id' => $turmaGRSI3A->id,
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );

        $estudante3 = User::updateOrCreate(
            ['email' => 'sofia.pereira@student.ippls.edu.ao'],
            [
                'name' => 'Sofia Pereira',
                'password' => Hash::make('password'),
                'tipo' => 'estudante',
                'telefone_encarregado' => '+244 934 567 890',
                'numero_estudante' => '2023003',
                'curso_id' => $cursoGRSI->id,
                'turma_id' => $turmaGRSI3B->id,
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );

        $estudante4 = User::updateOrCreate(
            ['email' => 'miguel.cardoso@student.ippls.edu.ao'],
            [
                'name' => 'Miguel Cardoso',
                'password' => Hash::make('password'),
                'tipo' => 'estudante',
                'telefone_encarregado' => '+244 945 678 901',
                'numero_estudante' => '2024001',
                'curso_id' => $cursoGRSI->id,
                'turma_id' => $turmaGRSI2A->id,
                'ativo' => true,
                'email_verified_at' => now()
            ]
        );
        $this->command->line('  ✓ Estudantes verificados/criados');

        // ✅ Templates de Arquitetura são criados pelo TemplateArquiteturaSeeder
        // (chamado antes deste seeder no DatabaseSeeder)

        // ✅ Criar ou atualizar Projetos (relacionados com GRSI) - usando titulo como identificador
        $projeto1 = Projeto::updateOrCreate(
            ['titulo' => 'Sistema de Gestão de Rede Escolar'],
            [
                'descricao' => 'Desenvolver um sistema web para gestão e monitoramento da rede informática do IPPLS, incluindo inventário de equipamentos, controle de acesso e relatórios de performance.',
                'categoria' => 'Gestão de Redes',
                'nivel_dificuldade' => 'avancado',
                'tecnologias' => ['PHP', 'MySQL', 'JavaScript', 'Bootstrap', 'SNMP'],
                'requisitos' => 'Conhecimentos de redes, protocolos TCP/IP, PHP e bases de dados',
                'duracao_estimada' => 45,
                'status' => 'ativo',
                'criado_por' => $professor1->id
            ]
        );

        $projeto2 = Projeto::updateOrCreate(
            ['titulo' => 'Portal de Serviços TI'],
            [
                'descricao' => 'Criar um portal web para solicitação e acompanhamento de serviços de TI, com sistema de tickets e gestão de utilizadores.',
                'categoria' => 'Sistemas Informáticos',
                'nivel_dificuldade' => 'padrao',
                'tecnologias' => ['PHP', 'MySQL', 'CSS3', 'JavaScript'],
                'requisitos' => 'Conhecimentos de programação web, bases de dados e UX/UI',
                'duracao_estimada' => 30,
                'status' => 'ativo',
                'criado_por' => $professor1->id
            ]
        );

        $projeto3 = Projeto::updateOrCreate(
            ['titulo' => 'Aplicação de Monitoramento de Servidor'],
            [
                'descricao' => 'Desenvolver uma aplicação web para monitoramento em tempo real de servidores, com alertas e dashboards.',
                'categoria' => 'Administração de Sistemas',
                'nivel_dificuldade' => 'avancado',
                'tecnologias' => ['PHP', 'MySQL', 'Chart.js', 'WebSocket', 'Linux'],
                'requisitos' => 'Conhecimentos de administração de sistemas Linux, programação web e APIs',
                'duracao_estimada' => 40,
                'status' => 'ativo',
                'criado_por' => $professor2->id
            ]
        );

        $projeto4 = Projeto::updateOrCreate(
            ['titulo' => 'Sistema de Backup Automatizado'],
            [
                'descricao' => 'Criar um sistema web para gestão e monitoramento de backups automatizados com notificações.',
                'categoria' => 'Gestão de Dados',
                'nivel_dificuldade' => 'base',
                'tecnologias' => ['PHP', 'MySQL', 'Shell Script', 'HTML5', 'CSS3'],
                'requisitos' => 'Conhecimentos básicos de programação e sistemas operativos',
                'duracao_estimada' => 25,
                'status' => 'ativo',
                'criado_por' => $professor2->id
            ]
        );
        $this->command->line('  ✓ Projetos verificados/criados');

        // ✅ Criar ou atualizar Instâncias de Projeto (usando projeto_id + usuario_id como identificador)
        $instancia1 = InstanciaProjeto::updateOrCreate(
            [
                'projeto_id' => $projeto1->id,
                'usuario_id' => $estudante1->id
            ],
            [
                'nivel_arquitetura' => 'avancado',
                'percentual_conclusao' => 75,
                'status' => 'em_desenvolvimento',
                'data_inicio' => now()->subDays(20),
                'observacoes' => 'Desenvolvimento progredindo bem. Sistema de inventário concluído, trabalhando nos relatórios.',
                'repositorio_url' => 'https://github.com/ana-domingos/gestao-rede-ippls'
            ]
        );

        $instancia2 = InstanciaProjeto::updateOrCreate(
            [
                'projeto_id' => $projeto2->id,
                'usuario_id' => $estudante2->id
            ],
            [
                'nivel_arquitetura' => 'padrao',
                'percentual_conclusao' => 50,
                'status' => 'em_desenvolvimento',
                'data_inicio' => now()->subDays(15),
                'observacoes' => 'Sistema de tickets implementado, desenvolvendo interface de gestão.',
                'repositorio_url' => 'https://github.com/carlos-mendes/portal-servicos-ti'
            ]
        );

        $instancia3 = InstanciaProjeto::updateOrCreate(
            [
                'projeto_id' => $projeto4->id,
                'usuario_id' => $estudante3->id
            ],
            [
                'nivel_arquitetura' => 'base',
                'percentual_conclusao' => 90,
                'status' => 'em_desenvolvimento',
                'data_inicio' => now()->subDays(25),
                'observacoes' => 'Quase concluído. Sistema de backup funcionando, finalizando interface web.',
                'repositorio_url' => 'https://github.com/sofia-pereira/backup-system'
            ]
        );

        $instancia4 = InstanciaProjeto::updateOrCreate(
            [
                'projeto_id' => $projeto2->id,
                'usuario_id' => $estudante4->id
            ],
            [
                'nivel_arquitetura' => 'base',
                'percentual_conclusao' => 25,
                'status' => 'iniciado',
                'data_inicio' => now()->subDays(10),
                'observacoes' => 'Projeto recém iniciado. Configurando ambiente de desenvolvimento.',
                'repositorio_url' => 'https://github.com/miguel-cardoso/portal-ti-ippls'
            ]
        );
        $this->command->line('  ✓ Instâncias de projeto verificadas/criadas');

        // ✅ Criar Notificações (apenas se não existirem - evitar duplicação)
        $notificacoes = [
            [
                'usuario_id' => $estudante1->id,
                'titulo' => 'Progresso Excelente!',
                'mensagem' => 'Seu projeto "Sistema de Gestão de Rede Escolar" está com 75% de conclusão. Continue o excelente trabalho!',
                'tipo' => 'sucesso',
                'lida' => false
            ],
            [
                'usuario_id' => $estudante2->id,
                'titulo' => 'Marco Atingido',
                'mensagem' => 'Parabéns! Você atingiu 50% de conclusão no projeto "Portal de Serviços TI".',
                'tipo' => 'info',
                'lida' => false
            ],
            [
                'usuario_id' => $estudante3->id,
                'titulo' => 'Projeto Quase Concluído',
                'mensagem' => 'Seu projeto "Sistema de Backup Automatizado" está 90% concluído. Prepare-se para a avaliação final!',
                'tipo' => 'aviso',
                'lida' => false
            ],
            [
                'usuario_id' => $estudante4->id,
                'titulo' => 'Bem-vindo ao Projeto',
                'mensagem' => 'Você iniciou o projeto "Portal de Serviços TI". Lembre-se de consultar os templates disponíveis.',
                'tipo' => 'info',
                'lida' => false
            ]
        ];

        foreach ($notificacoes as $notificacao) {
            // Verificar se já existe notificação similar para evitar duplicação
            $existe = Notificacao::where('usuario_id', $notificacao['usuario_id'])
                ->where('titulo', $notificacao['titulo'])
                ->where('tipo', $notificacao['tipo'])
                ->first();

            if (!$existe) {
                Notificacao::create($notificacao);
            }
        }
        $this->command->line('  ✓ Notificações verificadas/criadas');

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
        $this->command->line('   • Template Base - MVC Simplificado (Iniciantes)');
        $this->command->line('   • Template Padrão - MVC Profissional (Intermediário)');
        $this->command->line('   • Template Avançado - Arquitetura Enterprise (Avançado)');
        $this->command->line('   <fg=gray>(Criados pelo TemplateArquiteturaSeeder)</>');
    }
}