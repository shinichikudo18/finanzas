<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katherine Bank</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #ff69b4;
            --primary-dark: #c71585;
            --secondary: #9b59b6;
            --accent: #f1c40f;
            --gold: #ffd700;
            --bg-dark: #1a1a2e;
            --bg-card: rgba(255,255,255,0.08);
            --text: #fff;
            --text-muted: #b8b8b8;
            --danger: #e74c3c;
            --success: #2ecc71;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #2d1b4e 70%, #1a1a2e 100%); min-height: 100vh; color: var(--text); padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        
        header { text-align: center; margin-bottom: 30px; padding: 30px; background: linear-gradient(135deg, rgba(255,105,180,0.15) 0%, rgba(155,89,182,0.15) 100%); border-radius: 20px; border: 1px solid rgba(255,105,180,0.2); backdrop-filter: blur(10px); }
        h1 { font-size: 2.2rem; margin-bottom: 15px; background: linear-gradient(90deg, #ff69b4, #ffd700, #ff69b4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-size: 200% auto; animation: shimmer 3s linear infinite; }
        @keyframes shimmer { to { background-position: 200% center; } }
        .saldo-total { font-size: 2.8rem; font-weight: 700; background: linear-gradient(90deg, #ffd700, #ffec8b, #ffd700); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 15px 0; text-shadow: 0 0 30px rgba(255,215,0,0.3); }
        
        .tabs { display: flex; gap: 8px; margin-bottom: 25px; flex-wrap: wrap; justify-content: center; }
        .tab-btn { padding: 12px 28px; background: var(--bg-card); border: 1px solid rgba(255,105,180,0.2); border-radius: 25px; color: var(--text); cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.3s ease; }
        .tab-btn:hover { background: rgba(255,105,180,0.2); transform: translateY(-2px); }
        .tab-btn.active { background: linear-gradient(135deg, #ff69b4, #c71585); color: #fff; font-weight: 600; box-shadow: 0 4px 20px rgba(255,105,180,0.4); }
        
        .tab-content { display: none; animation: fadeIn 0.3s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: var(--bg-card); border-radius: 20px; padding: 20px; text-align: center; border: 1px solid rgba(255,255,255,0.1); transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); border-color: rgba(255,105,180,0.3); box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
        .stat-value { font-size: 1.6rem; font-weight: 700; background: linear-gradient(90deg, #ff69b4, #ffd700); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .stat-label { color: var(--text-muted); font-size: 0.8rem; margin-top: 5px; text-transform: uppercase; letter-spacing: 1px; }
        
        .cuentas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .cuenta-card { background: var(--bg-card); border-radius: 20px; padding: 20px; border-left: 4px solid; transition: all 0.3s ease; position: relative; overflow: hidden; }
        .cuenta-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(255,105,180,0.05) 0%, transparent 100%); pointer-events: none; }
        .cuenta-card:hover { transform: translateY(-5px); box-shadow: 0 15px 40px rgba(0,0,0,0.3); }
        .cuenta-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; position: relative; z-index: 1; }
        .cuenta-nombre { font-size: 1.3rem; font-weight: 600; }
        .cuenta-banco { color: var(--text-muted); font-size: 0.85rem; margin-top: 3px; }
        .cuenta-saldo { font-size: 1.9rem; font-weight: 700; margin-top: 10px; }
        .cuenta-tipo { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; background: rgba(255,105,180,0.2); color: #ff69b4; }
        
        .btn { padding: 12px 28px; border: none; border-radius: 25px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.3s ease; }
        .btn:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .btn-primary { background: linear-gradient(135deg, #ff69b4, #c71585); color: #fff; }
        .btn-secondary { background: var(--bg-card); color: var(--text); border: 1px solid rgba(255,255,255,0.2); }
        .btn:hover { transform: translateY(-2px); }
        
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1000; backdrop-filter: blur(5px); }
        .modal.active { display: flex; align-items: center; justify-content: center; animation: fadeIn 0.3s ease; }
        .modal-content { background: linear-gradient(135deg, #1a1a2e, #2d1b4e); padding: 30px; border-radius: 25px; width: 90%; max-width: 500px; border: 1px solid rgba(255,105,180,0.3); box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
        .modal h2 { margin-bottom: 25px; background: linear-gradient(90deg, #ff69b4, #ffd700); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.5rem; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--text-muted); font-size: 0.9rem; }
        .form-group input, .form-group select { width: 100%; padding: 14px; border-radius: 12px; border: 1px solid rgba(255,105,180,0.2); background: rgba(0,0,0,0.3); color: #fff; font-size: 1rem; transition: all 0.3s ease; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #ff69b4; box-shadow: 0 0 15px rgba(255,105,180,0.3); }
        
        .pagos-list { display: flex; flex-direction: column; gap: 12px; }
        .pago-item { display: flex; justify-content: space-between; align-items: center; background: var(--bg-card); padding: 15px 20px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05); transition: all 0.3s ease; }
        .pago-item:hover { border-color: rgba(255,105,180,0.2); transform: translateX(5px); }
        .pago-info { display: flex; align-items: center; gap: 15px; }
        .pago-icon { font-size: 1.5rem; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
        .pago-detalles { display: flex; flex-direction: column; }
        .pago-desc { font-weight: 600; font-size: 1rem; }
        .pago-fecha { color: var(--text-muted); font-size: 0.8rem; margin-top: 2px; }
        .pago-cuenta { color: var(--text-muted); font-size: 0.75rem; }
        .pago-monto { font-size: 1.3rem; font-weight: 700; color: #e74c3c; }
        .pago-monto.positivo { color: #2ecc71; }
        
        .filtros { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; justify-content: center; }
        .filtro-btn { padding: 8px 20px; background: var(--bg-card); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; color: var(--text); cursor: pointer; font-size: 0.85rem; transition: all 0.3s ease; }
        .filtro-btn:hover { background: rgba(255,105,180,0.2); }
        .filtro-btn.active { background: linear-gradient(135deg, #9b59b6, #6c3483); color: #fff; }
        
        .resumen-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .resumen-card { background: var(--bg-card); border-radius: 20px; padding: 25px; border: 1px solid rgba(255,255,255,0.05); }
        .resumen-titulo { font-size: 1.2rem; background: linear-gradient(90deg, #ff69b4, #ffd700); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 20px; font-weight: 600; }
        .categoria-item { display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 12px; margin-bottom: 10px; transition: all 0.3s ease; }
        .categoria-item:hover { background: rgba(255,105,180,0.1); }
        .categoria-icon { font-size: 1.3rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
        .categoria-nombre { flex: 1; font-weight: 500; }
        .categoria-monto { font-weight: 700; color: #e74c3c; }
        
        .empty-state { text-align: center; padding: 50px; color: var(--text-muted); }
        .empty-state-icon { font-size: 4rem; margin-bottom: 15px; opacity: 0.5; }
        
        .options-menu { position: relative; }
        .options-btn { padding: 8px 12px; background: rgba(255,255,255,0.1); border: none; border-radius: 10px; color: #fff; cursor: pointer; font-size: 1.2rem; transition: all 0.3s ease; }
        .options-btn:hover { background: rgba(255,105,180,0.3); }
        .options-dropdown { display: none; position: absolute; right: 0; top: 40px; background: linear-gradient(135deg, #2d1b4e, #1a1a2e); border-radius: 12px; padding: 8px; min-width: 150px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); z-index: 50; border: 1px solid rgba(255,105,180,0.2); }
        .options-dropdown.show { display: block; animation: fadeIn 0.2s ease; }
        .options-dropdown button { width: 100%; padding: 10px 15px; background: transparent; border: none; color: #fff; cursor: pointer; text-align: left; font-size: 0.9rem; border-radius: 8px; transition: all 0.2s ease; }
        .options-dropdown button:hover { background: rgba(255,105,180,0.2); }
        .options-dropdown .delete-btn { color: #e74c3c; }
        
        @media (max-width: 768px) { 
            .container { padding: 5px; } 
            h1 { font-size: 1.5rem; } 
            .tabs { overflow-x: auto; padding-bottom: 10px; } 
            body { padding: 10px; } 
            header { padding: 20px; margin-bottom: 15px; } 
            .saldo-total { font-size: 2rem; } 
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } 
            .cuentas-grid { grid-template-columns: 1fr; gap: 15px; } 
            .btn { width: 100%; margin-bottom: 10px; } 
            .modal-content { padding: 20px; width: 95%; } 
            .pago-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .pago-monto { align-self: flex-end; }
        }
    </style>
</head>
<body>
    <div id="login-screen" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:linear-gradient(135deg,#1a1a2e,#2d1b4e,#1a1a2e);z-index:2000;align-items:center;justify-content:center;">
        <div style="background:linear-gradient(135deg,rgba(45,27,78,0.9),rgba(26,26,46,0.9));padding:40px;border-radius:25px;width:90%;max-width:400px;text-align:center;border:1px solid rgba(255,105,180,0.3);box-shadow:0 20px 60px rgba(0,0,0,0.5);">
            <img src="https://i.postimg.cc/4Nf7WvxG/Gemini-Generated-Image-9j5a449j5a449j5a-removebg-preview.png" style="height:80px;margin-bottom:20px;">
            <h2 style="background:linear-gradient(90deg,#ff69b4,#ffd700);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:30px;font-size:1.8rem;">Katherine Bank</h2>
            <input type="text" id="login-user" placeholder="Usuario" style="width:100%;padding:15px;margin-bottom:15px;border-radius:12px;border:1px solid rgba(255,105,180,0.3);background:rgba(0,0,0,0.3);color:#fff;font-size:16px;">
            <input type="password" id="login-pass" placeholder="Contrasena" style="width:100%;padding:15px;margin-bottom:20px;border-radius:12px;border:1px solid rgba(255,105,180,0.3);background:rgba(0,0,0,0.3);color:#fff;font-size:16px;">
            <button onclick="login()" style="width:100%;padding:15px;background:linear-gradient(135deg,#ff69b4,#c71585);border:none;border-radius:12px;color:#fff;font-size:1rem;font-weight:bold;cursor:pointer;transition:all 0.3s ease;">Iniciar Sesion</button>
        </div>
    </div>
    <div id="app" style="display:none;">
    <div class="container">
        <header>
            <h1><img src="https://i.postimg.cc/4Nf7WvxG/Gemini-Generated-Image-9j5a449j5a449j5a-removebg-preview.png" alt="Logo" style="height:50px;vertical-align:middle;margin-right:10px;"> Katherine Bank</h1>
            <div class="saldo-total" id="saldoTotal">$0</div>
            <p style="color: #aaa; display: flex; align-items: center; justify-content: center; gap: 10px;">
                Saldo Total 
                <div style="position: relative;">
                    <button onclick="toggleSettings()" style="padding:8px 15px;background:rgba(255,255,255,0.2);border:none;border-radius:5px;color:#fff;cursor:pointer;font-size:0.9rem;">⚙️ Settings</button>
                    <div id="settings-menu" style="display:none;position:absolute;right:0;top:35px;background:#1a1a2e;border-radius:10px;padding:10px;min-width:180px;box-shadow:0 4px 15px rgba(0,0,0,0.5);z-index:100;">
                        <button onclick="openModal('cambiar-pass')" style="width:100%;padding:10px;background:transparent;border:none;color:#fff;cursor:pointer;text-align:left;font-size:0.9rem;">🔑 Cambiar Contrasena</button>
                        <button onclick="logout()" style="width:100%;padding:10px;background:transparent;border:none;color:#FF6384;cursor:pointer;text-align:left;font-size:0.9rem;">🚪 Cerrar Sesion</button>
                    </div>
                </div>
            </p>
        </header>
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('inicio')">Inicio</button>
            <button class="tab-btn" onclick="switchTab('cuentas')">Cuentas</button>
            <button class="tab-btn" onclick="switchTab('pagos')">Pagos</button>
            <button class="tab-btn" onclick="switchTab('resumen')">Resumen</button>
        </div>
        <div id="tab-inicio" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-value" id="statIngresos">$0</div><div class="stat-label">Ingresos del Mes</div></div>
                <div class="stat-card"><div class="stat-value" id="statGastos">$0</div><div class="stat-label">Gastos del Mes</div></div>
                <div class="stat-card"><div class="stat-value" id="statCuentas">0</div><div class="stat-label">Cuentas Activas</div></div>
            </div>
            <button class="btn btn-primary" onclick="openModal('nuevo-pago')" style="margin-bottom: 20px;">+ Nuevo Pago</button>
            <h3 style="margin-bottom: 15px;">Ultimos Pagos</h3>
            <div class="pagos-list" id="ultimosPagos"></div>
        </div>
        <div id="tab-cuentas" class="tab-content">
            <button class="btn btn-primary" onclick="openModal('nueva-cuenta')" style="margin-bottom: 20px;">+ Nueva Cuenta</button>
            <button class="btn btn-secondary" onclick="openModal('nuevo-ingreso')">+ Agregar Ingreso</button>
            <div class="cuentas-grid" id="cuentasGrid" style="margin-top: 20px;"></div>
        </div>
        <div id="tab-pagos" class="tab-content">
            <div class="filtros">
                <button class="filtro-btn" onclick="setFiltro('dia')" data-filtro="dia">Hoy</button>
                <button class="filtro-btn" onclick="setFiltro('semana')" data-filtro="semana">Semana</button>
                <button class="filtro-btn active" onclick="setFiltro('mes')" data-filtro="mes">Mes</button>
                <button class="filtro-btn" onclick="setFiltro('ano')" data-filtro="ano">Ano</button>
            </div>
            <button class="btn btn-primary" onclick="openModal('nuevo-pago')" style="margin-bottom: 20px;">+ Nuevo Pago</button>
            <div class="pagos-list" id="pagosList"></div>
        </div>
        <div id="tab-resumen" class="tab-content">
            <div class="resumen-grid">
                <div class="resumen-card"><div class="resumen-titulo">Gastos por Categoria</div><div id="resumenCategoria"></div></div>
                <div class="resumen-card"><div class="resumen-titulo">Gastos por Cuenta</div><div id="resumenCuenta"></div></div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal-nueva-cuenta">
        <div class="modal-content">
            <h2>Nueva Cuenta</h2>
            <div class="form-group"><label>Nombre</label><input type="text" id="cuenta-nombre" placeholder="Mi Cuenta"></div>
            <div class="form-group"><label>Banco</label><input type="text" id="cuenta-banco" placeholder="Banco de Chile"></div>
            <div class="form-group"><label>Tipo</label><select id="cuenta-tipo"><option value="bancaria">Bancaria</option><option value="efectivo">Efectivo</option></select></div>
            <div class="form-group"><label>Saldo Inicial</label><input type="number" id="cuenta-saldo" step="0.01" value="0"></div>
            <div class="form-group"><label>Color</label><input type="color" id="cuenta-color" value="#ff69b4"></div>
            <button class="btn btn-primary" onclick="crearCuenta()" style="width: 100%;">Crear Cuenta</button>
            <button class="btn btn-secondary" onclick="closeModal('nueva-cuenta')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    <div class="modal" id="modal-editar-cuenta">
        <div class="modal-content">
            <h2>Editar Cuenta</h2>
            <input type="hidden" id="edit-cuenta-id">
            <div class="form-group"><label>Nombre</label><input type="text" id="edit-cuenta-nombre"></div>
            <div class="form-group"><label>Tipo</label><select id="edit-cuenta-tipo"><option value="bancaria">Bancaria</option><option value="efectivo">Efectivo</option></select></div>
            <div class="form-group"><label>Saldo</label><input type="number" id="edit-cuenta-saldo" step="0.01"></div>
            <div class="form-group"><label>Color</label><input type="color" id="edit-cuenta-color"></div>
            <button class="btn btn-primary" onclick="actualizarCuenta()" style="width: 100%;">Guardar Cambios</button>
            <button class="btn btn-secondary" onclick="closeModal('editar-cuenta')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    <div class="modal" id="modal-nuevo-pago">
        <div class="modal-content">
            <h2>Nuevo Pago</h2>
            <div class="form-group"><label>Cuenta</label><select id="pago-cuenta"></select></div>
            <div class="form-group"><label>Categoria</label><select id="pago-categoria"></select></div>
            <div class="form-group"><label>Monto</label><input type="number" id="pago-monto" step="0.01"></div>
            <div class="form-group"><label>Descripcion</label><input type="text" id="pago-descripcion"></div>
            <div class="form-group"><label>Fecha</label><input type="date" id="pago-fecha"></div>
            <button class="btn btn-primary" onclick="crearPago()" style="width: 100%;">Registrar Pago</button>
            <button class="btn btn-secondary" onclick="closeModal('nuevo-pago')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    <div class="modal" id="modal-nuevo-ingreso">
        <div class="modal-content">
            <h2>Nuevo Ingreso</h2>
            <div class="form-group"><label>Cuenta</label><select id="ingreso-cuenta"></select></div>
            <div class="form-group"><label>Monto</label><input type="number" id="ingreso-monto" step="0.01"></div>
            <div class="form-group"><label>Descripcion</label><input type="text" id="ingreso-descripcion"></div>
            <div class="form-group"><label>Fecha</label><input type="date" id="ingreso-fecha"></div>
            <button class="btn btn-primary" onclick="crearIngreso()" style="width: 100%;">Registrar Ingreso</button>
            <button class="btn btn-secondary" onclick="closeModal('nuevo-ingreso')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    <div class="modal" id="modal-cambiar-pass">
        <div class="modal-content">
            <h2>Cambiar Contrasena</h2>
            <div class="form-group"><label>Contrasena Actual</label><input type="password" id="pass-actual"></div>
            <div class="form-group"><label>Nueva Contrasena</label><input type="password" id="pass-nueva"></div>
            <div class="form-group"><label>Confirmar Contrasena</label><input type="password" id="pass-confirmar"></div>
            <button class="btn btn-primary" onclick="cambiarPassword()" style="width: 100%;">Cambiar Contrasena</button>
            <button class="btn btn-secondary" onclick="closeModal('cambiar-pass')" style="width: 100%; margin-top: 10px;">Cancelar</button>
        </div>
    </div>
    </div>
    <script>
        const API = '/api.php';
        let cuentas = [];
        let categorias = [];
        let currentFiltro = 'mes';

        function checkLogin() {
            const savedUser = localStorage.getItem('katherine_bank_user');
            if (savedUser) { showApp(); }
            else { document.getElementById('login-screen').style.display = 'flex'; document.getElementById('app').style.display = 'none'; }
        }

        function login() {
            const user = document.getElementById('login-user').value;
            const pass = document.getElementById('login-pass').value;
            const savedPass = localStorage.getItem('katherine_bank_pass') || 'Katherine2025!';
            if (user === 'katherine' && pass === savedPass) {
                localStorage.setItem('katherine_bank_user', user);
                showApp();
            } else { alert('Usuario o contrasena incorrectos'); }
        }

        function logout() { document.getElementById('settings-menu').style.display='none'; localStorage.removeItem('katherine_bank_user'); location.reload(); }

        function toggleSettings() { const m=document.getElementById('settings-menu'); m.style.display=m.style.display==='none'?'block':'none'; }

        function showApp() { document.getElementById('login-screen').style.display = 'none'; document.getElementById('app').style.display = 'block'; loadData(); }

        function formatCLP(amount) { return '$' + Math.round(amount || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

        async function loadData() {
            try {
                cuentas = await fetch(API + '?action=cuentas').then(r => r.json());
                categorias = await fetch(API + '?action=categorias').then(r => r.json());
                loadResumen(); loadPagos();
            } catch (e) { console.error(e); }
        }

        async function loadResumen() {
            const data = await fetch(API + '?action=resumen&filtro=' + currentFiltro).then(r => r.json());
            document.getElementById('saldoTotal').textContent = formatCLP((data.saldos || []).reduce((a, c) => a + parseFloat(c.saldo || 0), 0));
            document.getElementById('statIngresos').textContent = formatCLP(data.total_ingresado || 0);
            document.getElementById('statGastos').textContent = formatCLP(data.total_gastado || 0);
            document.getElementById('statCuentas').textContent = (data.saldos || []).length;
            renderCuentas(data.saldos || []); renderResumen(data);
        }

        function renderCuentas(saldos) {
            const grid = document.getElementById('cuentasGrid');
            grid.innerHTML = saldos.length ? saldos.map(c => `<div class="cuenta-card" style="border-color:${c.color}">
                <div class="cuenta-header">
                    <div>
                        <div class="cuenta-nombre">${c.nombre}</div>
                        <div class="cuenta-banco">${c.tipo === 'efectivo' ? 'Efectivo' : c.nombre}</div>
                    </div>
                    <div class="options-menu">
                        <button class="options-btn" onclick="toggleCuentaMenu(${c.id})">⋮</button>
                        <div class="options-dropdown" id="cuenta-menu-${c.id}">
                            <button onclick="editarCuenta(${c.id}, '${c.nombre}', '${c.tipo}', ${c.saldo || 0}, '${c.color}')">✏️ Editar</button>
                            <button class="delete-btn" onclick="eliminarCuenta(${c.id})">🗑️ Eliminar</button>
                        </div>
                    </div>
                </div>
                <span class="cuenta-tipo">${c.tipo === 'efectivo' ? 'Efectivo' : 'Bancaria'}</span>
                <div class="cuenta-saldo" style="color:${(c.saldo||0)>=0?'#ffd700':'#e74c3c'}">${formatCLP(c.saldo||0)}</div>
            </div>`).join('') : '<div class="empty-state"><div class="empty-state-icon">💳</div>No hay cuentas. Crea una!</div>';
        }

        function toggleCuentaMenu(id) {
            document.querySelectorAll('[id^="cuenta-menu-"]').forEach(m => m.style.display = 'none');
            const menu = document.getElementById('cuenta-menu-' + id);
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        function editarCuenta(id, nombre, tipo, saldo, color) {
            document.querySelectorAll('[id^="cuenta-menu-"]').forEach(m => m.style.display = 'none');
            document.getElementById('edit-cuenta-id').value = id;
            document.getElementById('edit-cuenta-nombre').value = nombre;
            document.getElementById('edit-cuenta-tipo').value = tipo;
            document.getElementById('edit-cuenta-saldo').value = saldo;
            document.getElementById('edit-cuenta-color').value = color;
            document.getElementById('modal-editar-cuenta').classList.add('active');
        }

        function renderResumen(data) {
            document.getElementById('resumenCategoria').innerHTML = (data.por_categoria || []).map(c => `<div class="categoria-item"><div class="categoria-icon" style="background:${c.color}20">${c.icono}</div><div class="categoria-nombre">${c.nombre}</div><div class="categoria-monto">${formatCLP(c.total)}</div></div>`).join('') || '<p style="color:#aaa">Sin datos</p>';
            document.getElementById('resumenCuenta').innerHTML = (data.por_cuenta || []).map(c => `<div class="categoria-item"><div class="categoria-icon" style="background:${c.color}20">🏦</div><div class="categoria-nombre">${c.nombre}</div><div class="categoria-monto">${formatCLP(c.total)}</div></div>`).join('') || '<p style="color:#aaa">Sin datos</p>';
        }

        async function loadPagos() {
            const pagos = await fetch(API + '?action=pagos&filtro=' + currentFiltro).then(r => r.json());
            renderPagosList(pagos || [], 'ultimosPagos');
            renderPagosList(pagos || [], 'pagosList');
        }

        function renderPagosList(pagos, elementId) {
            const div = document.getElementById(elementId);
            div.innerHTML = pagos.length ? pagos.slice(0, elementId==='ultimosPagos'?5:50).map(p => `<div class="pago-item"><div class="pago-info"><div class="pago-icon" style="background:${p.categoria_color}30">${p.categoria_icono}</div><div class="pago-detalles"><div class="pago-desc">${p.descripcion||p.categoria_nombre}</div><div class="pago-fecha">${p.fecha}</div><div class="pago-cuenta">${p.cuenta_nombre}</div></div></div><div class="pago-monto">-${formatCLP(p.monto)}</div></div>`).join('') : '<div class="empty-state">No hay pagos registrados</div>';
        }

        function setFiltro(filtro) { currentFiltro = filtro; document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('active')); document.querySelector('[data-filtro="'+filtro+'"]').classList.add('active'); loadResumen(); loadPagos(); }

        function switchTab(tab) { document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active')); document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active')); document.querySelector('[onclick="switchTab(\''+tab+'\')"]').classList.add('active'); document.getElementById('tab-'+tab).classList.add('active'); }

        function openModal(modal) {
            document.getElementById('modal-'+modal).classList.add('active');
            if (modal === 'nuevo-pago' || modal === 'nuevo-ingreso') {
                document.getElementById('pago-fecha').value = new Date().toISOString().split('T')[0];
                document.getElementById('ingreso-fecha').value = new Date().toISOString().split('T')[0];
                const cuentaSelect = document.getElementById(modal==='nuevo-pago'?'pago-cuenta':'ingreso-cuenta');
                cuentaSelect.innerHTML = cuentas.map(c => `<option value="${c.id}">${c.nombre} (${formatCLP(c.saldo||0)})</option>`).join('');
            }
            if (modal === 'nuevo-pago') document.getElementById('pago-categoria').innerHTML = categorias.map(c => `<option value="${c.id}">${c.icono} ${c.nombre}</option>`).join('');
        }

        function closeModal(modal) { document.getElementById('modal-'+modal).classList.remove('active'); }

        async function crearCuenta() {
            await fetch(API+'?action=cuenta',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({nombre:document.getElementById('cuenta-nombre').value,banco:document.getElementById('cuenta-banco').value,tipo:document.getElementById('cuenta-tipo').value,saldo:parseFloat(document.getElementById('cuenta-saldo').value),color:document.getElementById('cuenta-color').value})});
            closeModal('nueva-cuenta'); loadData();
        }

        async function actualizarCuenta() {
            const id = document.getElementById('edit-cuenta-id').value;
            await fetch(API+'?action=cuenta&id='+id,{method:'PUT',headers:{'Content-Type':'application/json'},body:JSON.stringify({nombre:document.getElementById('edit-cuenta-nombre').value,tipo:document.getElementById('edit-cuenta-tipo').value,saldo:parseFloat(document.getElementById('edit-cuenta-saldo').value),color:document.getElementById('edit-cuenta-color').value})});
            closeModal('editar-cuenta'); loadData();
        }

        async function crearPago() {
            await fetch(API+'?action=pago',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({cuenta_id:parseInt(document.getElementById('pago-cuenta').value),categoria_id:parseInt(document.getElementById('pago-categoria').value),monto:parseFloat(document.getElementById('pago-monto').value),descripcion:document.getElementById('pago-descripcion').value,fecha:document.getElementById('pago-fecha').value})});
            closeModal('nuevo-pago'); loadData();
        }

        async function crearIngreso() {
            await fetch(API+'?action=ingreso',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({cuenta_id:parseInt(document.getElementById('ingreso-cuenta').value),monto:parseFloat(document.getElementById('ingreso-monto').value),descripcion:document.getElementById('ingreso-descripcion').value,fecha:document.getElementById('ingreso-fecha').value})});
            closeModal('nuevo-ingreso'); loadData();
        }

        async function eliminarCuenta(id) {
            if (confirm('Estas seguro de eliminar esta cuenta? Se eliminaran todos los pagos e ingresos asociados.')) {
                await fetch(API+'?action=cuenta&id='+id, {method: 'DELETE'});
                loadData();
            }
        }

        async function cambiarPassword() {
            const actual = document.getElementById('pass-actual').value;
            const nueva = document.getElementById('pass-nueva').value;
            const confirmar = document.getElementById('pass-confirmar').value;
            
            if (actual !== 'Katherine2025!') { alert('Contrasena actual incorrecta'); return; }
            if (nueva !== confirmar) { alert('Las contrasenas no coinciden'); return; }
            if (nueva.length < 4) { alert('La contrasena debe tener al menos 4 caracteres'); return; }
            
            localStorage.setItem('katherine_bank_pass', nueva);
            alert('Contrasena cambiada correctamente');
            closeModal('cambiar-pass');
            document.getElementById('pass-actual').value = '';
            document.getElementById('pass-nueva').value = '';
            document.getElementById('pass-confirmar').value = '';
        }

        checkLogin();
    </script>
</body>
</html>