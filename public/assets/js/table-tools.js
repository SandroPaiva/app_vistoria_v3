/**
 * Pilkington V3 - Table Tools
 * Gerencia filtros universais (pesquisa em tempo real + filtro Ativo=SIM)
 * e ordenação bidirecional (crescente/decrescente) em todas as colunas.
 */

document.addEventListener('DOMContentLoaded', function () {
    const tables = document.querySelectorAll('.table');

    tables.forEach(function (table, tableIndex) {
        // Ignora tabelas pequenas ou especiais se marcadas com data-no-tools
        if (table.dataset.noTools === 'true') return;

        setupTableSorting(table);
        setupTableFiltering(table, tableIndex);
    });

    /**
     * Configuração da Ordenação de Colunas
     */
    function setupTableSorting(table) {
        const thead = table.querySelector('thead');
        if (!thead) return;

        const headers = thead.querySelectorAll('th');
        let currentSortCol = -1;
        let currentSortDir = 'asc'; // 'asc' ou 'desc'

        headers.forEach(function (th, colIndex) {
            const title = th.innerText.trim();
            // Pula coluna de Ações
            if (title.toLowerCase() === 'ações' || th.dataset.sortable === 'false') {
                return;
            }

            th.style.cursor = 'pointer';
            th.style.userSelect = 'none';
            th.setAttribute('title', 'Clique para ordenar');

            // Adiciona ícone indicador de ordenação
            const icon = document.createElement('i');
            icon.className = 'fa-solid fa-sort';
            icon.style.marginLeft = '8px';
            icon.style.fontSize = '11px';
            icon.style.opacity = '0.4';
            icon.style.transition = 'all 0.2s';
            th.appendChild(icon);

            th.addEventListener('click', function () {
                if (currentSortCol === colIndex) {
                    currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSortCol = colIndex;
                    currentSortDir = 'asc';
                }

                // Atualiza todos os ícones
                headers.forEach(function (otherTh) {
                    const otherIcon = otherTh.querySelector('i.fa-solid');
                    if (otherIcon) {
                        otherIcon.className = 'fa-solid fa-sort';
                        otherIcon.style.opacity = '0.4';
                        otherIcon.style.color = '';
                    }
                });

                // Atualiza o ícone atual
                icon.className = currentSortDir === 'asc' ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down';
                icon.style.opacity = '1';
                icon.style.color = 'var(--color-primary)';

                sortTableByColumn(table, colIndex, currentSortDir);
            });
        });
    }

    /**
     * Ordena linhas do corpo da tabela
     */
    function sortTableByColumn(table, columnIndex, direction) {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('tr'));
        // Se houver apenas linha de "Nenhum registro encontrado", não ordena
        if (rows.length <= 1 && rows[0] && rows[0].querySelector('td[colspan]')) return;

        rows.sort(function (rowA, rowB) {
            const cellA = rowA.children[columnIndex];
            const cellB = rowB.children[columnIndex];

            if (!cellA || !cellB) return 0;

            const valA = (cellA.dataset.sortValue || cellA.innerText || '').trim();
            const valB = (cellB.dataset.sortValue || cellB.innerText || '').trim();

            // Comparador de Data brasileira: dd/mm/yyyy hh:mm ou dd/mm/yyyy
            const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})(?:\s+(\d{2}):(\d{2}))?/;
            const matchA = valA.match(dateRegex);
            const matchB = valB.match(dateRegex);

            if (matchA && matchB) {
                const dateA = new Date(matchA[3], matchA[2] - 1, matchA[1], matchA[4] || 0, matchA[5] || 0);
                const dateB = new Date(matchB[3], matchB[2] - 1, matchB[1], matchB[4] || 0, matchB[5] || 0);
                return direction === 'asc' ? dateA - dateB : dateB - dateA;
            }

            // Comparador numérico
            const numA = parseFloat(valA.replace(/[^\d.-]/g, ''));
            const numB = parseFloat(valB.replace(/[^\d.-]/g, ''));
            if (!isNaN(numA) && !isNaN(numB) && !valA.includes('/') && !valB.includes('/')) {
                return direction === 'asc' ? numA - numB : numB - numA;
            }

            // Comparador de texto padrão com suporte a acentuação
            return direction === 'asc'
                ? valA.localeCompare(valB, 'pt-BR', { numeric: true, sensitivity: 'base' })
                : valB.localeCompare(valA, 'pt-BR', { numeric: true, sensitivity: 'base' });
        });

        // Reanexa as linhas ordenadas
        rows.forEach(function (row) {
            tbody.appendChild(row);
        });
    }

    /**
     * Configuração do Filtro Universal (Texto + Ativo=SIM por padrão)
     */
    function setupTableFiltering(table, tableIndex) {
        const responsiveContainer = table.closest('.table-responsive') || table;
        const panel = responsiveContainer.parentElement;
        if (!panel) return;

        // Verifica se a tabela possui coluna de status / ativo
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.innerText.toLowerCase().trim());
        const hasStatusCol = headers.some(h => h.includes('ativo') || h.includes('status'));

        // Cria a barra de ferramentas de filtro
        const filterBar = document.createElement('div');
        filterBar.className = 'table-filter-bar';
        filterBar.style = 'display: flex; gap: 15px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 1.25rem; background: var(--color-surface); padding: 12px 18px; border-radius: var(--radius-md); border: 1px solid var(--color-border);';

        const leftSide = document.createElement('div');
        leftSide.style = 'display: flex; gap: 12px; align-items: center; flex: 1; max-width: 600px; flex-wrap: wrap;';

        // Campo de busca geral
        const searchWrapper = document.createElement('div');
        searchWrapper.style = 'position: relative; flex: 1; min-width: 220px;';
        searchWrapper.innerHTML = `
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--color-mid); font-size: 13px;"></i>
            <input type="text" class="table-search-input form-control" placeholder="Pesquisar em todos os campos..." style="padding-left: 36px; padding-top: 8px; padding-bottom: 8px; font-size: 13px;">
        `;
        leftSide.appendChild(searchWrapper);

        // Seletor Ativo (SIM como padrão)
        let selectStatus = null;
        if (hasStatusCol) {
            const selectWrapper = document.createElement('div');
            selectWrapper.style = 'min-width: 170px;';
            selectWrapper.innerHTML = `
                <select class="table-status-select form-control" style="padding-top: 8px; padding-bottom: 8px; font-size: 13px; font-weight: 600;">
                    <option value="sim" selected>Ativo: SIM</option>
                    <option value="nao">Ativo: NÃO</option>
                    <option value="todos">Status: TODOS</option>
                </select>
            `;
            leftSide.appendChild(selectWrapper);
            selectStatus = selectWrapper.querySelector('select');
        }

        filterBar.appendChild(leftSide);

        // Contador de registros
        const counter = document.createElement('div');
        counter.className = 'table-records-counter';
        counter.style = 'font-size: 12px; color: var(--color-mid); font-weight: 500;';
        counter.innerHTML = 'Carregando registros...';
        filterBar.appendChild(counter);

        // Insere a barra antes da tabela
        responsiveContainer.parentNode.insertBefore(filterBar, responsiveContainer);

        const searchInput = searchWrapper.querySelector('input');
        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        function applyFilter() {
            const query = searchInput.value.toLowerCase().trim();
            const statusFilter = selectStatus ? selectStatus.value : 'todos';

            const rows = Array.from(tbody.querySelectorAll('tr'));
            let visibleCount = 0;
            let totalCount = 0;

            rows.forEach(function (row) {
                // Pula linha de mensagem "Nenhum registro"
                if (row.querySelector('td[colspan]')) {
                    row.remove();
                    return;
                }

                totalCount++;
                const text = row.innerText.toLowerCase();
                const matchesQuery = query === '' || text.includes(query);

                // Checagem de status Ativo/Inativo
                let matchesStatus = true;
                if (hasStatusCol && statusFilter !== 'todos') {
                    // Verifica badge de status, status-circle ou texto
                    const badges = Array.from(row.querySelectorAll('.badge, .status-circle, td'));
                    const isRowAtivo = badges.some(b => {
                        if (b.classList.contains('status-active')) return true;
                        if (b.getAttribute('data-status') === 'ativo') return true;
                        const t = (b.innerText || b.getAttribute('title') || '').toLowerCase().trim();
                        return t === 'ativo' || t === 'em andamento' || t === 'agendado';
                    });
                    const isRowInativo = badges.some(b => {
                        if (b.classList.contains('status-inactive')) return true;
                        if (b.getAttribute('data-status') === 'inativo') return true;
                        const t = (b.innerText || b.getAttribute('title') || '').toLowerCase().trim();
                        return t === 'inativo' || t === 'cancelado';
                    });

                    if (statusFilter === 'sim') {
                        matchesStatus = isRowAtivo || (!isRowInativo && !text.includes('inativo'));
                    } else if (statusFilter === 'nao') {
                        matchesStatus = isRowInativo || text.includes('inativo');
                    }
                }

                if (matchesQuery && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            counter.innerHTML = `Exibindo <strong>${visibleCount}</strong> de <strong>${totalCount}</strong> registro(s)`;

            // Mensagem quando nenhum registro for encontrado
            const existingEmpty = tbody.querySelector('.row-empty-filter');
            if (visibleCount === 0) {
                if (!existingEmpty) {
                    const emptyTr = document.createElement('tr');
                    emptyTr.className = 'row-empty-filter';
                    const colCount = table.querySelectorAll('thead th').length || 1;
                    emptyTr.innerHTML = `<td colspan="${colCount}" style="text-align: center; padding: 25px; color: var(--color-mid); font-style: italic;"><i class="fa-solid fa-filter-circle-xmark" style="font-size: 20px; display: block; margin-bottom: 8px;"></i>Nenhum registro encontrado para os filtros selecionados.</td>`;
                    tbody.appendChild(emptyTr);
                }
            } else if (existingEmpty) {
                existingEmpty.remove();
            }
        }

        searchInput.addEventListener('input', applyFilter);
        if (selectStatus) {
            selectStatus.addEventListener('change', applyFilter);
        }

        // Aplica o filtro inicial (com Ativo: SIM por padrão)
        applyFilter();
    }
});
