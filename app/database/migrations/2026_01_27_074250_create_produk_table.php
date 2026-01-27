<?php
/**
 * Migration: Create produk Table
 * Compatible dengan PHP 5.2, 7, 8+
 */

function migration_20260127074250_up() {
    // Auto-detect MySQL charset (utf8mb4 untuk MySQL 5.5.3+ atau utf8 untuk lebih lama)
    $charset = 'utf8'; // default aman untuk semua versi
    
    $sql = "CREATE TABLE IF NOT EXISTS `tbl_produk` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `nama` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP NULL DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $charset . ";";
    
    return $sql;
}

function migration_20260127074250_down() {
    $sql = "DROP TABLE IF EXISTS `tbl_produk`;";
    return $sql;
}

// Return array untuk kompatibilitas
return array(
    'up' => 'migration_20260127074250_up',
    'down' => 'migration_20260127074250_down'
);