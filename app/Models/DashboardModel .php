<?php

use App\Core\Model;

use App\Core\Auth;
use Exception;
use Roles;
use TABLES;

class DashboardModel extends Model
{

    public function totalSalesToday()
    {
        $stmt = $this->db->prepare("
            SELECT SUM(total_amount) AS total
            FROM sales
            WHERE tenant_id = ?
              AND DATE(created_at) = CURDATE()
        ");
        $stmt->execute([$_SESSION['tenant_id']]);
        return $stmt->fetch()['total'] ?? 0;
    }

    public function totalProducts()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total
            FROM products
            WHERE tenant_id = ?
        ");
        $stmt->execute([$_SESSION['tenant_id']]);
        return $stmt->fetch()['total'];
    }

    public function lowStockProducts()
    {
        $stmt = $this->db->prepare("
            SELECT name, stock
            FROM products
            WHERE tenant_id = ?
              AND stock <= stock_min
            LIMIT 5
        ");
        $stmt->execute([$_SESSION['tenant_id']]);
        return $stmt->fetchAll();
    }
}
