<?php
session_start();
include "../connect.php";

if (isset($_REQUEST["ac"])) {
    switch ($_REQUEST["ac"]) {
        case "getIncomeExpenYear":
            $incomeSql = $conn->query("
                SELECT
                    MONTH(tt.transaction_date) AS payment_month,
                    SUM(tt.amount) AS total_income
                FROM
                    tb_transactions tt
                 LEFT JOIN tb_categories tc  on tt.category_id  = tc.category_id
                    WHERE tc.type = 'รายรับ'
                 GROUP BY
                    payment_month");

            $expenseSql = $conn->query("
                SELECT
                    MONTH(tt.transaction_date) AS payment_month,
                    SUM(tt.amount) AS total_expense
                FROM
                    tb_transactions tt
                LEFT JOIN tb_categories tc  on tt.category_id  = tc.category_id
                    WHERE tc.type = 'รายจ่าย'
                GROUP BY
                    payment_month");

            if ($incomeSql && $expenseSql) {
                $incomeData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                while ($income = $incomeSql->fetch_object()) {
                    $incomeData[$income->payment_month - 1] =
                        $income->total_income;
                }

                $expenseData = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                while ($expense = $expenseSql->fetch_object()) {
                    $expenseData[$expense->payment_month - 1] =
                        $expense->total_expense;
                }

                $data = [
                    "status" => true,
                    "income" => $incomeData,
                    "expense" => $expenseData,
                ];
            } else {
                $data = ["status" => false, "income" => [], "expense" => []];
            }

            echo json_encode($data);
            break;

        case "getPaymentYear":
            $sql = $conn->query("SELECT
            MONTH(payment_create_at) AS payment_month,
            SUM(payment_total) AS total_payment
        FROM
            tb_payment
        GROUP BY
            payment_month");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = ["status" => true, "data" => $paymentData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;

        case "getPaymentToDay":
            $sql = $conn->query("SELECT
                DAY(payment_create_at) AS payment_day,
                SUM(payment_total) AS total_payment
            FROM
                tb_payment
            WHERE
                DATE(payment_create_at) = CURDATE()
            GROUP BY
                payment_day");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = ["status" => true, "data" => $paymentData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;
        case "getPaymentMonth":
            $sql = $conn->query("SELECT
                    DAY(payment_create_at) AS payment_day,
                    SUM(payment_total) AS total_payment
                FROM
                    tb_payment
                GROUP BY
                    payment_day");

            if ($sql) {
                $paymentData = [];
                while ($payment = $sql->fetch_object()) {
                    $paymentData[] = $payment;
                }
                $data = ["status" => true, "data" => $paymentData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;

        case "getProductTotal":
            $sql = $conn->query("SELECT
                    SUM(product_amount) AS total_product
                FROM
                    tb_products
                WHERE
                    product_status = 1 ");

            if ($sql) {
                $productData = [];
                while ($product = $sql->fetch_object()) {
                    $productData[] = $product;
                }
                $data = ["status" => true, "data" => $productData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;

        case "getUserTotal":
            $sql = $conn->query("SELECT user_id
                 FROM
                    tb_user
                WHERE
                    user_status = 1 AND user_role = 1");

            if ($sql) {
                $data = ["status" => true, "data" => $sql->num_rows];
            } else {
                $data = ["status" => false, "data" => 0];
            }

            echo json_encode($data);
            break;
        case "getZoneTotal":
            $sql = $conn->query("SELECT stock_id
                     FROM
                        tb_stock
                    WHERE
                        stock_status = 1");

            if ($sql) {
                $data = ["status" => true, "data" => $sql->num_rows];
            } else {
                $data = ["status" => false, "data" => 0];
            }

            echo json_encode($data);
            break;

        case "getStockMonth":
            $sql = $conn->query("SELECT stock_name AS stockName,
                COUNT(*) AS stockTotal
                FROM tb_stock
                WHERE stock_status = 0
                GROUP BY stock_name");

            if ($sql) {
                $stockData = [];
                while ($stock = $sql->fetch_object()) {
                    $stockData[] = $stock;
                }
                $data = ["status" => true, "data" => $stockData];
            } else {
                $data = ["status" => false, "data" => []];
            }

            echo json_encode($data);
            break;
    }
}
