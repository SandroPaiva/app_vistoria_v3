# Pilkington - Sistema de Vistoria Veicular V3

## Visão Geral
Sistema robusto, responsivo e moderno desenvolvido para otimizar as operações de reparo e troca de vidros veiculares da Pilkington. O aplicativo web foi desenhado para máxima produtividade operacional tanto no escritório (administração, supervisão e agendamentos) quanto em campo (técnicos), contando com ferramentas nativas como captura de câmera, compressão de imagens no cliente, geolocalização por GPS, assinatura digital em canvas, calendário interativo de agendamentos e dossiê histórico completo dos veículos.

---

## 🛠 Tecnologias e Recursos Utilizados

O projeto prioriza alta performance, manutenibilidade e controle total do código, sem dependências de frameworks pesados:

*   **PHP 8+ (Vanilla MVC com Camada de Models):** Arquitetura Model-View-Controller criada do zero. Responsável pelo roteamento (`Router.php`), segurança de autenticação, regras de negócio e camada de acesso a dados desacoplada (`app/Core/Model.php` e `app/Models/*`).
*   **Auto-Migração de Banco de Dados (`app/Core/Database.php`):** Inicialização silenciosa e idempotente que atualiza automaticamente colunas e enums de agendamento e motivos de serviço.
*   **Variáveis de Ambiente (`.env`):** Gerenciador de configuração nativo (`app/Core/Env.php`), isolando credenciais do banco de dados e protegido no `.gitignore`.
*   **MySQL & PDO:** Banco de dados relacional acessado via Prepared Statements para total prevenção de SQL Injection.
*   **JavaScript (Vanilla & `table-tools.js`):** Interatividade dinâmica no front-end: compressão de fotos antes do upload, geolocalização via API do navegador, assinatura digital via HTML5 `<canvas>`, calendário mensal interativo e filtros/ordenação universais em todas as tabelas.
*   **CSS3 (Design System Pilkington):** Estilização baseada nas diretrizes corporativas da Pilkington (Verde Pilkington `#075E54`, Cinza Carvão `#1A1A1A`, Superfície `#F7F8F8`, tipografia corporativa e microinterações com cantos arredondados).
*   **FontAwesome (CDN):** Ícones padronizados para menus, ações, badges e indicadores de ordenação de colunas.

---

## 📦 Módulos do Sistema

### 1. Autenticação e Sessão (`AuthController`)
*   Login seguro com hash `BCRYPT` e sanitização nativa compatível com PHP 8.1+.
*   Controle de acesso baseado em perfis: `Administrador`, `Gerente`, `Supervisor` e `Técnico`.

### 2. Dashboard Operacional (`DashboardController`)
*   **Quadro de Serviços Agendados (Topo Esquerdo):** Exibe a escala de atendimentos para a data selecionada no calendário, informando horário, veículo (placa em destaque), técnico, cliente, tipo de reparo, motivo (se for refação) e botão de ação contextual (*"Iniciar"*, *"Continuar"* ou *"Laudo PDF"*).
*   **Calendário Mensal Interativo (Topo Direito):**
    *   Navegação completa entre dias, meses (`<`, `>`) e anos (`<<`, `>>`).
    *   Marcadores pontuais nos dias com agendamentos (passados, presentes e futuros).
    *   Botão **"Hoje"** com **badge numérico do total de serviços do dia**.
    *   **Filtro instantâneo:** Ao clicar em qualquer dia, a lista de serviços ao lado é atualizada em tempo real via JavaScript.
*   **Visão Personalizada por Perfil:**
    *   Para o perfil **Técnico**, o 1º indicador estatístico exibe **"Serviços Realizados"** (apresentando apenas o total de serviços concluídos pelo técnico logado).
    *   Para os demais perfis (Admin, Gerente, Supervisor), exibe **"Veículos Cadastrados"** (catálogo geral da empresa).
*   **Cards de KPIs com Chaveamento de Tabelas:** Indicadores de Serviços em Andamento, Concluídos e Cancelados que expandem tabelas detalhadas ao clique.

### 3. Gestão de Usuários (`UsuarioController`)
*   Cadastro e controle hierárquico de operadores da oficina e campo.
*   Colunas **Ativo** (badges visuais `Ativo` / `Inativo`) e **Data Alteração** para auditoria de ações.
*   Ação de **Reativação** para usuários inativos e dropdown de status no formulário de edição.

### 4. Gestão de Veículos & Histórico (`VeiculoController`)
*   **Agendamento no Cadastro e Edição:** Permite definir dia/hora (`datetime-local`) e técnico responsável. No cadastro, gera automaticamente o serviço com status `Agendado`.
*   **Novo Serviço / Refazer:** Para veículos que já possuem histórico de atendimentos, disponibiliza formulário específico exigindo a seleção do **Motivo** (`Novo Serviço` ou `Refazer`) e **Observação Complementar Obrigatória**, gerando um novo registro vinculado ao histórico do veículo.
*   **Coluna "Tipo de Serviço":** Identifica rapidamente o item de reparo e classificação do vidro no catálogo.
*   **Dossiê do Veículo (`/veiculos/visualizar/{id}`):**
    *   Painel com dados completos do veículo e proprietário.
    *   Card destacado com o **Próximo Atendimento Agendado**.
    *   Tabela com o **Histórico Completo de Serviços** com status, técnico, motivo, observação e link para laudos em PDF.

### 5. Gestão de Itens de Reparo (`ItemController`)
*   Catálogo dos serviços oferecidos pela unidade (ex: Parabrisa, Farol, Vidro Lateral) e classificação técnica. Suporte a inativação e reativação.

### 6. Execução de Vistorias e Atendimentos (`VistoriaController`)
*   **Filtro Restrito de Veículo Alvo:** A criação avulsa (`/vistorias/nova`) restringe a seleção exclusivamente a veículos sem nenhum serviço prévio registrado (excluindo os em andamento, cancelados ou concluídos).
*   **Quadro de Escala do Dia:** Quadro superior com os agendamentos do dia e botão direto **"Iniciar Serviço"** (`/vistorias/iniciar/{id}`).
*   **Fluxo do Técnico:** O botão de novo serviço avulso e o acesso manual à rota `/vistorias/nova` são bloqueados para o perfil Técnico, assegurando que o atendimento seja iniciado a partir dos agendamentos programados.
*   **Checklist de Campo:** Upload com compressão client-side de fotos (pré e pós-reparo), captura de geolocalização GPS e coleta de assinatura digital em canvas.

### 7. Relatórios e Laudo em PDF (`VistoriaController@pdf`)
*   Geração instantânea de laudo técnico A4 em `@media print`, organizando dados do cliente, fotos com miniaturas, coordenadas de GPS e assinatura do cliente.

### 8. Ferramentas Universais de Listagem (`table-tools.js`)
Injetado globalmente em todas as tabelas `.table` do sistema:
*   **Busca em Tempo Real:** Filtra simultaneamente o texto digitado em todas as colunas.
*   **Filtro "Ativo: SIM" por Padrão:** Inicia selecionado nas tabelas que possuem coluna de status, permitindo alternar para *"Ativo: NÃO"* ou *"Status: TODOS"*.
*   **Ordenação Bidirecional:** Clique nos cabeçalhos de coluna para ordenar (1º clique ASC, 2º clique DESC), com ícones visuais (`fa-sort`, `fa-sort-up`, `fa-sort-down`), suporte ao formato de data brasileiro (`dd/mm/yyyy hh:mm`), valores numéricos e textos acentuados.
*   **Contador Dinâmico:** Exibe a quantidade de registros visíveis em relação ao total.

---

## 🐛 Histórico de Problemas Encontrados e Soluções (Troubleshooting)

*   **Problema 1: Layout Genérico fora de Padrão**
    *   *Correção:* Reescrevemos o `style.css` aplicando a paleta oficial da Pilkington (Verde `#075E54`, Cinza Carvão `#1A1A1A`), tipografia limpa, cantos arredondados e sombras suaves.
*   **Problema 2: Falha no Login de Administrador**
    *   *Correção:* Geração de hash seguro via `password_hash('admin123', PASSWORD_BCRYPT)` no PHP 8 e atualização no banco e no script `database.sql`.
*   **Problema 3: Vistorias não Salvavam Fotos (Limite de Upload PHP)**
    *   *Correção:* Elevação de `post_max_size` no servidor e criação de um motor nativo em JavaScript no front-end que redimensiona e comprime as fotos para até 1280px via HTML5 Canvas antes do envio.
*   **Problema 4: Câmera não Abrindo Nativa e Imagens Quebradas no PDF**
    *   *Correção:* Substituição de tags de botão por `<label>` com `<input type="file" capture="environment">` nativo para disparar a câmera em dispositivos móveis, além de permissões de escrita em `/public/assets/img/`.
*   **Problema 5: Credenciais Hardcoded e SQL Acoplado nos Controllers**
    *   *Correção:* Implementação da classe `Env` com suporte a `.env`/`.gitignore`, modernização da sanitização de inputs para compatibilidade com PHP 8.1+ e desacoplamento completo da camada de dados em Models (`Usuario`, `ItemReparo`, `Veiculo`, `Vistoria`, `FotoVistoria`).
*   **Problema 6: Controle de Agendamentos, Múltiplos Serviços por Veículo e Visão do Técnico**
    *   *Cenário:* Veículos que precisavam de novo atendimento ou refação não podiam ser atendidos sem perder o histórico anterior, o perfil de técnico tinha acesso a telas de cadastro desnecessárias, e não havia visão de escala diária e mensal.
    *   *Correção:* Auto-migração do schema MySQL para inclusão de status `Agendado`, `data_agendamento`, `motivo_servico` e `observacao_motivo`. Criação da funcionalidade de agendamento no cadastro/edição de veículos, formulário específico de "Novo Serviço / Refazer", dossiê de histórico (`/veiculos/visualizar/{id}`), calendário interativo mensal com navegação dia/mês/ano no Dashboard e adaptação do primeiro indicador para "Serviços Realizados" na visão do Técnico.

---

## 🚀 Passo a Passo: Fluxo Operacional Recomendado

### 1. Cadastro de Veículo e Agendamento
1. Acesse o menu **Veículos** e clique em **Novo Veículo**.
2. Preencha a Placa, Fabricante/Modelo e selecione o **Item de Reparo**.
3. Defina a **Data e Hora do Agendamento** e selecione o **Técnico Responsável**.
4. Ao salvar, o sistema cadastra o veículo e agenda automaticamente a vistoria na escala.

### 2. Acompanhamento no Dashboard
1. No menu **Dashboard**, visualize o calendário interativo mensal.
2. Navegue pelos meses e anos; dias com serviços agendados apresentam marcadores pontuais.
3. Clique em qualquer dia para inspecionar os atendimentos daquela data.
4. Utilize o botão **"Hoje [X]"** para retornar à data atual e checar o total de serviços programados para hoje.

### 3. Execução pelo Técnico
1. O técnico faz login com seu perfil e visualiza no topo de **Vistorias** ou no **Dashboard** a sua escala do dia.
2. Ao lado do atendimento agendado, clica no botão **"Iniciar Serviço"**.
3. O status transita para `Em Andamento` e o checklist é aberto.
4. O técnico captura as fotos (mínimo 5, máximo 10 nas etapas pré e pós-reparo), captura a localização GPS e coleta a assinatura digital do cliente na tela.
5. Clica em **"Concluir Vistoria"**. O relatório final com botão **"Download PDF"** é disponibilizado de imediato.

### 4. Novo Atendimento ou Refação em Veículo com Histórico
1. Acesse **Veículos** e localize a placa do veículo desejado.
2. Clique no botão **"Histórico"** para consultar todos os atendimentos passados e o próximo agendamento.
3. Para agendar um novo trabalho, clique no botão **"Novo Serviço / Refazer"**.
4. Selecione o motivo (`Novo Serviço` ou `Refazer`), digite a justificativa na **Observação Complementar**, informe data/hora e confirme. O histórico do veículo é preservado integralmente.
