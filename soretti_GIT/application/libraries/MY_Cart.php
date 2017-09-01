<?php 
class MY_Cart extends CI_Cart {

	public function __construct() {
		parent::__construct();
	}

	function contents()
	{
		$this->CI->load->model(array('usuario','catalogo/producto','catalogo/descuento','catalogo/cat_precio','catalogo/cat_categoria'));

		foreach ($this->_cart_contents as $cart_item) {
				$producto=new Producto;
				$producto->include_related('cat_precio')->where("id",$cart_item['id'])->get();

				if( $producto->producto_id) {
		 			/*combinacion*/
					$producto=$producto;
					$producto_padre=new Producto();
					$producto_padre->include_related('cat_precio')->get_by_id($producto->producto_id);
				    $precio=$producto->precio($cart_item['qty'],$producto_padre,$producto);

				}else{
					/*Producto*/
					$producto_padre=$producto;
					$producto=new Producto();
					$producto->include_related('cat_precio')->get_by_id($producto->id);
				    $precio=$producto->precio($cart_item['qty'],$producto_padre);
				}

				if($cart_item['rowid']){
					$data = array(
					 	'rowid' => $cart_item['rowid'],
					 	'price' => $precio['precio'],
					 	'qty'   => $cart_item['qty']
					 );

					$this->update($data);
				} 
		}

		$cart = $this->_cart_contents;

		// Remove these so they don't create a problem when showing the cart table
		unset($cart['total_items']);
		unset($cart['cart_total']);

		return $cart;
	}




	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits the quantity of a given item to be changed.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each item.
	 *
	 * @access	private
	 * @param	array
	 * @return	bool
	 */
	function _update($items = array())
	{ 
		// Without these array indexes there is nothing we can do
		if ( ! isset($items['qty']) OR ! isset($items['rowid']) OR ! isset($this->_cart_contents[$items['rowid']]))
		{
			return FALSE;
		}

		// Prep the quantity
		$items['qty'] = preg_replace('/([^0-9])/i', '', $items['qty']);

		// Is the quantity a number?
		if ( ! is_numeric($items['qty']))
		{
			return FALSE;
		}

		// Is the new quantity different than what is already saved in the cart?
		// If it's the same there's nothing to do
		if ($this->_cart_contents[$items['rowid']]['qty'] == $items['qty'] && $this->_cart_contents[$items['rowid']]['price'] == $items['price'])
		{
			return FALSE;
		}

		// Is the quantity zero?  If so we will remove the item from the cart.
		// If the quantity is greater than zero we are updating
		if ($items['qty'] == 0)
		{
			unset($this->_cart_contents[$items['rowid']]);
		}
		else
		{
			$this->_cart_contents[$items['rowid']]['qty'] = $items['qty'];
			if($items['price']) $this->_cart_contents[$items['rowid']]['price'] = $items['price'];
		}

		return TRUE;
	}



}	

?>