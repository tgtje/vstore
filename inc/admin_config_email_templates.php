<?php
/**
 * Adminarea module cart
 */
e107::lan('vstore',false, true);
e107::lan('vstore',true, true);

class vstore_email_templates_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Vstore';
		protected $pluginName		= 'vstore';

		protected $preftabs = array();
		protected $prefs = array();

		public function init()
		{
			e107::wysiwyg(true);
			$defaultTemplate = e107::getTemplate('vstore', 'vstore_email');

			foreach (vstore::getEmailTypes() as $type => $label)
			{
				$this->preftabs[$type] = $label;

				$this->prefs['email_templates/'.$type.'/active']    = array('title' => LAN_ACTIVE, 'tab' => $type, 'type'=>'bool');
				$this->prefs['email_templates/'.$type.'/cc']        = array('title' => LAN_VSTORE_ADMIN_012, 'tab' => $type, 'type'=>'bool');
				$this->prefs['email_templates/'.$type.'/template']  = array('title'=>'Email Template', 'tab' => $type, 'type'=>'bbarea', 'writeParms'=>array('default'=>$defaultTemplate[$type], 'size'=>'large'));
				$this->prefs['template_options'.$type]              = array('title' => LAN_OPTIONS, 'method'=>'templateOptions', 'tab' => $type, 'data'=>false,'type'=>'method', 'writeParms'=>array('nolabel'=>true, 'templateType'=>$type, 'template'=>$defaultTemplate[$type]));

			}

		}




/*
		
		public function templatesPage()
		{
			$frm = e107::getForm();
			e107::wysiwyg(true);
	
			$orig_templates = e107::getTemplate('vstore', 'vstore_email');

	        $tab = array();

	        $curVal = e107::pref('vstore', 'email_templates');

			foreach (vstore::getEmailTypes() as $type => $label)
			{
	
				$orig_template = $orig_templates[$type];

				if (empty($curVal[$type]['template']))
				{
					$curVal = array();
					$curVal[$type]['template'] = $orig_template;
				}
				$isActive = isset($curVal[$type]['active']) ? $curVal[$type]['active'] : true;
				$isCC = isset($curVal[$type]['cc']) ? $curVal[$type]['cc'] : true;

				$text = '
				<div class="row" style="padding-top:20px">
					<div class="col-md-12 form-group">
						<label class="control-label col-3 col-xs-3">'.LAN_ACTIVE.'?</label>
						<div class="text-right col-3 col-xs-3">
						'.$frm->flipswitch('email_templates['.$type.'][active]', $isActive, null, array('switch'=>'small', 'title' => LAN_ACTIVE)).'
						</div>
						<div class="text-right col-6 col-xs-6">
							'.$frm->button('', '<span class="fa fa-undo"></span>'. LAN_VSTORE_4045, 'action', '', array('data-template' => rawurlencode($orig_template), 'data-type' => $type, 'class' => 'vstore-email-reset pull-right btn-sm', 'title' => LAN_VSTORE_4046)).'
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 form-group">
						<label class="control-label col-3 col-xs-3">'LAN_VSTORE_4047'</label>
						<div class="text-right col-3 col-xs-3">
						'.$frm->flipswitch('email_templates['.$type.'][cc]', $isCC, null, array('switch'=>'small', 'title' => LAN_VSTORE_4047)).'
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
					'.$frm->textarea('email_templates['.$type.'][template]', $curVal[$type]['template'], 10, 80, array('class' => 'tbox form-control input-block-level e-autoheight e-wysiwyg')).'
					</div>
				</div>
				';
				
	
				$tab[] = array('caption'=>$label,'text' => $text);
	
			}

			$text = $frm->open('vstore_email_templates','post');

			$text .= $frm->tabs($tab);

				$tp = e107::getParser();

			$text .= "<div class='buttons-bar row'>
				<div class='col-md-4'></div>
				<div class='col-md-4 center'>".$frm->admin_button('save', 1, 'update', LAN_UPDATE)."</div>
				<div class='col-md-4 right'><a class='btn btn-sm btn-default e-expandit' href='#leg'>".$tp->toGlyph('fa-info-circle')." "LAN_VSTORE_4048"</a></div>
				</div>";

			$text .= $frm->close();

		//	$text .= "<hr />";


			return $text;
			
		}
	
			*/
}


class vstore_email_templates_form_ui extends e_admin_form_ui
{

	public function init()
	{

        $js = "
		$(function(){
			$('.vstore-email-reset').click(function(){
				var type = $(this).data('type');
				var template = decodeURIComponent($(this).data('template'));

				var id = 'email-templates-'+type+'-template';
				$('#'+id).val(template);
				$(tinymce.get(id).getBody()).html(template);
			});
		});
		";
        e107::js('footer-inline', $js);
        
	}

	public function templateOptions($curVal, $mode, $att)
	{
		if($mode !== 'write')
		{
			return null;
		}
		$tp = e107::getParser();

		$text = $this->button('', '<span class="fa fa-undo"></span> '. LAN_VSTORE_4045, 'action', '', array('data-template' => rawurlencode($att['template']), 'data-type' => $att['templateType'], 'class' => 'vstore-email-reset btn-sm', 'title' => LAN_VSTORE_4046));
		$text .= " <a class='btn btn-sm btn-default e-expandit ' href='#leg'>".$tp->toGlyph('fa-info-circle')." ".LAN_VSTORE_4048." </a>";
		$text .= '<div id="leg" class="small" style="display:none">'.$this->renderTemplateKeys().'</div>';

		return $text;

	}

	/**
	 * @return string
	 * @todo Move to a modal pop-up or some other 'on-demand' area.
	 */
	private function renderTemplateKeys()
	{
		$email_fields = array(
			'{REF}'                        => LAN_VSTORE_4049,
			'{BILLING: firstname}'         => LAN_VSTORE_4050,
			'{BILLING: lastname}'          => LAN_VSTORE_4051,
			'{BILLING: company}'           => LAN_VSTORE_4052,
			'{BILLING: address}'           => LAN_VSTORE_4053,
			'{BILLING: city}'              => LAN_VSTORE_4054,
			'{BILLING: state}'             => LAN_VSTORE_4055,
			'{BILLING: zip}'               => LAN_VSTORE_4056,
			'{BILLING: country}'           => LAN_VSTORE_4057,
			'{SHIPPING: firstname}'        => LAN_VSTORE_4058,
			'{SHIPPING: lastname}'         => LAN_VSTORE_4059,
			'{SHIPPING: company}'          => LAN_VSTORE_4060,
			'{SHIPPING: address}'          => LAN_VSTORE_4061,
			'{SHIPPING: city}'             => LAN_VSTORE_4062,
			'{SHIPPING: state}'            => LAN_VSTORE_4063,
			'{SHIPPING: zip}'              => LAN_VSTORE_4064,
			'{SHIPPING: country}'          => LAN_VSTORE_4065,
			'{ORDER_ITEMS}'                => LAN_VSTORE_4066,
			'{ORDER_PAYMENT_INSTRUCTIONS}' => LAN_VSTORE_4067,
			'{ORDER_MERCHANT_INFO}'        => LAN_VSTORE_4068,
			'{SENDER_NAME}'                => LAN_VSTORE_4069

		);

		foreach($email_fields as $key => $value)
		{
			$field_notes[] = sprintf('<div class="col-xs-6 col-md-3 col-lg-2 label-default" style="padding:7px">%s</div><div class="col-md-2" style="padding:7px">%s</div>', $key, $value);
		}

		return implode("\n", $field_notes);


		//	$this->prefs['email_templates']['title'] = $text;


	}

}		

