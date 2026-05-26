<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <style>
        :root {
            --pilkington-red: #CC0000;
            --dark: #1A1A1A;
            --mid: #666666;
            --light: #F4F4F4;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--dark);
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 12pt;
        }

        .a4-container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20mm;
            background: white;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--pilkington-red);
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: var(--pilkington-red);
            margin: 0;
            font-size: 24pt;
        }

        .header .doc-info {
            text-align: right;
            font-size: 10pt;
            color: var(--mid);
        }

        .section-title {
            background-color: var(--light);
            padding: 5px 10px;
            font-weight: bold;
            font-size: 14pt;
            border-left: 4px solid var(--pilkington-red);
            margin-top: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
            font-size: 11pt;
        }

        th {
            background-color: var(--light);
            width: 30%;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 15px;
        }

        .photo-card {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        .photo-card img {
            max-width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
            margin: 0 auto 5px;
        }

        .photo-card p {
            font-size: 9pt;
            margin: 0;
            color: var(--mid);
        }

        .signature-box {
            margin-top: 40px;
            text-align: center;
            width: 100%;
        }

        .signature-box img {
            max-width: 300px;
            max-height: 100px;
            display: block;
            margin: 0 auto;
        }

        .signature-line {
            border-top: 1px solid var(--dark);
            width: 300px;
            margin: 10px auto;
        }

        @media print {
            body { background: none; }
            .a4-container { width: 100%; margin: 0; padding: 0; box-shadow: none; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <div class="a4-container">
        <!-- HEADER -->
        <div class="header">
            <div>
                <h1>Pilkington</h1>
                <p style="margin: 0; font-size: 12pt; color: var(--mid);">Relatório de Vistoria e Reparo</p>
            </div>
            <div class="doc-info">
                Vistoria ID: <strong>#<?= str_pad($vistoria['id'], 5, '0', STR_PAD_LEFT) ?></strong><br>
                Data Início: <?= date('d/m/Y H:i', strtotime($vistoria['data_inicio'])) ?><br>
                Data Conclusão: <?= $vistoria['data_fim'] ? date('d/m/Y H:i', strtotime($vistoria['data_fim'])) : 'Em Andamento' ?>
            </div>
        </div>

        <!-- DADOS GERAIS -->
        <div class="section-title">Dados do Veículo e Cliente</div>
        <table>
            <tr>
                <th>Placa</th>
                <td><?= htmlspecialchars($vistoria['placa']) ?></td>
            </tr>
            <tr>
                <th>Fabricante / Modelo</th>
                <td><?= htmlspecialchars($vistoria['fabricante'] . ' ' . $vistoria['modelo']) ?> (Ano: <?= htmlspecialchars($vistoria['ano_fabricacao'] ?? '-') ?>)</td>
            </tr>
            <tr>
                <th>Chassi</th>
                <td><?= htmlspecialchars($vistoria['chassi'] ?? 'Não informado') ?></td>
            </tr>
            <tr>
                <th>Proprietário</th>
                <td><?= htmlspecialchars($vistoria['nome_proprietario'] ?? 'Não informado') ?></td>
            </tr>
        </table>

        <!-- DADOS DO REPARO -->
        <div class="section-title">Dados do Reparo</div>
        <table>
            <tr>
                <th>Tipo de Serviço</th>
                <td><?= htmlspecialchars($vistoria['tipo_reparo'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th>Classificação do Vidro</th>
                <td><?= htmlspecialchars($vistoria['classificacao_vidro'] ?? 'N/A') ?></td>
            </tr>
            <tr>
                <th>Técnico Responsável</th>
                <td><?= htmlspecialchars($vistoria['nome_tecnico']) ?></td>
            </tr>
            <tr>
                <th>Localização (GPS)</th>
                <td>Lat: <?= htmlspecialchars($vistoria['latitude'] ?? 'N/A') ?>, Lng: <?= htmlspecialchars($vistoria['longitude'] ?? 'N/A') ?></td>
            </tr>
        </table>

        <div style="margin-bottom: 20px;">
            <strong>Observações Técnicas e Materiais:</strong>
            <p style="border: 1px solid #ddd; padding: 10px; min-height: 60px; font-size: 11pt;">
                <?= nl2br(htmlspecialchars($vistoria['dados_reparo'] ?? 'Nenhuma observação registrada.')) ?>
            </p>
        </div>

        <!-- FOTOS DO ITEM ESPECÍFICO -->
        <div class="section-title">Fotografias do Item Alvo</div>
        <div class="photo-grid">
            <?php foreach ($fotos['Item-Antes'] as $f): ?>
                <div class="photo-card">
                    <img src="<?= BASE_URL . $f['caminho_arquivo'] ?>" alt="Item Antes">
                    <p>Item (Antes)</p>
                </div>
            <?php endforeach; ?>
            <?php foreach ($fotos['Item-Depois'] as $f): ?>
                <div class="photo-card">
                    <img src="<?= BASE_URL . $f['caminho_arquivo'] ?>" alt="Item Depois">
                    <p>Item (Depois)</p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- QUEBRA DE PÁGINA PARA FOTOS GERAIS -->
        <div class="page-break"></div>

        <div class="section-title">Fotografias Pré-Reparo (Estado Inicial do Veículo)</div>
        <div class="photo-grid">
            <?php if (empty($fotos['Pre-Reparo'])) echo "<p>Nenhuma foto pré-reparo anexada.</p>"; ?>
            <?php foreach ($fotos['Pre-Reparo'] as $i => $f): ?>
                <div class="photo-card">
                    <img src="<?= BASE_URL . $f['caminho_arquivo'] ?>" alt="Pré-Reparo">
                    <p>Pré-Reparo - Foto <?= $i + 1 ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section-title">Fotografias Pós-Reparo (Estado Final do Veículo)</div>
        <div class="photo-grid">
            <?php if (empty($fotos['Pos-Reparo'])) echo "<p>Nenhuma foto pós-reparo anexada.</p>"; ?>
            <?php foreach ($fotos['Pos-Reparo'] as $i => $f): ?>
                <div class="photo-card">
                    <img src="<?= BASE_URL . $f['caminho_arquivo'] ?>" alt="Pós-Reparo">
                    <p>Pós-Reparo - Foto <?= $i + 1 ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- ASSINATURA -->
        <div class="page-break"></div>
        <div class="section-title">Termo de Aceite e Assinatura</div>
        <p style="font-size: 11pt; text-align: justify;">
            Declaro, para os devidos fins, que o serviço especificado neste relatório foi executado conforme os padrões de qualidade e segurança estabelecidos pela Pilkington. O veículo foi entregue e inspecionado após o reparo/troca dos itens listados acima.
        </p>

        <div class="signature-box">
            <?php if (!empty($vistoria['assinatura_digital'])): ?>
                <?php 
                    // Se for uma assinatura em base64 vinda do Canvas
                    $src = strpos($vistoria['assinatura_digital'], 'data:image') === 0 
                           ? $vistoria['assinatura_digital'] 
                           : htmlspecialchars($vistoria['assinatura_digital']);
                ?>
                <img src="<?= $src ?>" alt="Assinatura">
            <?php else: ?>
                <div style="height: 60px;"></div>
            <?php endif; ?>
            <div class="signature-line"></div>
            <p style="margin: 0; font-size: 11pt; font-weight: bold;">Assinatura do Cliente / Responsável</p>
        </div>
    </div>

    <!-- Script para disparar o diálogo de impressão que gera o PDF automaticamente -->
    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500); // Aguarda 500ms para garantir que as imagens foram carregadas no DOM
        };
    </script>
</body>
</html>
