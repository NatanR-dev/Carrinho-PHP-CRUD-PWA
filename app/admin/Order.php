<?php

/**
 * Product Controller Class
 *
 * Método chamado por URI
 * Exemplo : /admin/order chamará a função index() nesta classe
 */
class Order extends ControllerClass
{
    /**
     * Index do Pedido
     * URL : admin/order/index
     */
    public function index($id = null)
    {
        if ($id) {

            $this->detail($id);

        } else {

            $title = config('name').' - Lista de Pedidos';

            $data['orders'] = $this->db->query('SELECT * FROM orders');

            $this->view('admin/order-index', ['data' => $data, 'title' => $title]);

        }
    }

    /**
     * Detalhes do Pedido
     * URL : admin/order/detail/{id}
     */
    public function detail($id = null)
    {
        $title = config('name').' - Detalhes do Pedido';

        $id = filter($id);
        $order = $this->db->query("SELECT * FROM orders WHERE id = '$id'");

        if (count($order) > 0) {

            $order = $order[0];
            $orderDetail = $this->db->query("SELECT * FROM order_products WHERE order_id = '$order[id]'");

            $title = config('name').' - Order Detail';
            $order['detail'] = $orderDetail;
            $data['order'] = $order;

            $this->view('admin/order-detail', ['data' => $data, 'title' => $title]);

        } else {

            $this->error404();

        }
    }

}

?>