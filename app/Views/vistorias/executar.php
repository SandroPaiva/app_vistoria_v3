<div class="panel">
    <div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h3 style="color: var(--color-dark); margin: 0;">Execução de Reparo</h3>
            <p style="color: var(--color-mid); font-size: 13px;">Veículo: <strong><?= htmlspecialchars($vistoria['fabricante'] . ' ' . $vistoria['modelo'] . ' - ' . $vistoria['placa']) ?></strong></p>
            <p style="color: var(--color-mid); font-size: 13px;">Item Alvo: <strong><?= htmlspecialchars($vistoria['tipo_reparo'] ?? 'Não especificado') ?> - <?= htmlspecialchars($vistoria['classificacao_vidro'] ?? '') ?></strong></p>
        </div>
        <span class="badge" style="background: var(--color-warning); font-size: 14px; padding: 8px 12px;">Em Andamento</span>
    </div>

    <!-- O form agora não usa enctype multipart padrão porque vamos mandar base64 via AJAX ou hidden inputs -->
    <form action="<?= BASE_URL ?>/vistorias/salvar_etapa" method="POST" id="formReparo">
        <input type="hidden" name="vistoria_id" value="<?= $vistoria['id'] ?>">
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <input type="hidden" name="assinatura_digital" id="assinatura_digital" value="<?= htmlspecialchars($vistoria['assinatura_digital'] ?? '') ?>">

        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-top: 20px;">1. Fotografias Pré-Reparo</h4>
        <p style="font-size: 12px; color: var(--color-mid); margin-bottom: 10px;">Obrigatório: Mínimo de 5, Máximo de 10.</p>
        <div class="form-group photo-manager" data-name="pre_reparo" data-min="5" data-max="10">
            <input type="file" id="file_pre_reparo" class="photo-input" multiple accept="image/*" style="display:none;">
            <label for="file_pre_reparo" class="btn btn-secondary btn-add-photo" style="display: inline-block; cursor: pointer; text-align: center;">
                <i class="fa-solid fa-camera"></i> Adicionar Fotos (Câmera ou Galeria)
            </label>
            <div class="photo-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;"></div>
        </div>

        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-top: 30px;">2. Fotografias do Item Específico</h4>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group photo-manager" data-name="item_antes" data-min="1" data-max="5">
                <label class="form-label">Item ANTES do reparo *</label>
                <input type="file" id="file_item_antes" class="photo-input" multiple accept="image/*" style="display:none;">
                <label for="file_item_antes" class="btn btn-secondary btn-add-photo" style="display: inline-block; cursor: pointer; text-align: center;">
                    <i class="fa-solid fa-camera"></i> Adicionar Foto
                </label>
                <div class="photo-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
            </div>
            <div class="form-group photo-manager" data-name="item_depois" data-min="1" data-max="5">
                <label class="form-label">Item DEPOIS do reparo *</label>
                <input type="file" id="file_item_depois" class="photo-input" multiple accept="image/*" style="display:none;">
                <label for="file_item_depois" class="btn btn-secondary btn-add-photo" style="display: inline-block; cursor: pointer; text-align: center;">
                    <i class="fa-solid fa-camera"></i> Adicionar Foto
                </label>
                <div class="photo-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px;"></div>
            </div>
        </div>

        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-top: 30px;">3. Dados Técnicos do Reparo</h4>
        <div class="form-group">
            <label class="form-label" for="dados_reparo">Descrição dos materiais e observações:</label>
            <textarea name="dados_reparo" id="dados_reparo" class="form-control" rows="5" required><?= htmlspecialchars($vistoria['dados_reparo'] ?? '') ?></textarea>
        </div>

        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-top: 30px;">4. Fotografias Pós-Reparo</h4>
        <p style="font-size: 12px; color: var(--color-mid); margin-bottom: 10px;">Obrigatório: Mínimo de 5, Máximo de 10.</p>
        <div class="form-group photo-manager" data-name="pos_reparo" data-min="5" data-max="10">
            <input type="file" id="file_pos_reparo" class="photo-input" multiple accept="image/*" style="display:none;">
            <label for="file_pos_reparo" class="btn btn-secondary btn-add-photo" style="display: inline-block; cursor: pointer; text-align: center;">
                <i class="fa-solid fa-camera"></i> Adicionar Fotos
            </label>
            <div class="photo-preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;"></div>
        </div>

        <h4 style="border-bottom: 1px solid var(--color-border); padding-bottom: 10px; margin-top: 30px;">5. Assinatura e Geolocalização</h4>
        <div class="form-group">
            <button type="button" class="btn btn-secondary" id="btnGeoloc" style="margin-bottom: 15px;">
                <i class="fa-solid fa-location-dot"></i> Capturar Localização Atual
            </button>
            <span id="geoStatus" style="font-size: 12px; margin-left: 10px; color: var(--color-mid);"></span>
        </div>
        
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="btnOpenSignature" style="background-color: var(--color-dark); margin-bottom: 15px;">
                <i class="fa-solid fa-pen-nib"></i> Coletar Assinatura Digital
            </button>
            <div id="signaturePreviewContainer" style="display: <?= !empty($vistoria['assinatura_digital']) ? 'block' : 'none' ?>; border: 1px solid var(--color-border); padding: 10px; width: fit-content; margin-top: 10px;">
                <p style="font-size: 12px; margin-bottom: 5px; font-weight: bold;">Assinatura coletada:</p>
                <img id="signaturePreview" src="<?= htmlspecialchars($vistoria['assinatura_digital'] ?? '') ?>" style="max-height: 80px; max-width: 100%;">
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--color-border); margin: 30px 0;">

        <div style="display: flex; gap: 15px;">
            <button type="submit" name="finalizar" value="0" class="btn btn-primary" style="background-color: var(--color-dark);">
                <i class="fa-solid fa-save"></i> Salvar Rascunho
            </button>
            <button type="submit" name="finalizar" value="1" class="btn btn-success">
                <i class="fa-solid fa-check"></i> Concluir Vistoria
            </button>
            <a href="<?= BASE_URL ?>/vistorias" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<!-- Modal de Assinatura -->
<div id="signatureModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
    <div style="background: white; padding: 20px; border-radius: 8px; width: 90%; max-width: 800px; text-align: center;">
        <h3 style="margin-bottom: 10px; color: var(--color-dark);">Assinatura do Cliente</h3>
        <p style="font-size: 12px; color: var(--color-mid); margin-bottom: 15px;">Por favor, assine no quadro abaixo (Gire o celular se necessário).</p>
        
        <div style="border: 2px dashed var(--color-border); background: #f9f9f9; touch-action: none; margin-bottom: 15px;">
            <canvas id="signatureCanvas" style="width: 100%; height: 250px; cursor: crosshair;"></canvas>
        </div>
        
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" id="btnSavesignature" class="btn btn-success"><i class="fa-solid fa-check"></i> Salvar</button>
            <button type="button" id="btnClearSignature" class="btn btn-secondary"><i class="fa-solid fa-eraser"></i> Limpar</button>
            <button type="button" id="btnCloseSignature" class="btn btn-danger"><i class="fa-solid fa-times"></i> Fechar</button>
        </div>
    </div>
</div>

<script>
    // Gerenciador de Fotos, Compressão e Preview (Estilo WhatsApp)
    const MAX_WIDTH = 1280;
    const MAX_HEIGHT = 1280;
    const QUALITY = 0.7; // Redução drástica de tamanho (70% quality JPEG)

    // Estrutura para armazenar as fotos processadas em Base64
    const fotosProcessadas = {
        'pre_reparo': [],
        'pos_reparo': [],
        'item_antes': [],
        'item_depois': []
    };

    document.querySelectorAll('.photo-input').forEach(input => {
        input.addEventListener('change', async function(e) {
            let files = Array.from(e.target.files);
            if (files.length === 0) return;
            
            let manager = e.target.closest('.photo-manager');
            let name = manager.dataset.name;
            let container = manager.querySelector('.photo-preview-container');
            let maxFiles = parseInt(manager.dataset.max);

            if (fotosProcessadas[name].length + files.length > maxFiles) {
                alert(`Você só pode adicionar no máximo ${maxFiles} fotos nesta seção.`);
                // Process only up to the limit
                files = files.slice(0, maxFiles - fotosProcessadas[name].length);
            }

            for (let file of files) {
                if (!file.type.startsWith('image/')) continue;
                
                try {
                    let base64 = await compressImage(file);
                    fotosProcessadas[name].push(base64);
                    renderPreviews(name, container);
                } catch (err) {
                    console.error("Erro ao comprimir imagem:", err);
                }
            }
            
            // Reseta o input para permitir selecionar a mesma foto novamente se precisar
            e.target.value = '';
        });
    });

    function compressImage(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = event => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    let width = img.width;
                    let height = img.height;

                    if (width > height) {
                        if (width > MAX_WIDTH) {
                            height = Math.round(height *= MAX_WIDTH / width);
                            width = MAX_WIDTH;
                        }
                    } else {
                        if (height > MAX_HEIGHT) {
                            width = Math.round(width *= MAX_HEIGHT / height);
                            height = MAX_HEIGHT;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    resolve(canvas.toDataURL('image/jpeg', QUALITY));
                };
                img.onerror = error => reject(error);
            };
            reader.onerror = error => reject(error);
        });
    }

    function renderPreviews(name, container) {
        container.innerHTML = '';
        fotosProcessadas[name].forEach((base64, index) => {
            let div = document.createElement('div');
            div.style = "position: relative; width: 80px; height: 80px; border-radius: 4px; overflow: hidden; border: 1px solid var(--color-border);";
            
            let img = document.createElement('img');
            img.src = base64;
            img.style = "width: 100%; height: 100%; object-fit: cover;";
            
            let btnRemove = document.createElement('button');
            btnRemove.innerHTML = "&times;";
            btnRemove.style = "position: absolute; top: 2px; right: 2px; background: rgba(204,0,0,0.8); color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-size: 14px; cursor: pointer; display: flex; align-items: center; justify-content: center;";
            btnRemove.onclick = function() {
                fotosProcessadas[name].splice(index, 1);
                renderPreviews(name, container);
            };

            div.appendChild(img);
            div.appendChild(btnRemove);
            container.appendChild(div);
        });
    }

    // Validação ao submeter e injeção dos base64 no formulário
    document.getElementById('formReparo').addEventListener('submit', function(e) {
        const submitterValue = e.submitter ? e.submitter.value : document.activeElement.value;
        
        if (submitterValue === "1") {
            if (fotosProcessadas['pre_reparo'].length < 5) {
                alert("Você deve enviar no mínimo 5 fotos Pré-Reparo.");
                e.preventDefault(); return;
            }
            if (fotosProcessadas['pos_reparo'].length < 5) {
                alert("Você deve enviar no mínimo 5 fotos Pós-Reparo.");
                e.preventDefault(); return;
            }
            if (fotosProcessadas['item_antes'].length < 1 || fotosProcessadas['item_depois'].length < 1) {
                alert("Você deve enviar as fotos do item (Antes e Depois).");
                e.preventDefault(); return;
            }
            if (!document.getElementById('assinatura_digital').value) {
                alert("A assinatura digital é obrigatória para concluir a vistoria.");
                e.preventDefault(); return;
            }
        }

        // Criar inputs hidden com os Base64 para envio via POST
        for (let name in fotosProcessadas) {
            fotosProcessadas[name].forEach((base64, idx) => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = `base64_${name}[]`;
                input.value = base64;
                this.appendChild(input);
            });
        }
        
        let loadingDiv = document.createElement('div');
        loadingDiv.innerHTML = '<div style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.8);z-index:99999;display:flex;justify-content:center;align-items:center;color:white;flex-direction:column;"><h2>Salvando dados e fotos comprimidas...</h2><p>Por favor, aguarde.</p></div>';
        document.body.appendChild(loadingDiv);
    });

    // Geolocalização
    document.getElementById('btnGeoloc').addEventListener('click', function() {
        if (window.location.protocol !== 'https:' && window.location.hostname !== 'localhost') {
            alert("Atenção: A maioria dos navegadores só permite acessar o GPS em conexões seguras (HTTPS).");
        }
        if (navigator.geolocation) {
            document.getElementById('geoStatus').innerText = "Capturando...";
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                document.getElementById('geoStatus').innerText = "Localização capturada com sucesso!";
                document.getElementById('geoStatus').style.color = "var(--color-success)";
            }, function(error) {
                document.getElementById('geoStatus').innerText = "Erro ao capturar GPS.";
                document.getElementById('geoStatus').style.color = "var(--color-primary)";
            }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
        } else {
            alert("Geolocalização não é suportada por este navegador.");
        }
    });

    // Assinatura Digital via Canvas
    const modal = document.getElementById('signatureModal');
    const canvas = document.getElementById('signatureCanvas');
    const ctx = canvas.getContext('2d');
    let isDrawing = false;

    function resizeCanvas() {
        const rect = canvas.parentElement.getBoundingClientRect();
        canvas.width = rect.width;
        canvas.height = 250;
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';
    }

    document.getElementById('btnOpenSignature').addEventListener('click', function() {
        modal.style.display = 'flex';
        resizeCanvas();
    });

    document.getElementById('btnCloseSignature').addEventListener('click', function() {
        modal.style.display = 'none';
    });

    document.getElementById('btnClearSignature').addEventListener('click', function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    document.getElementById('btnSavesignature').addEventListener('click', function() {
        const dataURL = canvas.toDataURL('image/png');
        document.getElementById('assinatura_digital').value = dataURL;
        document.getElementById('signaturePreview').src = dataURL;
        document.getElementById('signaturePreviewContainer').style.display = 'block';
        modal.style.display = 'none';
    });

    function getCoordinates(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        let clientX, clientY;
        if(e.touches && e.touches.length > 0) {
            clientX = e.touches[0].clientX;
            clientY = e.touches[0].clientY;
        } else {
            clientX = e.clientX;
            clientY = e.clientY;
        }
        return { x: (clientX - rect.left) * scaleX, y: (clientY - rect.top) * scaleY };
    }

    function startDrawing(e) { e.preventDefault(); isDrawing = true; const coords = getCoordinates(e); ctx.beginPath(); ctx.moveTo(coords.x, coords.y); }
    function draw(e) { if (!isDrawing) return; e.preventDefault(); const coords = getCoordinates(e); ctx.lineTo(coords.x, coords.y); ctx.stroke(); }
    function stopDrawing() { isDrawing = false; ctx.closePath(); }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    canvas.addEventListener('touchstart', startDrawing, {passive: false});
    canvas.addEventListener('touchmove', draw, {passive: false});
    canvas.addEventListener('touchend', stopDrawing);
    canvas.addEventListener('touchcancel', stopDrawing);
</script>
