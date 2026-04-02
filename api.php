<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DB_HOST', 'localhost');
define('DB_USER', 'katherine_bank');
define('DB_PASS', 'Katherine2025!');
define('DB_NAME', 'katherine_bank');

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        throw new Exception('Conexión fallida: ' . $conn->connect_error);
    }
} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
$conn->set_charset('utf8mb4');

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
            $result = $conn->query("SELECT * FROM cuentas ORDER BY nombre");
            $cuentas = [];
            while ($row = $result->fetch_assoc()) $cuentas[] = $row;
            response($cuentas);
            break;
            
        case 'categorias':
            $result = $conn->query("SELECT * FROM categorias ORDER BY nombre");
            $categorias = [];
            while ($row = $result->fetch_assoc()) $categorias[] = $row;
            response($categorias);
            break;
            
        case 'pagos':
            $filtro = $_GET['filtro'] ?? 'mes';
            $fecha = date('Y-m-d');
            if ($filtro === 'dia') $where = "fecha = '$fecha'";
            elseif ($filtro === 'semana') $where = "fecha >= DATE_SUB('$fecha', INTERVAL 7 DAY)";
            elseif ($filtro === 'mes') $where = "fecha >= DATE_FORMAT('$fecha', '%Y-%m-01')";
            else $where = "fecha >= DATE_FORMAT('$fecha', '%Y-01-01')";
            
            $result = $conn->query("
                SELECT p.*, c.nombre as cuenta_nombre, cat.nombre as categoria_nombre, cat.icono as categoria_icono, cat.color as categoria_color
                FROM pagos p
                JOIN cuentas c ON p.cuenta_id = c.id
                JOIN categorias cat ON p.categoria_id = cat.id
                WHERE $where ORDER BY p.fecha DESC
            ");
            $pagos = [];
            while ($row = $result->fetch_assoc()) $pagos[] = $row;
            response($pagos);
            break;
            
        case 'resumen':
            $filtro = $_GET['filtro'] ?? 'mes';
            $fecha = date('Y-m-d');
            if ($filtro === 'dia') $where = "fecha = '$fecha'";
            elseif ($filtro === 'semana') $where = "fecha >= DATE_SUB('$fecha', INTERVAL 7 DAY)";
            elseif ($filtro === 'mes') $where = "fecha >= DATE_FORMAT('$fecha', '%Y-%m-01')";
            else $where = "fecha >= DATE_FORMAT('$fecha', '%Y-01-01')";
            
            $total = $conn->query("SELECT SUM(monto) as total FROM pagos WHERE $where")->fetch_assoc()['total'] ?? 0;
            
            $porCategoria = $conn->query("
                SELECT cat.nombre, cat.icono, cat.color, SUM(p.monto) as total
                FROM pagos p
                JOIN categorias cat ON p.categoria_id = cat.id
                WHERE $where GROUP BY cat.id ORDER BY total DESC
            ");
            $categorias = [];
            while ($row = $porCategoria->fetch_assoc()) $categorias[] = $row;
            
            $porCuenta = $conn->query("
                SELECT c.nombre, c.color, SUM(p.monto) as total
                FROM pagos p
                JOIN cuentas c ON p.cuenta_id = c.id
                WHERE $where GROUP BY c.id ORDER BY total DESC
            ");
            $cuentasGastos = [];
            while ($row = $porCuenta->fetch_assoc()) $cuentasGastos[] = $row;
            
            $saldos = $conn->query("SELECT nombre, saldo, color, tipo FROM cuentas ORDER BY tipo, nombre")->fetch_all(MYSQLI_ASSOC);
            
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
            $stmt = $conn->prepare("INSERT INTO cuentas (nombre, banco, tipo, saldo, color) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssds", $data['nombre'], $data['banco'], $data['tipo'], $data['saldo'], $data['color']);
            $stmt->execute();
            response(['id' => $stmt->insert_id, 'message' => 'Cuenta creada']);
            break;
            
        case 'pago':
            $stmt = $conn->prepare("INSERT INTO pagos (cuenta_id, categoria_id, monto, descripcion, fecha) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iidss", $data['cuenta_id'], $data['categoria_id'], $data['monto'], $data['descripcion'], $data['fecha']);
            $stmt->execute();
            
            $conn->query("UPDATE cuentas SET saldo = saldo - {$data['monto']} WHERE id = {$data['cuenta_id']}");
            response(['id' => $stmt->insert_id, 'message' => 'Pago registrado']);
            break;
            
        case 'ingreso':
            $stmt = $conn->prepare("INSERT INTO ingresos (cuenta_id, monto, descripcion, fecha) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("idss", $data['cuenta_id'], $data['monto'], $data['descripcion'], $data['fecha']);
            $stmt->execute();
            
            $conn->query("UPDATE cuentas SET saldo = saldo + {$data['monto']} WHERE id = {$data['cuenta_id']}");
            response(['id' => $stmt->insert_id, 'message' => 'Ingreso registrado']);
            break;
            
        default:
            response(['error' => 'Acción no válida']);
    }
} elseif ($method === 'DELETE' && $action === 'pago' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $pago = $conn->query("SELECT monto, cuenta_id FROM pagos WHERE id = $id")->fetch_assoc();
    if ($pago) {
        $conn->query("UPDATE cuentas SET saldo = saldo + {$pago['monto']} WHERE id = {$pago['cuenta_id']}");
        $conn->query("DELETE FROM pagos WHERE id = $id");
        response(['message' => 'Pago eliminado']);
    } else {
        response(['error' => 'Pago no encontrado'], 404);
    }
}