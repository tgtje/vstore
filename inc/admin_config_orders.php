<?php
/**
 * Adminarea module orders
 */


e107::css('inline', "
			.td-gateway span { line-height: 2em; vertical-align: top; margin-left: 5px;} 
			.td-total { font-weight: bold }
			.td-status .label, 
			.td-pay-status .label {
					display:block;
					margin: 0 10px;
					padding:7px;
				}
				.label-wide {
					padding: 8px 20px;
				}
			");

class vstore_order_ui extends e_admin_ui
{

		protected $pluginTitle		= 'Vstore';
		protected $pluginName		= 'vstore';
		protected $eventName		= 'vstore_order'; // remove comment to enable event triggers in admin.
		protected $table			= 'vstore_orders';
		protected $pid				= 'order_id';
		protected $perPage			= 10;
		protected $batchDelete		= false;
	//	protected $batchCopy		= true;
	//	protected $sortField		= 'somefield_order';
	//	protected $orderStep		= 10;
		protected $tabs				= array(LAN_GENERAL,  LAN_DETAILS, LAN_VSTORE_GEN_004); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable.

		// protected $listQry      	= "SELECT o.*, SUM(c.cart_qty) as items FROM `#vstore_orders` AS o LEFT JOIN `#vstore_cart` AS  c ON o.order_session = c.cart_session  "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.

		protected $listOrder		= 'order_id DESC';



		protected $fields 		= array (
			'checkboxes'           	=> array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
			'order_id'            	=> array ( 'title' => LAN_ID, 'data' => 'int', 'type'=>'number',  'width' => '5%', 'help' => '', 'readonly'=>true, 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_date'          	=> array ( 'title' => LAN_DATESTAMP, 'type' => 'datestamp', 'data' => 'str',  'readonly'=>true, 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_status'          => array ( 'title' => LAN_VSTORE_GEN_001, 'type'=>'method', 'data'=>'str', 'inline'=>false, 'filter'=>true, 'batch'=>true,'width'=>'5%', 'class'=>'td-status'),
			'order_pay_status'      => array ( 'title' => LAN_VSTORE_SALES_002, 'type' => 'method',  'data' => 'str',  'readonly'=>true, 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'td-pay-status left', 'thclass' => 'left',  ),
			'order_refund_date' 	=> array ( 'title' => LAN_VSTORE_SALES_003, 'type' => 'method', 'tab'=>0, 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

			'order_invoice_nr'     	=> array ( 'title' => LAN_VSTORE_SALES_004, 'type'=>'method', 'data'=>false, 'width'=>'10%'),
			'order_billing'      	=> array ( 'title' => LAN_VSTORE_SALES_005, 'type'=>'method', 'data'=>false, 'width'=>'20%'),
			'order_shipping'      	=> array ( 'title' => LAN_VSTORE_SALES_006, 'type'=>'method', 'data'=>false, 'width'=>'20%'),
			'order_items'     		=> array ( 'title' => LAN_VSTORE_GEN_002, 'type' => 'method', 'data' => false, 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'right', 'thclass' => 'right',  ),
			'order_e107_user'     	=> array ( 'title' => LAN_AUTHOR, 'type' => 'method', 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_pay_transid'     => array ( 'title' => LAN_VSTORE_SALES_008, 'type' => 'text', 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

			'order_pay_gateway'     => array ( 'title' => LAN_VSTORE_SALES_009, 'type' => 'method', 'data' => false,  'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'td-gateway left', 'thclass' => 'left',  ),
			'order_pay_amount' 		=> array ( 'title' => LAN_VSTORE_GEN_013, 'type' => 'method', 'data' => false, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'td-total left', 'thclass' => 'left',  ),
			'order_pay_shipping' 	=> array ( 'title' => LAN_VSTORE_GEN_012, 'type' => 'number', 'data' => 'float', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_pay_currency' 	=> array ( 'title' => LAN_VSTORE_SALES_012, 'type' => 'text', 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

			'order_ship_notes'      => array ( 'title' => LAN_VSTORE_SALES_013, 'type'=>'method', 'tab'=>1, 'data'=>false, 'width'=>'20%'),
			'order_session'       	=> array ( 'title' => LAN_SESSION, 'type' => 'text', 'tab'=>1, 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_pay_rawdata' 	=> array ( 'title' => LAN_VSTORE_SALES_014, 'type' => 'method', 'tab'=>1, 'data' => 'str', 'readonly'=>true, 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
			'order_log' 			=> array ( 'title' => LAN_VSTORE_GEN_004, 'type' => 'method', 'tab'=>2, 'data' => 'json', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),

			'options' 				=> array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);

		protected $fieldpref = array('order_id','order_ship_to', 'order_status', 'order_invoice_nr', 'order_date', 'order_items', 'order_pay_transid','order_pay_amount', 'order_pay_gateway', 'order_pay_status');


		// protected $preftabs = array();
		// protected $prefs = array( );



		public function init()
		{

			if ($_GET['filter_options'] == 'order_status__open')
			{
				// List all open orders: New, Processing, On Hold
				// Completed, Cancelled, Refunded will NOT be displayed!
				$this->filterQry = 'SELECT * FROM `#vstore_orders` WHERE FIND_IN_SET(order_status, "N,P,H")';
				//$this->setQuery('filter_options');
			}

			// check for responses on inline editing
			// and display them
			$js = '
			$(function(){
				$(".e-editable").on("save", function(e, params){
					var msg = params.response;
					if ($("#vstore-message").length > 0)
					{
						$("#vstore-message").html(msg);
					}
					else
					{
						$("#admin-ui-list-filter").prepend("<div id=\"vstore-message\">" + msg + "</div>");
					}
				});
			});
			';
			e107::getJs()->footerInline($js);
		}


		// ------- Customize Create --------

		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}

		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something
		}


		// ------- Customize Update --------

		public function beforeUpdate($new_data, $old_data, $id)
		{
			$tp = e107::getParser();

			if (array_key_exists('order_status', $new_data)) 
			{
				if ($old_data['order_status'] === 'C' && $new_data['order_status'] !== 'C')
				{
					// Check if this order "contains" any userclasses that have been assigned
					$uc = vstore::getCustomerUserclass(json_decode($old_data['order_items'], true));
					if ($uc)
					{
						$uc_list = e107::getDB()->retrieve('SELECT GROUP_CONCAT(userclass_name) AS ucs FROM e107_userclass_classes WHERE FIND_IN_SET(userclass_id, "'.$uc.'")');
						$msg = $tp->lanVars('The userclasses, the customer has been assigned to during the purchase can not be removed automatically.<br/>
							Click <a href="'.e_ADMIN.'users.php?searchquery=[x]">here</a> to remove the following userclasses manually.<br/>[y]', 
							array('x' => $old_data['order_e107_user'], 'y' => str_replace(',', ', ', $uc_list)));
						
						if (e_AJAX_REQUEST)
						{
							$response_msg = e107::getMessage()->addWarning($msg)->render();
							$new_data['etrigger_submit'] = 'Update';

							$response = $this->getResponse();
							$response->getJsHelper()->addResponse($response_msg);
						}
						else
						{
							e107::getMessage()->addWarning($msg);
						}
					}
				}
				elseif ($old_data['order_status'] !== 'R' && $new_data['order_status'] === 'R')
				{
					// Check if order can be refunded...
					if (!in_array($old_data['order_status'], array('P', 'H', 'C'))) {
						// refund not allowed: reset to old value
						unset($new_data['order_status']);
					}
					else {
						// Refund order
						$order_id = $old_data['order_id'];
						if ($order_id > 0)
						{
							$vs = e107::getSingleton('vstore', e_PLUGIN . 'vstore/vstore.class.php');
							// Now do the actual refunding
							$result = $vs->refundPurchase($order_id, true);
							if(is_string($result))
							{
								$msg = vartrue($result, ''.LAN_VSTORE_SALES_015.'');
								if (e_AJAX_REQUEST)
								{
									$response_msg = e107::getMessage()->addWarning($msg)->render();
									$new_data['etrigger_submit'] = ''.LAN_UPDATE.'';

									$response = $this->getResponse();
									$response->getJsHelper()->addResponse($response_msg);
								}
								else
								{
									e107::getMessage()->addWarning($msg);
								}
							}
							else{
								// Refund was successfull, set the pay status also to "refunded"
								$new_data['order_pay_status'] = ''.LAN_VSTORE_GEN_029.'';
								$new_data['order_refund_date'] = time();
							}
						}
					}
				}
			}

			// Check for changes and add to the log
			$log = e107::unserialize($old_data['order_log']);
			foreach ($new_data as $key => $value) {
				$oldval = $old_data[$key];
				if ($value !== $oldval && array_key_exists($key, $this->fields))
				{
					$title = $this->fields[$key]['title'];

					if ($key == 'order_status') {
						$value = vstore::getStatus($value);
						$oldval = vstore::getStatus($oldval);
					}

					$log = vstore::addToOrderLog($log, $title, $oldval, $value, true);

				}
			}

			$new_data['order_log'] = e107::serialize($log, 'json');
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			if (array_key_exists('order_status', $new_data)) 
			{
				// Assign "purchased" userclasses to customer, once the order has been completed
				if ($new_data['order_status'] === 'C' && $old_data['order_status'] !== 'C')
				{
					// Update userclass
					vstore::setCustomerUserclass($old_data['order_e107_user'], json_decode($old_data['order_items']));
				}
			}

			$vs = e107::getSingleton('vstore');

			if (isset($_POST['force_new_invoice']) && intval($_POST['force_new_invoice']) == 1 && vstore::validInvoiceOrderState($new_data['order_status']))
			{
				// User requests to delete the current invoice pdf and to create a new one.
				$data = $vs->renderInvoice($new_data['order_id'], true);
				if ($data)
				{
					$vs->invoiceToPdf($data, true);
				}

				// Check if the pdf was created
				if (empty($vs->pathToInvoicePdf($new_data['order_invoice_nr'], $new_data['order_e107_user'])))
				{
					e107::getMessage()->addWarning(LAN_VSTORE_SALES_011);
				}
				else
				{
					e107::getMessage()->addSuccess(LAN_VSTORE_SALES_010);
				}
			}

			// Send our email to customer
			$vc = e107::getSingleton('vstore_order', e_PLUGIN.'vstore/inc/vstore_order.class.php');
			$vc->emailCustomerOnStatusChange($new_data['order_id']);
		}

		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something
		}


	/*
		// optional - a custom page.
		public function customPage()
		{
			$text = 'Hello World!';
			return $text;

		}
	*/

}



class vstore_order_form_ui extends e_admin_form_ui
{
	static $status_classes = array(
				'N' => 'primary',
				'P' => 'info',
				'H' => 'warning',
				'C' => 'success',
				'X' => 'danger',
				'R' => 'default'
			);

	static $pay_status_classes = array(
				'incomplete' => 'warning',
				'complete' => 'success',
				'refunded' => 'default'
			);

	function order_invoice_nr($curVal, $mode)
	{
		$status = $this->getController()->getFieldVar('order_status');
		$exists = false;
		if (vstore::validInvoiceOrderState($status))
		{
			$text = '<a href="' . e107::url('vstore', 'invoice', array('order_invoice_nr' => $curVal)) . '" target="_BLANK">' . vstore::formatInvoiceNr($curVal) . '</a>';
			$exists = true;
		}
		else
		{
			$text = vstore::formatInvoiceNr($curVal);
		}

		switch($mode)
		{
			case 'read': // List Page
				return '<span title="'.LAN_VSTORE_SALES_016.'">' .$text . '</span>';
				break;

			case 'write': // Edit Page
				if ($exists)
				{
					return $text . ' &nbsp;&nbsp;&nbsp;&nbsp;' . $this->checkbox_label(LAN_VSTORE_SALES_027, 'force_new_invoice', 1);
				}
				else
				{
					return $text;
				}
				break;

			case 'filter':
				return null;
				break;

			case 'batch':
				return  null;
				break;
		}		
	}

	function order_status($curVal, $mode)
	{

		switch($mode)
		{
			case 'read': // List Page
				return '<span class="label label-'.self::$status_classes[$curVal].'">'.vstore::getStatus($curVal).'</span>';
				break;

			case 'write': // Edit Page

				$order_id = $this->getController()->getFieldVar('order_id');
				// $order_pay_status = $this->getController()->getFieldVar('order_pay_status');
				// $order_pay_transid = $this->getController()->getFieldVar('order_pay_transid');

				$text = '<div class="label-wide label label-'.self::$status_classes[$curVal].'">'.vstore::getStatus($curVal).'</div>';

				switch($curVal) {
					case 'N': // new
						$text .= $this->button('btnCancel', 1, 'danger', LAN_VSTORE_CART_024, array('confirm' => LAN_VSTORE_SALES_022));
						$text .= $this->button('btnOnHold', 1, 'warning', LAN_VSTORE_SALES_017, array());
						$text .= $this->button('btnProcessing', 1, 'button', LAN_VSTORE_SALES_018, array());
						break;
					case 'P': // processing
						$text .= $this->button('btnCancel', 1, 'danger', LAN_VSTORE_CART_024, array('confirm' => LAN_VSTORE_SALES_022));
						$text .= $this->button('btnRefund', '1', 'danger', LAN_VSTORE_SALES_023, array());
						$text .= $this->button('btnComplete', 1, 'button', LAN_VSTORE_SALES_024, array());
						break;
					case 'H': // On hold
						$text .= $this->button('btnCancel', 1, 'danger', LAN_VSTORE_CART_024, array('confirm' => LAN_VSTORE_SALES_022));
						$text .= $this->button('btnProcessing', 1, 'button', LAN_VSTORE_SALES_018, array());
						break;
					case 'C': // completed
						$text .= $this->button('btnRefund', '1', 'danger', LAN_VSTORE_SALES_023, array('confirm' => LAN_VSTORE_SALES_025));
						break;
					case 'X': // cancelled
						$text .= $this->button('btnProcessing', 1, 'button', LAN_VSTORE_SALES_018, array());
						break;
					case 'R': // refunded
						//$text .= 'Order is already refunded!';
						break;
				}



				e107::js('footer-inline', "					
					$(function(){
						function updateOrder(type, id) {
							var url = 'vstore.php';
							var data = {
								'order': type,
								'id': id
							};
							
							$.post(url, data, function(response){
								alert(response);
								location.reload();
							}).fail(function(response){
								alert(response);
							});

						}
					
						$('#btnprocessing').click(function(e){
							e.preventDefault();
							updateOrder('process', {$order_id});
						});
					
						$('#btnonhold').click(function(e){
							e.preventDefault();
							if (!confirm('".LAN_VSTORE_HELP_025."')) return;
							updateOrder('hold', {$order_id});
						});
					
						$('#btncancel').click(function(e){
							e.preventDefault();
							if (!confirm('".LAN_VSTORE_SALES_022."')) return;
							updateOrder('cancel', {$order_id});
						});
					
						$('#btnrefund').click(function(e){
							e.preventDefault();
							if (!confirm('".LAN_VSTORE_SALES_025."')) return;
							updateOrder('refund', {$order_id});
						});
						
						$('#btncomplete').click(function(e){
							e.preventDefault();
							updateOrder('complete', {$order_id});
						});
						
					});
					");

				return $text;
				break;

			case 'inline': // Inline Edit Page
				return array(
					'inlineType' => 'select',
					'inlineData' => vstore::getStatus()
				);
				break;

			case 'filter':
				$filter = vstore::getStatus();
				$filter['open'] = 'Open';
				return $filter;
				break;

			case 'batch':
				return  vstore::getStatus();
				break;
		}		
	}

	// Custom Method/Function
	function order_e107_user($curVal,$mode)
	{

		$text = $curVal.') '.e107::getDb()->retrieve('user', 'user_name', 'user_id="'.$curVal.'"');
		return $text;

	}

	function order_items($curVal,$mode)
	{

		switch($mode)
		{
			case 'read': // List Page
				if(!empty($curVal))
				{
					$val = json_decode($curVal, true);
					$total = 0;
					foreach($val as $row)
					{
						$total = $total + intval($row['quantity']);
					}
					return $total;
				}
			break;

			case 'write': // Edit Page
				if(empty($curVal))
				{
					return 'n/a';
				}



				$data = json_decode($curVal, true);

			//	return print_a($data,true);

				$text = "<table class='table table-striped table-bordered' style='margin:0;width:70%'>
				<thead>
				<tr>
					<th>".LAN_VSTORE_CART_001."</th>
					<th>".LAN_VSTORE_CUSM_022."</th>
					<th class='text-right'>".LAN_VSTORE_GEN_003.".</th>

					<th class='text-right'>".LAN_VSTORE_CUSM_062."</th>
				</tr>
				</thead>";

				foreach($data as $row)
				{

					$text .= "
					<tr>
						<td>".$row['name']."</td>
						<td>".$row['description']."</td>
						<td class='text-right'>".$row['quantity']."</td>
						<td class='text-right'>".$row['price']."</td>
					</tr>";
				}

				$text .= "</table>";

				return $text;
			break;

			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}


	function order_billing($curVal,$mode)
	{

		switch($mode)
		{

			case 'read': // List Page
			case 'write': // Edit Page
				$val = e107::unserialize($curVal);

				if (count($val) == 0) return ''.LAN_VSTORE_CUSM_073.'';

				return varset($val['firstname']) . ' ' . varset($val['lastname']).'<br />'
					.varset($val['company']).'<br />'
					.varset($val['address']).'<br />'
					.varset($val['city']) . ', ' . varset($val['state']) . ' ' . varset($val['zip']).'<br />'
					.(empty($val['country']) ? '' : $this->getCountry($val['country']) . '<br />')
					.varset($val['phone']);

				break;
			}
		}

	function order_shipping($curVal,$mode)
	{

		switch($mode)
		{

			case 'read': // List Page
			case 'write': // Edit Page
				$val = e107::unserialize($curVal);

				if (count($val) == 0) return ''.LAN_VSTORE_CART_039.'';
		
				return varset($val['firstname']) . ' ' . varset($val['lastname']).'<br />'
					.varset($val['company']).'<br />'
					.varset($val['address']).'<br />'
					.varset($val['city']) . ', ' . varset($val['state']) . ' ' . varset($val['zip']).'<br />'
					.(empty($val['country']) ? '' : $this->getCountry($val['country']) . '<br />')
					.varset($val['phone']);

			break;
		}
	}

	function order_ship_notes($curVal, $mode)
	{
		switch($mode)
		{
			case 'read':
			case 'write':
				$notes = e107::unserialize($this->getController()->getFieldVar('order_shipping'));
				$notes = nl2br($notes['notes']);
				return $notes;
				break;
		}
	}


	function order_pay_amount($curVal,$mode)
	{


		switch($mode)
		{

			case 'read': // List Page
			case 'write': // Edit Page

				$via = $this->getController()->getFieldVar('order_pay_gateway');
				$currency = $this->getController()->getFieldVar('order_pay_currency');

				return vstore::getCurrencySymbol($currency).$curVal;

			break;


			case 'filter':
			case 'batch':
				return  array();
			break;
		}

	}


	// Custom Method/Function
	function order_pay_rawdata($curVal,$mode)
	{

		switch($mode)
		{
			case 'read': // List Page
			case 'write': // Edit Page

				if(!empty($curVal))
				{
					if (!is_array($curVal)) {
						$data = e107::unserialize($curVal);
						$json_err = json_last_error_msg();
						echo $json_err;
					} else {
						$data = $curVal;
					}
					if (!empty($data) && !isset($data['purchase'])) {
						// Fix for older data
						$tmp = $data;
						$data = array('purchase' => $tmp);
						unset($tmp);
					}
					$text = '';
					foreach($data as $section=>$row)
					{

						$text .= "<table class='table table-bordered table-striped table-condensed'>
							<colgroup>
								<col style='width:40%' />
								<col />
							</colgroup>
							";
						$text .= "<tr><th colspan='2'><b>" . ucfirst($section ). "</b></th></tr>";
						foreach($row as $k => $v)
						{
							if(is_array($v)) {
								$v = '<pre>' . e107::serialize($v, 'json') . '</pre>';
							}
							$text .= "<tr><td>" . $k . "</td><td>" . $v . "</td></tr>";
						}

						$text .= "</table>";
					}
					return $text;
				}

				return null;
			break;

			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}


	function order_log($curVal, $mode)
	{
		$items = e107::unserialize($curVal);

		$text = '<table class="table table-bordered table-striped">
			<tr>
				<th>'.LAN_VSTORE_CUSM_043.'</th>
				<th>'.LAN_USER.'</th>
				<td>'.LAN_VSTORE_CUSM_022.'</td>
			</tr>
			';
		foreach ($items as $item) {
			$text .= sprintf('
			<tr>
				<td>%s</td>
				<td>%s (%d)</td>
				<td>%s</td>
			</tr>', 
				e107::getDateConvert()->convert_date($item['datestamp']),
				$item['user_name'],
				$item['user_id'],
				e107::getParser()->toHTML($item['text']));
		}
		$text .= '</table>';
		return $text;
	}

	function order_pay_gateway($curVal, $mode)
	{
		$title = vstore::getGatewayTitle($curVal);
		$text = '<span class="e-tip" title="'.$title.'" >'.vstore::getGatewayIcon($curVal, '2x') . '</span>';
		$text .= ($mode === 'write') ? ' <span class="gateway-label">' . $title.'</span>' : '';

		return $text;
	}

	function order_pay_status($curVal)
	{
		return '<span class="label label-wide label-'.self::$pay_status_classes[$curVal].'">'.ucfirst($curVal).'</span>';
	}

	function order_refund_date($curVal)
	{
		if (empty($curVal)) {
			return '---';
		}
		return e107::getDateConvert()->convert_date($curVal, 'short');
	}
}