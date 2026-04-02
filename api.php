<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new SQLite3('/var/www/katherine-bank/data.db');

$tableExists = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='cuentas'");

if (!$tableExists->fetchArray()) {
    $db->exec("CREATE TABLE cuentas (id INTEGER PRIMARY KEY, nombre TEXT, banco TEXT, tipo TEXT DEFAULT 'bancaria', saldo REAL DEFAULT 0, color TEXT DEFAULT '#00d4ff', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $db->exec("CREATE TABLE categorias (id INTEGER PRIMARY KEY, nombre TEXT, icono TEXT DEFAULT '💰', color TEXT DEFAULT '#FF6384', created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $db->exec("CREATE TABLE pagos (id INTEGER PRIMARY KEY, cuenta_id INTEGER, categoria_id INTEGER, monto REAL, descripcion TEXT, fecha DATE, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    $db->exec("CREATE TABLE ingresos (id INTEGER PRIMARY KEY, cuenta_id INTEGER, monto REAL, descripcion TEXT, fecha DATE, created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");
    
    $categorias = [
        ['Agua', '💧', '#36A2EB'],
        ['Luz', '⚡', '#FFCE56'],
        ['Gas', '🔥', '#FF6384'],
        ['Internet', '📡', '#4BC0C0'],
        ['Teléfono', '📱', '#9966FF'],
        ['Comida', '🍔', '#FF9F40'],
        ['Transporte', '🚗', '#C9CBCF'],
        ['Entretenimiento', '🎮', '#FF6384'],
        ['Salud', '🏥', '#4BC0C0'],
        ['Otro', '📦', '#C9CBCF']
    ];
    
    foreach ($categorias as $cat) {
        $db->exec("INSERT INTO categorias (nombre, icono, color) VALUES ('{$cat[0]}', '{$cat[1]}', '{$cat[2]}')");
    }
}

function response($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'GET') {
    switch ($action) {
        case 'cuentas':
            $result = $db->query("SELECT * FROM cuentas ORDER BY nombre");
            $cuentas = [];
            while ($row = $result->fetchArray()) $cuentas[] = $row;
            response($cuentas);
            break;
            
        case 'categorias':
            $result = $db->query("SELECT * FROM categorias ORDER BY nombre");
            $categorias = [];
            while ($row = $result->fetchArray()) $categorias[] = $row;
            response($categorias);
            break;
            
        case 'pagos':
            $filtro = $_GET['filtro'] ?? 'mes';
            $fecha = date('Y-m-d');
            if ($filtro === 'dia') $where = "fecha = '$fecha'";
            elseif ($filtro === 'semana') $where = "fecha >= date('$fecha', '-7 days')";
            elseif ($filtro === 'mes') $where = "fecha >= date('$fecha', 'start of month')";
            else $where = "fecha >= date('$fecha', 'start of year')";
            
            $result = $db->query("
                SELECT p.*, c.nombre as cuenta_nombre, cat.nombre as categoria_nombre, cat.icono as categoria_icono, cat.color as categoria_color
                FROM pagos p
                JOIN cuentas c ON p.cuenta_id = c.id
                JOIN categorias cat ON p.categoria_id = cat.id
                WHERE $where ORDER BY p.fecha DESC
            ");
            $pagos = [];
            while ($row = $result->fetchArray()) $pagos[] = $row;
            response($pagos);
            break;
            
        case 'resumen':
            $filtro = $_GET['filtro'] ?? 'mes';
            $fecha = date('Y-m-d');
            if ($filtro === 'dia') $where = "fecha = '$fecha'";
            elseif ($filtro === 'semana') $where = "fecha >= date('$fecha', '-7 days')";
            elseif ($filtro === 'mes') $where = "fecha >= date('$fecha', 'start of month')";
            else $where = "fecha >= date('$fecha', 'start of year')";
            
            $total = $db->query("SELECT SUM(monto) as total FROM pagos WHERE $where")->fetchArray()['total'] ?? 0;
            
            $porCategoria = $db->query("
                SELECT cat.nombre, cat.icono, cat.color, SUM(p.monto) as total
                FROM pagos p
                JOIN categorias cat ON p.categoria_id = cat.id
                WHERE $where GROUP BY cat.id ORDER BY total DESC
            ");
            $categorias = [];
            while ($row = $porCategoria->fetchArray()) $categorias[] = $row;
            
            $porCuenta = $db->query("
                SELECT c.nombre, c.color, SUM(p.monto) as total
                FROM pagos p
                JOIN cuentas c ON p.cuenta_id = c.id
                WHERE $where GROUP BY c.id ORDER BY total DESC
            ");
            $cuentasGastos = [];
            while ($row = $porCuenta->fetchArray()) $cuentasGastos[] = $row;
            
            $saldosResult = $db->query("SELECT nombre, saldo, color, tipo FROM cuentas ORDER BY tipo, nombre");
            $saldos = [];
            while ($row = $saldosResult->fetchArray()) $saldos[] = $row;
            
            response([
                'total_gastado' => (float)$total,
                'por_categoria' => $categorias,
                'por_cuenta' => $cuentasGastos,
                'saldos' => $saldos
            ]);
            break;
            
        default:
            response(['error' => 'Acción no válida']);
    }
} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    switch ($action) {
        case 'cuenta':
            $stmt = $db->prepare("INSERT INTO cuentas (nombre, banco, tipo, saldo, color) VALUES (:nombre, :banco, :tipo, :saldo, :color)");
            $stmt->bindValue(':nombre', $data['nombre']);
            $stmt->bindValue(':banco', $data['banco']);
            $stmt->bindValue(':tipo', $data['tipo']);
            $stmt->bindValue(':saldo', $data['saldo']);
            $stmt->bindValue(':color', $data['color']);
            $stmt->execute();
            response(['id' => $db->lastInsertRowID(), 'message' => 'Cuenta creada']);
            break;
            
        case 'pago':
            $stmt = $db->prepare("INSERT INTO pagos (cuenta_id, categoria_id, monto, descripcion, fecha) VALUES (:cuenta_id, :categoria_id, :monto, :descripcion, :fecha)");
            $stmt->bindValue(':cuenta_id', $data['cuenta_id']);
            $stmt->bindValue(':categoria_id', $data['categoria_id']);
            $stmt->bindValue(':monto', $data['monto']);
            $stmt->bindValue(':descripcion', $data['descripcion']);
            $stmt->bindValue(':fecha', $data['fecha']);
            $stmt->execute();
            
            $db->exec("UPDATE cuentas SET saldo = saldo - {$data['monto']} WHERE id = {$data['cuenta_id']}");
            response(['id' => $db->lastInsertRowID(), 'message' => 'Pago registrado']);
            break;
            
        case 'ingreso':
            $stmt = $db->prepare("INSERT INTO ingresos (cuenta_id, monto, descripcion, fecha) VALUES (:cuenta_id, :monto, :descripcion, :fecha)");
            $stmt->bindValue(':cuenta_id', $data['cuenta_id']);
            $stmt->bindValue(':monto', $data['monto']);
            $stmt->bindValue(':descripcion', $data['descripcion']);
            $stmt->bindValue(':fecha', $data['fecha']);
            $stmt->execute();
            
            $db->exec("UPDATE cuentas SET saldo = saldo + {$data['monto']} WHERE id = {$data['cuenta_id']}");
            response(['id' => $db->lastInsertRowID(), 'message' => 'Ingreso registrado']);
            break;
            
        default:
            response(['error' => 'Acción no válida']);
    }
} elseif ($method === 'DELETE' && $action === 'pago' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pago = $db->query("SELECT monto, cuenta_id FROM pagos WHERE id = $id")->fetchArray();
    if ($pago) {
        $db->exec("UPDATE cuentas SET saldo = saldo + {$pago['monto']} WHERE id = {$pago['cuenta_id']}");
        $db->exec("DELETE FROM pagos WHERE id = $id");
        response(['message' => 'Pago eliminado']);
    } else {
        response(['error' => 'Pago no encontrado'], 404);
    }
}