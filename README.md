Sistema de Vistoria Pilkington
Este documento descreve a arquitetura, as funcionalidades e a configuração do sistema web de vistorias, desenvolvido para otimizar as operações de reparo e troca de vidros.

1. Visão Geral e Funcionalidades
   O sistema foi arquitetado focando na produtividade operacional, qualidade do serviço e experiência do cliente.

Dashboard Operacional: Apresenta KPIs em tempo real, incluindo total de veículos cadastrados e o status das vistorias (em andamento, concluídas e canceladas).

Gerenciamento de Usuários (CRUD): Sistema de permissões escalonado entre Administrador, Gerente, Supervisor e Técnico.

Itens de Reparo (CRUD): Categorização de serviços como reparo de rachaduras e troca de vidros, detalhados por partes do veículo (para-brisa, portas, etc.).

Gerenciamento de Veículos (CRUD): Registro de dados da frota com obrigatoriedade de placa e associação ao item de reparo.

Realização de Reparo: Fluxo que exige um mínimo de 5 fotos pré-reparo e 5 fotos pós-reparo, além de fotos obrigatórias do item específico. Inclui captura de geolocalização e assinatura digital.

Histórico de Reparos: Auditoria completa com geração de relatório em PDF e opção de retomar reparos em andamento.

2. Tecnologias e Arquitetura
   Para garantir alta performance e escalabilidade, a stack recomendada é:

Frontend: React.js com TypeScript.

Estilização: CSS Modules com base em grid de 12 colunas e contêiner máximo de 1140px.

Backend: Node.js com Express (focado em I/O assíncrono para uploads de fotos).

Banco de Dados: PostgreSQL (relacional, ideal para os relacionamentos complexos entre usuários, veículos e vistorias).

Armazenamento: AWS S3 ou equivalente para salvar as imagens com segurança e performance.

3. Diretrizes de UX/UI e Identidade Visual
   A interface segue estritamente a base de conhecimento estrutural da marca:

Paleta de Cores: O Vermelho Pilkington (#CC0000) é utilizado como cor primária para CTAs e logotipos. A barra de navegação superior possui fundo Cinza Escuro (#1A1A1A) com texto Branco (#FFFFFF).

Tipografia: A família base é Arial/Helvetica, garantindo neutralidade e alta legibilidade corporativa.

Estrutura de Componentes: Os botões de ação principal não possuem bordas arredondadas (border-radius: 0px), reforçando o estilo corporativo.

4. Considerações de Segurança
   Implementação de proteção ativa contra as vulnerabilidades do OWASP Top 10.

Uso de autenticação multifator (MFA) e senhas com políticas robustas.

Criptografia de dados em trânsito (HTTPS/TLS) e em repouso.
