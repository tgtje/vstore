<?php


$VSTORE_DASHBOARD_TEMPLATE = array();


$VSTORE_DASHBOARD_TEMPLATE['header'] = '
    <h3>{DASHBOARD: title}</h3>

    {DASHBOARD: nav}
    <br />
    <div>
';

$VSTORE_DASHBOARD_TEMPLATE['footer'] = '
    </div>
';

/**
 * Dashboard navigation
 */
$VSTORE_DASHBOARD_TEMPLATE['nav']['start'] = '
	<ul class="nav nav-tabs">';
$VSTORE_DASHBOARD_TEMPLATE['nav']['end'] = '
	</ul>
';
$VSTORE_DASHBOARD_TEMPLATE['nav']['item'] = '
		<li role="presentation" class="nav-item [active]"><a class="nav-link" href="[url]">[caption]</a></li>';


/**
 * Dashboard
 */
$VSTORE_DASHBOARD_TEMPLATE['dashboard'] = '
    <p>{LAN=VSTORE_2027}</p>
';


/**
 * List orders
 */
$VSTORE_DASHBOARD_TEMPLATE['order']['list']['header'] = '
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>{LAN=VSTORE_4016}</th>
        <th>{LAN=VSTORE_4017}</th>
        <th>{LAN=VSTORE_ADMIN_111}</th>
        <th>{LAN=VSTORE_ADMIN_4018}</th>
        <th>{LAN=STATUS}</th>
        <th>{LAN=VSTORE_4021}</th>
    </tr>
    </thead>
    <tbody>
';


$VSTORE_DASHBOARD_TEMPLATE['order']['list']['footer'] = '
    </tbody>
    </table>
';


$VSTORE_DASHBOARD_TEMPLATE['order']['list']['item'] = '
    <tr>
        <td>
            {LAN=VSTORE_4011}: {ORDER_DATA: order_date}<br />
            {LAN=VSTORE_4012}: {ORDER_DATA: order_ref}<br/>
            {LAN=VSTORE_4013}: {ORDER_DATA: order_invoice_nr}
        </td>
        <td>{ORDER_DATA: order_shipping_full}</td>
        <td>{ORDER_DATA: order_items_short}</td>
        <td>{ORDER_DATA: order_pay_amount}</td>
        <td>{ORDER_DATA: order_status_label}</td>
        <td>{ORDER_ACTIONS}</td>
    </tr>
';


/**
 * Order detail
 */
$VSTORE_DASHBOARD_TEMPLATE['order']['detail'] = '
    <h4>{LAN=VSTORE_4024} {ORDER_DATA: order_ref} <span class="pull-right float-right">{ORDER_DATA: order_status_label}</span></h4>
    <div class="clearfix">
        <div class="col-sm-4">
            <b>{LAN=VSTORE_4011}</b> {ORDER_DATA: order_date}<br />
            <b>{LAN=VSTORE_4012}</b> {ORDER_DATA: order_ref}<br/>
            <b>{LAN=VSTORE_4013}</b> {ORDER_DATA: order_invoice_nr}<br/>
            <b>{LAN=VSTORE_4014}</b> {ORDER_DATA: order_gateway}<br/>
            <b>{LAN=VSTORE_4015}</b> {ORDER_DATA: order_pay_status}<br/>
        </div>

        <div class="col-sm-4">
            <b>{LAN=VSTORE_3018}</b> <br />
            {ORDER_DATA: order_shipping_full}<br/>
        </div>

        <div class="col-sm-4">
            <b>{LAN=VSTORE_4010}</b> <br />
            {ORDER_DATA: order_billing_full}<br/>
        </div>
    </div>

    <br />

    <div>
        <b>{LAN=VSTORE_ADMIN_111}</b>
        {ORDER_ITEMS}
    </div>

    <div>
        <b>{LAN=VSTORE_ADMIN_110}</b>
        {ORDER_DATA: order_log}
    </div>

    <hr />

    <div class="text-center">
        {ORDER_ACTIONS: cancel}
    </div>
';


/**
 * List downloads
 */
$VSTORE_DASHBOARD_TEMPLATE['download']['list']['header'] = '
    <table class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>{LAN=VSTORE_4016}</th>
        <th>{LAN=VSTORE_ADMIN_111}</th>
        <th>{LAN=STATUS}</th>
    </tr>
    </thead>
    <tbody>
';


$VSTORE_DASHBOARD_TEMPLATE['download']['list']['footer'] = '
    </tbody>
    </table>
';


$VSTORE_DASHBOARD_TEMPLATE['download']['list']['item'] = '
    <tr>
        <td>
            {LAN_VSTORE_4011}: {ORDER_DATA: order_date}<br />
            {LAN_VSTORE_4012}: {ORDER_DATA: order_ref}<br/>
            {LAN_VSTORE_4013}: {ORDER_DATA: order_invoice_nr}
        </td>
        <td>{ORDER_DATA: order_downloads}</td>
        <td>{ORDER_DATA: order_status_label}</td>
    </tr>
';


/**
 * List downloads
 */
$VSTORE_DASHBOARD_TEMPLATE['address']['view'] = '
	<div class="row">
	    <div class="col-12 col-xs-12 col-sm-6">
	    	<div class="card h-100">
		        <div class="card-body">
			        <h4 class="card_title">{LAN=VSTORE_4022}</h4>
			
			        {DASHBOARD: billing_address}
			        
			    </div>
			     <div class="card-footer text-right text-end">
			        {DASHBOARD: edit_billing}
			     </div>
		     </div>
	    </div>
	
	    <div class="col-12 col-xs-12 col-sm-6">
	    <div class="card h-100">
	    		<div class="card-body">
		        <h4 class="card_title">{LAN=VSTORE_4017}</h4>
		
		        {DASHBOARD: shipping_address}
			      
		        </div>
		          <div class="card-footer text-right text-end">
			        {DASHBOARD: edit_shipping}
			      </div>
	        </div>
	    </div>
    </div>

';


/**
 * Shipping details form
 */
$VSTORE_DASHBOARD_TEMPLATE['address']['edit']['shipping']['body'] = '
	<h4>{LAN=VSTORE_4025}</h4>

	<div class="row g-3">
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_firstname" class="form-label required">{LAN=VSTORE_3001}</label>
				{SHIPPING_FIELD: ship_firstname}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_lastname" class="form-label required">{LAN=VSTORE_3002}</label>
				{SHIPPING_FIELD: ship_lastname}
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col col-xs-12">
			<div class="form-group">
				<label for="ship_company" class="form-label">{LAN=VSTORE_3003}</label>
				{SHIPPING_FIELD: ship_company}
			</div>
		</div>

		<div class="col col-xs-12">
			<div class="form-group">
				<label for="ship_address" class="form-label required">{LAN=VSTORE_3006}</label>
				{SHIPPING_FIELD: ship_address}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_city" class="form-label required">{LAN=VSTORE_3007}</label>
				{SHIPPING_FIELD: ship_city}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_state" class="form-label required">{LAN=VSTORE_3008}</label>
				{SHIPPING_FIELD: ship_state}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_zip" class="form-label required">{LAN=VSTORE_3009}</label>
				{SHIPPING_FIELD: ship_zip}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="ship_country" class="form-label required">{LAN=VSTORE_3010}</label>
				{SHIPPING_FIELD: ship_country}
			</div>
		</div>

		<div class="col col-xs-12">
			<div class="form-group">
				<label for="ship_phone" class="form-label">{LAN=VSTORE_3014}</label>
				{SHIPPING_FIELD: ship_phone}
			</div>
		</div>

		<div class="col-12 col-xs-12">
			<div class="form-group">
				<label class="required"></label> {LAN=VSTORE_3013}
			</div>
		</div>
	</div>
    ';
    

/**
 * Customer details form
 */
$VSTORE_DASHBOARD_TEMPLATE['address']['edit']['billing']['body'] = '
	<h4>{LAN=VSTORE_4010}</h4>

	<div class="row g-3">
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_firstname" class="form-label required">{LAN=VSTORE_3001}</label>
				{CUSTOMER_FIELD: cust_firstname}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_lastname" class="form-label required">{LAN=VSTORE_3002}</label>
				{CUSTOMER_FIELD: cust_lastname}
			</div>
		</div>

		<div class="col col-xs-12">
			<div class="form-group">
				<label for="cust_company" class="form-label">{LAN=VSTORE_3003}</label>
				{CUSTOMER_FIELD: cust_company}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_vat_id" class="form-label">{LAN=VSTORE_3004}</label>
				{CUSTOMER_FIELD: cust_vat_id}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_taxcode" class="form-label">{LAN=VSTORE_3005}</label>
				{CUSTOMER_FIELD: cust_taxcode}
			</div>
		</div>

		<div class="col col-xs-12">
			<div class="form-group">
				<label for="cust_address" class="form-label required">{LAN=VSTORE_3006}</label>
				{CUSTOMER_FIELD: cust_address}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_city" class="form-label required">{LAN=VSTORE_3007}</label>
				{CUSTOMER_FIELD: cust_city}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_state" class="form-label">{LAN=VSTORE_3008}</label>
				{CUSTOMER_FIELD: cust_state}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_zip" class="form-label required">{LAN=VSTORE_3009}</label>
				{CUSTOMER_FIELD: cust_zip}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_country" class="form-label required">{LAN=VSTORE_3010}</label>
				{CUSTOMER_FIELD: cust_country}
			</div>
		</div>

		<div class="col-12 col-xs-12">
			<div class="form-group">
				<label for="cust_email" class="form-label required">{LAN=VSTORE_3012}</label>
				{CUSTOMER_FIELD: cust_email}
			</div>
		</div>

		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_phone" class="form-label">{LAN=VSTORE_3014}</label>
				{CUSTOMER_FIELD: cust_phone}
			</div>
		</div>
		<div class="col-12 col-xs-12 col-sm-6">
			<div class="form-group">
				<label for="cust_email" class="form-label">{LAN=VSTORE_3015}</label>
				{CUSTOMER_FIELD: cust_fax}
			</div>
		</div>


	{CUSTOMER_FIELD: add_field0}

	{CUSTOMER_FIELD: add_field1}
	
	{CUSTOMER_FIELD: add_field2}
	
	{CUSTOMER_FIELD: add_field3}


		<div class="col-12 col-xs-12">
			<div class="form-group">
				<label class="required"></label> {LAN=VSTORE_3013}
			</div>
		</div>
	</div>
';

$VSTORE_DASHBOARD_TEMPLATE['address']['edit']['billing']['additional']['item'] = '

		<div class="col-12 col-md-12">
			<div class="form-group">
				{CUSTOMER_ADD_LABEL}
				{CUSTOMER_ADD_FIELD}
			</div>
		</div>

';
    