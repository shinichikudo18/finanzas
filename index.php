<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katherine Bank</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --cyan: #00f0ff;
            --cyan-dark: #00a8b5;
            --purple: #b026ff;
            --pink: #ff2d6a;
            --gold: #ffd700;
            --bg-dark: #0a0a0f;
            --bg-card: rgba(0, 240, 255, 0.03);
            --bg-card-border: rgba(0, 240, 255, 0.15);
            --text: #e0e0e0;
            --text-dim: #6a6a7a;
            --danger: #ff2d6a;
            --success: #00f0ff;
            --glow-cyan: 0 0 20px rgba(0, 240, 255, 0.5);
            --glow-purple: 0 0 20px rgba(176, 38, 255, 0.5);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Rajdhani', sans-serif; background: var(--bg-dark); min-height: 100vh; color: var(--text); padding: 20px; overflow-x: hidden; }
        body::before { content: ''; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: 
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0, 240, 255, 0.03) 2px, rgba(0, 240, 255, 0.03) 4px),
            repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(0, 240, 255, 0.02) 50px, rgba(0, 240, 255, 0.02) 51px); 
            pointer-events: none; z-index: -1; }
        .container { max-width: 1200px; margin: 0 auto; position: relative; }
        
        header { text-align: center; margin-bottom: 30px; padding: 30px; background: linear-gradient(180deg, rgba(0, 240, 255, 0.08) 0%, transparent 100%); border: 1px solid var(--bg-card-border); border-radius: 5px; position: relative; }
        header::before { content: ''; position: absolute; top: -1px; left: 20%; right: 20%; height: 2px; background: linear-gradient(90deg, transparent, var(--cyan), transparent); }
        header::after { content: ''; position: absolute; bottom: -1px; left: 20%; right: 20%; height: 2px; background: linear-gradient(90deg, transparent, var(--purple), transparent); }
        h1 { font-family: 'Orbitron', sans-serif; font-size: 2.5rem; margin-bottom: 15px; color: var(--cyan); text-shadow: var(--glow-cyan); letter-spacing: 4px; text-transform: uppercase; }
        .saldo-total { font-family: 'Orbitron', sans-serif; font-size: 3rem; font-weight: 800; color: var(--gold); margin: 15px 0; text-shadow: 0 0 30px rgba(255, 215, 0, 0.4); letter-spacing: 2px; }
        
        .tabs { display: flex; gap: 5px; margin-bottom: 25px; flex-wrap: wrap; justify-content: center; border-bottom: 1px solid var(--bg-card-border); padding-bottom: 15px; }
        .tab-btn { padding: 12px 30px; background: transparent; border: 1px solid var(--bg-card-border); border-bottom: none; border-radius: 0; color: var(--text-dim); cursor: pointer; font-family: 'Orbitron', sans-serif; font-size: 0.8rem; font-weight: 500; letter-spacing: 2px; text-transform: uppercase; transition: all 0.3s ease; position: relative; }
        .tab-btn::before { content: ''; position: absolute; bottom: -1px; left: 0; right: 0; height: 2px; background: var(--cyan); transform: scaleX(0); transition: transform 0.3s ease; }
        .tab-btn:hover { color: var(--cyan); border-color: var(--cyan); }
        .tab-btn.active { background: rgba(0, 240, 255, 0.1); color: var(--cyan); border-color: var(--cyan); }
        .tab-btn.active::before { transform: scaleX(1); }
        
        .tab-content { display: none; animation: fadeIn 0.3s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 25px; }
        .stat-card { background: var(--bg-card); border: 1px solid var(--bg-card-border); padding: 20px; text-align: center; position: relative; clip-path: polygon(10px 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%, 0 10px); transition: all 0.3s ease; }
        .stat-card:hover { border-color: var(--cyan); box-shadow: var(--glow-cyan); transform: translateY(-3px); }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 8px; height: 8px; border-top: 2px solid var(--cyan); border-left: 2px solid var(--cyan); }
        .stat-card::after { content: ''; position: absolute; bottom: 0; right: 0; width: 8px; height: 8px; border-bottom: 2px solid var(--cyan); border-right: 2px solid var(--cyan); }
        .stat-value { font-family: 'Orbitron', sans-serif; font-size: 1.5rem; font-weight: 700; color: var(--cyan); text-shadow: 0 0 10px rgba(0, 240, 255, 0.5); }
        .stat-label { color: var(--text-dim); font-size: 0.75rem; margin-top: 5px; text-transform: uppercase; letter-spacing: 2px; }
        
        .cuentas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 25px; }
        .cuenta-card { background: var(--bg-card); border: 1px solid var(--bg-card-border); padding: 20px; position: relative; clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%); transition: all 0.3s ease; }
        .cuenta-card:hover { border-color: var(--purple); box-shadow: var(--glow-purple); }
        .cuenta-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 60%; background: var(--purple); }
        .cuenta-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
        .cuenta-nombre { font-family: 'Orbitron', sans-serif; font-size: 1.1rem; font-weight: 600; letter-spacing: 1px; }
        .cuenta-banco { color: var(--text-dim); font-size: 0.8rem; margin-top: 3px; }
        .cuenta-saldo { font-family: 'Orbitron', sans-serif; font-size: 1.8rem; font-weight: 700; margin-top: 10px; }
        .cuenta-tipo { display: inline-block; padding: 4px 10px; border: 1px solid var(--cyan); border-radius: 0; font-size: 0.65rem; font-family: 'Orbitron', sans-serif; color: var(--cyan); letter-spacing: 1px; text-transform: uppercase; }
        
        .btn { padding: 12px 28px; border: 1px solid var(--cyan); background: transparent; border-radius: 0; cursor: pointer; font-family: 'Orbitron', sans-serif; font-size: 0.85rem; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; transition: all 0.3s ease; }
        .btn:hover { background: var(--cyan); color: var(--bg-dark); box-shadow: var(--glow-cyan); }
        .btn-primary { background: var(--cyan); color: var(--bg-dark); }
        .btn-primary:hover { background: transparent; color: var(--cyan); }
        .btn-secondary { border-color: var(--text-dim); color: var(--text-dim); }
        .btn-secondary:hover { border-color: var(--purple); color: var(--purple); }
        
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(5, 5, 10, 0.95); z-index: 1000; backdrop-filter: blur(10px); }
        .modal.active { display: flex; align-items: center; justify-content: center; }
        .modal-content { background: var(--bg-dark); padding: 30px; border: 1px solid var(--cyan); border-radius: 0; width: 90%; max-width: 500px; position: relative; clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%); box-shadow: var(--glow-cyan), inset 0 0 50px rgba(0, 240, 255, 0.05); }
        .modal::before { content: ''; position: absolute; top: -1px; left: 20%; right: 20%; height: 2px; background: var(--cyan); }
        .modal h2 { font-family: 'Orbitron', sans-serif; margin-bottom: 25px; color: var(--cyan); font-size: 1.3rem; letter-spacing: 3px; text-transform: uppercase; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--text-dim); font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase; }
        .form-group input, .form-group select { width: 100%; padding: 14px; border: 1px solid var(--bg-card-border); background: rgba(0, 0, 0, 0.5); color: var(--text); font-family: 'Rajdhani', sans-serif; font-size: 1rem; transition: all 0.3s ease; }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: var(--cyan); box-shadow: 0 0 15px rgba(0, 240, 255, 0.2); }
        
        .pagos-list { display: flex; flex-direction: column; gap: 10px; }
        .pago-item { display: flex; justify-content: space-between; align-items: center; background: var(--bg-card); border: 1px solid var(--bg-card-border); padding: 15px 20px; transition: all 0.3s ease; position: relative; }
        .pago-item::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--danger); transform: scaleY(0); transition: transform 0.3s ease; }
        .pago-item:hover { border-color: var(--cyan); }
        .pago-item:hover::before { transform: scaleY(1); }
        .pago-info { display: flex; align-items: center; gap: 15px; }
        .pago-icon { font-size: 1.3rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--bg-card-border); }
        .pago-detalles { display: flex; flex-direction: column; }
        .pago-desc { font-weight: 600; font-size: 0.95rem; }
        .pago-fecha { color: var(--text-dim); font-size: 0.75rem; margin-top: 2px; }
        .pago-cuenta { color: var(--text-dim); font-size: 0.7rem; }
        .pago-monto { font-family: 'Orbitron', sans-serif; font-size: 1.2rem; font-weight: 700; color: var(--danger); }
        .pago-monto.positivo { color: var(--success); }
        
        .filtros { display: flex; gap: 5px; margin-bottom: 20px; flex-wrap: wrap; justify-content: center; }
        .filtro-btn { padding: 8px 20px; background: transparent; border: 1px solid var(--bg-card-border); border-radius: 0; color: var(--text-dim); cursor: pointer; font-family: 'Orbitron', sans-serif; font-size: 0.7rem; letter-spacing: 1px; text-transform: uppercase; transition: all 0.3s ease; }
        .filtro-btn:hover { border-color: var(--cyan); color: var(--cyan); }
        .filtro-btn.active { background: var(--cyan); color: var(--bg-dark); border-color: var(--cyan); }
        
        .resumen-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .resumen-card { background: var(--bg-card); border: 1px solid var(--bg-card-border); padding: 25px; position: relative; }
        .resumen-card::before { content: ''; position: absolute; top: -1px; left: 0; right: 30%; height: 2px; background: var(--cyan); }
        .resumen-titulo { font-family: 'Orbitron', sans-serif; font-size: 1rem; color: var(--cyan); margin-bottom: 20px; letter-spacing: 2px; text-transform: uppercase; }
        .categoria-item { display: flex; align-items: center; gap: 12px; padding: 10px; border: 1px solid transparent; margin-bottom: 8px; transition: all 0.3s ease; }
        .categoria-item:hover { border-color: var(--bg-card-border); background: rgba(0, 240, 255, 0.05); }
        .categoria-icon { font-size: 1.2rem; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border: 1px solid var(--bg-card-border); }
        .categoria-nombre { flex: 1; font-weight: 500; }
        .categoria-monto { font-family: 'Orbitron', sans-serif; font-weight: 600; color: var(--danger); }
        
        .empty-state { text-align: center; padding: 50px; color: var(--text-dim); }
        .empty-state-icon { font-size: 3rem; margin-bottom: 15px; opacity: 0.5; }
        
        .options-menu { position: relative; }
        .options-btn { padding: 8px 12px; background: transparent; border: 1px solid var(--bg-card-border); color: var(--text); cursor: pointer; font-size: 1.2rem; transition: all 0.3s ease; }
        .options-btn:hover { border-color: var(--cyan); color: var(--cyan); }
        .options-dropdown { display: none; position: absolute; right: 0; top: 35px; background: var(--bg-dark); border: 1px solid var(--cyan); padding: 8px; min-width: 150px; z-index: 50; }
        .options-dropdown.show { display: block; }
        .options-dropdown button { width: 100%; padding: 10px 15px; background: transparent; border: none; color: var(--text); cursor: pointer; font-family: 'Rajdhani', sans-serif; font-size: 0.9rem; text-align: left; transition: all 0.2s ease; }
        .options-dropdown button:hover { background: rgba(0, 240, 255, 0.1); color: var(--cyan); }
        .options-dropdown .delete-btn { color: var(--danger); }
        .options-dropdown .delete-btn:hover { background: rgba(255, 45, 106, 0.1); color: var(--danger); }
        
        @media (max-width: 768px) { 
            .container { padding: 5px; } 
            h1 { font-size: 1.5rem; letter-spacing: 2px; } 
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
    <div id="login-screen" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:var(--bg-dark);z-index:2000;align-items:center;justify-content:center;">
        <div style="background:var(--bg-dark);padding:40px;border:1px solid var(--cyan);width:90%;max-width:400px;text-align:center;clip-path:polygon(0 0,100% 0,100% calc(100% - 20px),calc(100% - 20px) 100%,0 100%);box-shadow:var(--glow-cyan),inset 0 0 50px rgba(0,240,255,0.05);">
            <img src="https://i.postimg.cc/4Nf7WvxG/Gemini-Generated-Image-9j5a449j5a449j5a-removebg-preview.png" style="height:80px;margin-bottom:20px;filter:drop-shadow(0 0 10px rgba(0,240,255,0.5));">
            <h2 style="font-family:'Orbitron',sans-serif;color:var(--cyan);margin-bottom:30px;font-size:1.5rem;letter-spacing:3px;text-transform:uppercase;">Katherine Bank</h2>
            <input type="text" id="login-user" placeholder="Usuario" style="width:100%;padding:15px;margin-bottom:15px;border:1px solid var(--bg-card-border);background:rgba(0,0,0,0.5);color:var(--text);font-size:16px;font-family:'Rajdhani',sans-serif;">
            <input type="password" id="login-pass" placeholder="Contrasena" style="width:100%;padding:15px;margin-bottom:20px;border:1px solid var(--bg-card-border);background:rgba(0,0,0,0.5);color:var(--text);font-size:16px;font-family:'Rajdhani',sans-serif;">
            <button onclick="login()" style="width:100%;padding:15px;background:var(--cyan);border:none;color:var(--bg-dark);font-size:1rem;font-weight:bold;font-family:'Orbitron',sans-serif;letter-spacing:2px;text-transform:uppercase;cursor:pointer;transition:all 0.3s ease;">Iniciar Sesion</button>
        </div>
    </div>
    <div id="app" style="display:none;">
    <div class="container">
        <header>
            <h1><img src="https://i.postimg.cc/4Nf7WvxG/Gemini-Generated-Image-9j5a449j5a449j5a-removebg-preview.png" alt="Logo" style="height:50px;vertical-align:middle;margin-right:10px;filter:drop-shadow(0 0 10px rgba(0,240,255,0.5));"> Katherine Bank</h1>
            <div class="saldo-total" id="saldoTotal">$0</div>
            <p style="color: var(--text-dim); display: flex; align-items: center; justify-content: center; gap: 10px; font-family: 'Orbitron', sans-serif; font-size: 0.8rem; letter-spacing: 2px; text-transform: uppercase;">
                Saldo Total 
                <div style="position: relative;">
                    <button onclick="toggleSettings()" style="padding:8px 15px;background:transparent;border:1px solid var(--bg-card-border);color:var(--text-dim);cursor:pointer;font-size:0.8rem;font-family:'Orbitron',sans-serif;letter-spacing:1px;text-transform:uppercase;">⚙️ Settings</button>
                    <div id="settings-menu" style="display:none;position:absolute;right:0;top:35px;background:var(--bg-dark);border:1px solid var(--cyan);padding:10px;min-width:180px;z-index:100;">
                        <button onclick="openModal('cambiar-pass')" style="width:100%;padding:10px;background:transparent;border:none;color:var(--text);cursor:pointer;text-align:left;font-size:0.9rem;font-family:'Rajdhani',sans-serif;">🔑 Cambiar Contrasena</button>
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
            <div class="form-group"><label>Color</label><input type="color" id="cuenta-color" value="#b026ff"></div>
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
                <div class="cuenta-saldo" style="color:${(c.saldo||0)>=0?'var(--cyan)':'var(--danger)'}">${formatCLP(c.saldo||0)}</div>
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