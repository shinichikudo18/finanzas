<?php
try {
    $c = new mysqli('localhost', 'katherine_bank', 'Katherine2025!', 'katherine_bank');
    echo "Connected OK\n";
    $r = $c->query('SELECT * FROM cuentas');
    while ($row = $r->fetch_assoc()) {
        print_r($row);
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}