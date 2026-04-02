<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katherine Bank</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh; color: #fff; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        header { text-align: center; margin-bottom: 30px; padding: 25px; background: rgba(255,255,255,0.1); border-radius: 15px; }
        h1 { font-size: 2rem; margin-bottom: 10px; background: linear-gradient(90deg, #00d4ff, #7b2cbf); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .saldo-total { font-size: 2.5rem; font-weight: bold; color: #00d4ff; margin: 15px 0; }
        .tabs { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .tab-btn { padding: 12px 25px; background: rgba(255,255,255,0.1); border: none; border-radius: 10px; color: #fff; cursor: pointer; font-size: 1rem; }
        .tab-btn.active { background: #00d4ff; color: #000; font-weight: bold; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; text-align: center; }
        .stat-value { font-size: 1.5rem; font-weight: bold; color: #00d4ff; }
        .stat-label { color: #aaa; font-size: 0.85rem; margin-top: 5px; }
        
        .cuentas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .cuenta-card { background: rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; border-left: 5px solid; }
        .cuenta-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .cuenta-nombre { font-size: 1.2rem; font-weight: bold; }
        .cuenta-banco { color: #aaa; font-size: 0.9rem; }
        .cuenta-saldo { font-size: 1.8rem; font-weight: bold; }
        .cuenta-tipo { display: inline-block; padding: 5px 10px; border-radius: 5px; font-size: 0.75rem; background: rgba(255,255,255,0.2); }
        
        .btn { padding: 12px 24px; border: none; border-radius: 10px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: transform 0.2s; }
        .btn:hover { transform: translateY(-2px); }
        .btn-primary { background: #00d4ff; color: #000; }
        .btn-secondary { background: rgba(255,255,255,0.2); color: #fff; }
        .btn-danger { background: #FF6384; color: #fff; }
        
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; }
        .modal.active { display: flex; align-items: center; justify-content: center; }
        .modal-content { background: #1a1a2e; padding: 30px; border-radius: 20px; width: 90%; max-width: 500px; }
        .modal h2 { margin-bottom: 20px; color: #00d4ff; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: #aaa; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.2); background: rgba(0,0,0,0.3); color: #fff; }
        
        .pagos-list { display: flex; flex-direction: column; gap: 10px; }
        .pago-item { display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.1); padding: 15px; border-radius: 10px; }
        .pago-info { display: flex; align-items: center; gap: 15px; }
        .pago-icon { font-size: 1.5rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .pago-detalles { display: flex; flex-direction: column; }
        .pago-desc { font-weight: bold; }
        .pago-fecha { color: #aaa; font-size: 0.85rem; }
        .pago-cuenta { color: #aaa; font-size: 0.8rem; }
        .pago-monto { font-size: 1.2rem; font-weight: bold; color: #FF6384; }
        
        .filtros { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
        .filtro-btn { padding: 8px 16px; background: rgba(255,255,255,0.1); border: none; border-radius: 8px; color: #fff; cursor: pointer; }
        .filtro-btn.active { background: #00d4ff; color: #000; }
        
        .chart-container { height: 300px; display: flex; align-items: flex-end; gap: 10px; padding: 20px; background: rgba(255,255,255,0.05); border-radius: 15px; margin-bottom: 20px; }
        .chart-bar { flex: 1; border-radius: 8px 8px 0 0; transition: height 0.3s; position: relative; }
        .chart-bar:hover { opacity: 0.8; }
        .chart-label { position: absolute; bottom: -25px; left: 50%; transform: translateX(-50%); font-size: 0.75rem; color: #aaa; white-space: nowrap; }
        .chart-value { position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-size: 0.8rem; color: #fff; }
        
        .resumen-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .resumen-card { background: rgba(255,255,255,0.1); border-radius: 15px; padding: 20px; }
        .resumen-titulo { font-size: 1.1rem; color: #00d4ff; margin-bottom: 15px; }
        
        .categoria-item { display: flex; align-items: center; gap: 10px; padding: 10px; border-radius: 8px; margin-bottom: 8px; }
        .categoria-icon { font-size: 1.2rem; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .categoria-nombre { flex: 1; }
        .categoria-monto { font-weight: bold; }
        
        .empty-state { text-align: center; padding: 40px; color: #aaa; }
        
        @media (max-width: 768px) { 
            .container { padding: 10px; } 
            h1 { font-size: 1.3rem; } 
            .tabs { 
                display: flex; 
                gap: 5px; 
                overflow-x: auto; 
                padding-bottom: 10px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .tabs::-webkit-scrollbar { display: none; }
            .tab-btn { 
                padding: 10px 15px; 
                font-size: 0.85rem; 
                white-space: nowrap;
                flex-shrink: 0;
            }
            body { padding: 10px; }
            header { padding: 15px; margin-bottom: 15px; }
            .saldo-total { font-size: 1.8rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
            .stat-card { padding: 12px; }
            .stat-value { font-size: 1.2rem; }
            .stat-label { font-size: 0.7rem; }
            .cuentas-grid { grid-template-columns: 1fr; gap: 15px; }
            .cuenta-card { padding: 15px; }
            .cuenta-nombre { font-size: 1rem; }
            .cuenta-saldo { font-size: 1.4rem; }
            .btn { padding: 12px 20px; font-size: 0.9rem; width: 100%; margin-bottom: 10px; }
            .modal-content { padding: 20px; width: 95%; max-height: 90vh; overflow-y: auto; }
            .form-group { margin-bottom: 12px; }
            .form-group input, .form-group select { padding: 10px; font-size: 16px; }
            .filtros { gap: 5px; }
            .filtro-btn { padding: 8px 12px; font-size: 0.8rem; }
            .pago-item { padding: 12px; flex-direction: column; align-items: flex-start; gap: 10px; }
            .pago-info { width: 100%; }
            .pago-monto { align-self: flex-end; }
            .resumen-grid { grid-template-columns: 1fr; }
            .categoria-item { padding: 8px; }
        }
        
        @media (max-width: 480px) {
            .tabs { gap: 3px; }
            .tab-btn { padding: 8px 12px; font-size: 0.75rem; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .stat-card { padding: 10px; }
            .stat-value { font-size: 1rem; }
            .stat-label { font-size: 0.65rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>💰 Katherine Bank</h1>
            <div class="saldo-total" id="saldoTotal">$0</div>
            <p style="color: #aaa">Saldo Total</p>
        </header>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('inicio')">🏠 Inicio</button>
            <button class="tab-btn" onclick="switchTab('cuentas')">🏦 Cuentas</button>
            <button class="tab-btn" onclick="switchTab('pagos')">💳 Pagos</button>
            <button class="tab-btn" onclick="switchTab('resumen')">📊 Resumen</button>
        </div>
        
        <div id="tab-inicio" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value" id="statIngresos">$0</div>
                    <div class="stat-label">Ingresos del Mes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="statGastos">$0</div>
                    <div class="stat-label">Gastos del Mes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="statCuentas">0</div>
                    <div class="stat-label">Cuentas Activas</div>
                </div>
            </div>
            <button class="btn btn-primary" onclick="openModal('nuevo-pago')" style="margin-bottom: 20px;">➕ Nuevo Pago</button>
            <h3 style="margin-bottom: 15px;">Últimos Pagos</h3>
            <div class="pagos-list" id="ultimosPagos"></div>
        </div>
        
        <div id="tab-cuentas" class="tab-content">
            <button class="btn btn-primary" onclick="openModal('nueva-cuenta')" style="margin-bottom: 20px;">➕ Nueva Cuenta</button>
            <button class="btn btn-secondary" onclick="openModal('nuevo-ingreso')">💵 Agregar Ingreso</button>
            <div class="cuentas-grid" id="cuentasGrid" style="margin-top: 20px;"></div>
        </div>
        
        <div id="tab-pagos" class="tab-content">
            <div class="filtros">
                <button class="filtro-btn" onclick="setFiltro('dia')" data-filtro="dia">Hoy</button>
                <button class="filtro-btn" onclick="setFiltro('semana')" data-filtro="semana">Semana</button>
                <button class="filtro-btn active" onclick="setFiltro('mes')" data-filtro="mes">Mes</button>
                <button class="filtro-btn" onclick="setFiltro('año')" data-filtro="año">Año</button>
            </div>
            <button class="btn btn-primary" onclick="openModal('nuevo-pago')" style="margin-bottom: 20px;">➕ Nuevo Pago</button>
            <div class="pagos-list" id="pagosList"></div>
        </div>
        
        <div id="tab-resumen" class="tab-content">
            <div class="resumen-grid">
                <div class="resumen-card">
                    <div class="resumen-titulo">Gastos por Categoría</div>
                    <div id="resumenCategoria"></div>
                </div>
                <div class="resumen-card">
                    <div class="resumen-titulo">Gastos por Cuenta</div>
                    <div id="resumenCuenta"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal" id="modal-nueva-cuenta">
        <div class="modal-content">
            <h2>Nueva Cuenta</h2>
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" id="cuenta-nombre" placeholder="Mi Cuenta">
            </div>
            <div class="form-group">
                <label>Banco</label>
                <input type="text" id="cuenta-banco" placeholder="Banco de Chile">
            </div>
            <div class="form-group">
                <label>Tipo</label>
                <select id="cuenta-tipo">
                    <option value="bancaria">Bancaria</option>
                    <option value="efectivo">Efectivo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Saldo Inicial</label>
                <input type="number" id="cuenta-saldo" step="0.01" value="0">
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="color" id="cuenta-color" value="#00d4ff">
            </div>
            <button class="btn btn-primary" onclick="crearCuenta()" style="width: 100%;">Crear Cuenta</button>
            <button class="btn btn-secondary" onclick="closeModal('nueva-cuenta')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    
    <div class="modal" id="modal-nuevo-pago">
        <div class="modal-content">
            <h2>Nuevo Pago</h2>
            <div class="form-group">
                <label>Cuenta</label>
                <select id="pago-cuenta"></select>
            </div>
            <div class="form-group">
                <label>Categoría</label>
                <select id="pago-categoria"></select>
            </div>
            <div class="form-group">
                <label>Monto</label>
                <input type="number" id="pago-monto" step="0.01">
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <input type="text" id="pago-descripcion">
            </div>
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" id="pago-fecha">
            </div>
            <button class="btn btn-primary" onclick="crearPago()" style="width: 100%;">Registrar Pago</button>
            <button class="btn btn-secondary" onclick="closeModal('nuevo-pago')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    
    <div class="modal" id="modal-nuevo-ingreso">
        <div class="modal-content">
            <h2>Nuevo Ingreso</h2>
            <div class="form-group">
                <label>Cuenta</label>
                <select id="ingreso-cuenta"></select>
            </div>
            <div class="form-group">
                <label>Monto</label>
                <input type="number" id="ingreso-monto" step="0.01">
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <input type="text" id="ingreso-descripcion">
            </div>
            <div class="form-group">
                <label>Fecha</label>
                <input type="date" id="ingreso-fecha">
            </div>
            <button class="btn btn-primary" onclick="crearIngreso()" style="width: 100%;">Registrar Ingreso</button>
            <button class="btn btn-secondary" onclick="closeModal('nuevo-ingreso')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>

    <script>
        const API = '/katherine-bank/api.php';
        let cuentas = [];
        let categorias = [];
        let currentFiltro = 'mes';

        function formatCLP(amount) {
            return '$' + Math.round(amount).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        async function loadData() {
            try {
                cuentas = await fetch(API + '?action=cuentas').then(r => r.json());
                categorias = await fetch(API + '?action=categorias').then(r => r.json());
                loadResumen();
                loadPagos();
            } catch (e) { console.error(e); }
        }

        async function loadResumen() {
            const data = await fetch(API + '?action=resumen&filtro=' + currentFiltro).then(r => r.json());
            document.getElementById('saldoTotal').textContent = formatCLP(data.saldos.reduce((a, c) => a + parseFloat(c.saldo), 0));
            document.getElementById('statIngresos').textContent = formatCLP(0);
            document.getElementById('statGastos').textContent = formatCLP(data.total_gastado);
            document.getElementById('statCuentas').textContent = data.saldos.length;
            
            renderCuentas(data.saldos);
            renderResumen(data);
        }

        function renderCuentas(saldos) {
            const grid = document.getElementById('cuentasGrid');
            grid.innerHTML = saldos.map(c => `
                <div class="cuenta-card" style="border-color: ${c.color}">
                    <div class="cuenta-header">
                        <div>
                            <div class="cuenta-nombre">${c.nombre}</div>
                            <div class="cuenta-banco">${c.tipo === 'efectivo' ? '💵 Efectivo' : '🏦 ' + c.nombre}</div>
                        </div>
                        <span class="cuenta-tipo">${c.tipo === 'efectivo' ? 'Efectivo' : 'Bancaria'}</span>
                    </div>
                    <div class="cuenta-saldo" style="color: ${c.saldo >= 0 ? '#00d4ff' : '#FF6384'}">${formatCLP(c.saldo)}</div>
                </div>
            `).join('');
        }

        function renderResumen(data) {
            const catDiv = document.getElementById('resumenCategoria');
            catDiv.innerHTML = data.por_categoria.map(c => `
                <div class="categoria-item">
                    <div class="categoria-icon" style="background: ${c.color}20">${c.icono}</div>
                    <div class="categoria-nombre">${c.nombre}</div>
                    <div class="categoria-monto">${formatCLP(c.total)}</div>
                </div>
            `).join('') || '<p style="color:#aaa">Sin datos</p>';
            
            const cueDiv = document.getElementById('resumenCuenta');
            cueDiv.innerHTML = data.por_cuenta.map(c => `
                <div class="categoria-item">
                    <div class="categoria-icon" style="background: ${c.color}20">🏦</div>
                    <div class="categoria-nombre">${c.nombre}</div>
                    <div class="categoria-monto">${formatCLP(c.total)}</div>
                </div>
            `).join('') || '<p style="color:#aaa">Sin datos</p>';
        }

        async function loadPagos() {
            const pagos = await fetch(API + '?action=pagos&filtro=' + currentFiltro).then(r => r.json());
            renderPagosList(pagos, 'ultimosPagos');
            renderPagosList(pagos, 'pagosList');
        }

        function renderPagosList(pagos, elementId) {
            const div = document.getElementById(elementId);
            if (pagos.length === 0) {
                div.innerHTML = '<div class="empty-state">No hay pagos registrados</div>';
                return;
            }
            div.innerHTML = pagos.slice(0, elementId === 'ultimosPagos' ? 5 : 50).map(p => `
                <div class="pago-item">
                    <div class="pago-info">
                        <div class="pago-icon" style="background: ${p.categoria_color}30">${p.categoria_icono}</div>
                        <div class="pago-detalles">
                            <div class="pago-desc">${p.descripcion || p.categoria_nombre}</div>
                            <div class="pago-fecha">${p.fecha}</div>
                            <div class="pago-cuenta">${p.cuenta_nombre}</div>
                        </div>
                    </div>
                    <div class="pago-monto">-${formatCLP(p.monto)}</div>
                </div>
            `).join('');
        }

        function setFiltro(filtro) {
            currentFiltro = filtro;
            document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active'));
            document.querySelector(`[data-filtro="${filtro}"]`).classList.add('active');
            loadResumen();
            loadPagos();
        }

        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
            document.querySelector(`[onclick="switchTab('${tab}')"]`).classList.add('active');
            document.getElementById('tab-' + tab).classList.add('active');
        }

        function openModal(modal) {
            document.getElementById('modal-' + modal).classList.add('active');
            if (modal === 'nuevo-pago' || modal === 'nuevo-ingreso') {
                document.getElementById('pago-fecha').value = new Date().toISOString().split('T')[0];
                document.getElementById('ingreso-fecha').value = new Date().toISOString().split('T')[0];
                const cuentaSelect = document.getElementById(modal === 'nuevo-pago' ? 'pago-cuenta' : 'ingreso-cuenta');
                cuentaSelect.innerHTML = cuentas.map(c => `<option value="${c.id}">${c.nombre} (${formatCLP(c.saldo)})</option>`).join('');
            }
            if (modal === 'nuevo-pago') {
                document.getElementById('pago-categoria').innerHTML = categorias.map(c => `<option value="${c.id}">${c.icono} ${c.nombre}</option>`).join('');
            }
        }

        function closeModal(modal) {
            document.getElementById('modal-' + modal).classList.remove('active');
        }

        async function crearCuenta() {
            const data = {
                nombre: document.getElementById('cuenta-nombre').value,
                banco: document.getElementById('cuenta-banco').value,
                tipo: document.getElementById('cuenta-tipo').value,
                saldo: parseFloat(document.getElementById('cuenta-saldo').value),
                color: document.getElementById('cuenta-color').value
            };
            await fetch(API + '?action=cuenta', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            closeModal('nueva-cuenta');
            loadData();
        }

        async function crearPago() {
            const data = {
                cuenta_id: parseInt(document.getElementById('pago-cuenta').value),
                categoria_id: parseInt(document.getElementById('pago-categoria').value),
                monto: parseFloat(document.getElementById('pago-monto').value),
                descripcion: document.getElementById('pago-descripcion').value,
                fecha: document.getElementById('pago-fecha').value
            };
            await fetch(API + '?action=pago', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            closeModal('nuevo-pago');
            loadData();
        }

        async function crearIngreso() {
            const data = {
                cuenta_id: parseInt(document.getElementById('ingreso-cuenta').value),
                monto: parseFloat(document.getElementById('ingreso-monto').value),
                descripcion: document.getElementById('ingreso-descripcion').value,
                fecha: document.getElementById('ingreso-fecha').value
            };
            await fetch(API + '?action=ingreso', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(data)
            });
            closeModal('nuevo-ingreso');
            loadData();
        }

        loadData();
    </script>
</body>
</html>