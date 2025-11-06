declare namespace App {
  // User.ts
  interface User {
    id: number;
    name: string;
    email: string;
    tipo: 'estudante' | 'professor' | 'coordenador';
    curso?: Curso;
    turma?: Turma;
    ativo: boolean;
  }

  // Projeto.ts
  interface Projeto {
    id: number;
    titulo: string;
    descricao: string;
    imagem?: string;
    categoria: string;
    nivel_dificuldade: 'base' | 'padrao' | 'avancado';
    tecnologias: string[];
    criador: User;
    status: string;
  }

  // InstanciaProjeto.ts
  interface InstanciaProjeto {
    id: number;
    projeto: Projeto;
    usuario: User;
    nivel_arquitetura: string;
    percentual_conclusao: number;
    status: 'iniciado' | 'em_desenvolvimento' | 'concluido' | 'abandonado';
    avaliacoes?: Avaliacao[];
    avaliacaoAtual?: Avaliacao;
  }

  // Avaliacao.ts
  interface Avaliacao {
    id: number;
    nota: number;
    comentarios: string;
    criterios_avaliacao: Record<string, number>;
    status: 'pendente' | 'em_avaliacao' | 'avaliado';
    instanciaProjeto: InstanciaProjeto;
    avaliador: User;
    //getStatusBadgeClass: string;
  }

  // Notificacao.ts
  interface Notificacao {
    id: number;
    titulo: string;
    mensagem: string;
    tipo: 'info' | 'sucesso' | 'aviso' | 'erro';
    lida: boolean;
    acao_url?: string;
  }

  // TemplateArquitetura.ts
  interface TemplateArquitetura {
    id: number;
    nome: string;
    nivel: string;
    estrutura_diretorios: DiretorioItem[];
    arquivos_base: ArquivoTemplate[];
    ativo: boolean;
  }

  interface DiretorioItem {
    nome: string;
    tipo: 'pasta' | 'arquivo';
    filhos?: DiretorioItem[];
  }

  interface ArquivoTemplate {
    caminho: string;
    template: string;
  }
}
