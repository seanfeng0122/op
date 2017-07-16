<?php
class ControllerModuleMagikmicra extends Controller {
    private $error = array(); // This is used to set the errors, if any.
 
    public function index() {
        // Loading the language file of magikmicra
        $this->load->language('module/magikmicra'); 
     
        // Set the title of the page to the heading title in the Language file i.e., Hello World
        $this->document->setTitle(strip_tags($this->language->get('heading_title')));
     
        // Load the Setting Model  (All of the OpenCart Module & General Settings are saved using this Model )
        $this->load->model('setting/setting');
     
        // Start If: Validates and check if data is coming by save (POST) method
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

            // Parse all the coming data to Setting Model to save it in database.

            $this->model_setting_setting->editSetting('magikmicra', $this->request->post);
     
            // To display the success text on data save
            $this->session->data['success'] = $this->language->get('text_success');
     
            // Redirect to the Module Listing
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }
     
        // Assign the language data for parsing it to view
        $data['heading_title'] = $this->language->get('heading_title');
     
        $data['text_edit']    = $this->language->get('text_edit');
        $data['text_yes']    = $this->language->get('text_yes');
        $data['text_no']    = $this->language->get('text_no');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_content_top'] = $this->language->get('text_content_top');
        $data['text_content_bottom'] = $this->language->get('text_content_bottom');      
        $data['text_column_left'] = $this->language->get('text_column_left');
        $data['text_column_right'] = $this->language->get('text_column_right');
     
        $data['entry_code'] = $this->language->get('entry_code');
        $data['entry_layout'] = $this->language->get('entry_layout');
        $data['entry_position'] = $this->language->get('entry_position');
        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
     
        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');
        $data['button_add_module'] = $this->language->get('button_add_module');
        $data['button_remove'] = $this->language->get('button_remove');
         
        // This Block returns the warning if any
        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
     
        // This Block returns the error code if any
        if (isset($this->error['code'])) {
            $data['error_code'] = $this->error['code'];
        } else {
            $data['error_code'] = '';
        }     
     
        // Making of Breadcrumbs to be displayed on site
        $data['breadcrumbs'] = array();
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/magikmicra', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
          
        $data['action'] = $this->url->link('module/magikmicra', 'token=' . $this->session->data['token'], 'SSL'); // URL to be directed when the save button is pressed
     
        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'); // URL to be redirected when cancel button is pressed
              
        // This block checks, if the hello world text field is set it parses it to view otherwise get the default 
        // hello world text field from the database and parse it
        
$config_data = array(
        
        'magikmicra_address',
        'magikmicra_phone',
        'magikmicra_email',
        'magikmicra_fb',
        'magikmicra_twitter',
        'magikmicra_gglplus',
        'magikmicra_rss',
        'magikmicra_pinterest',
        'magikmicra_linkedin',
        'magikmicra_youtube',
        'magikmicra_powerby',
        'magikmicra_home_option',
        'magikmicra_quickview_button',
        'magikmicra_scroll_totop',
        'magikmicra_sale_label',
        'magikmicra_sale_labeltitle',
        'magikmicra_sale_labelcolor',
        'magikmicra_menubar_cb',
        'magikmicra_menubar_cbtitle',
        'magikmicra_menubar_cbcontent',
        'magikmicra_vmenubar_cb',
        'magikmicra_vmenubar_cbtitle',
        'magikmicra_vmenubar_cbcontent',
        'magikmicra_product_ct',
        'magikmicra_product_cttitle',
        'magikmicra_product_ctcontent',
        'magikmicra_product_ct2',
        'magikmicra_product_ct2title',
        'magikmicra_product_ct2content',
        'magikmicra_newsletter',
        'magikmicra_newslettercontent',
        'magikmicra_footer_cb',
        'magikmicra_footer_cbcontent',
        'magikmicra_body_bg',
        'magikmicra_body_bg_ed',
        'magikmicra_fontcolor',
        'magikmicra_fontcolor_ed',
        'magikmicra_linkcolor',
        'magikmicra_linkcolor_ed',
        'magikmicra_linkhovercolor',
        'magikmicra_linkhovercolor_ed',
        'magikmicra_headerbg',
        'magikmicra_headerbg_ed',
        'magikmicra_headerlinkcolor',
        'magikmicra_headerlinkcolor_ed',
        'magikmicra_headerlinkhovercolor',
        'magikmicra_headerlinkhovercolor_ed',
        'magikmicra_headerclcolor',
        'magikmicra_headerclcolor_ed',
        'magikmicra_mmbgcolor',
        'magikmicra_mmbgcolor_ed',
        'magikmicra_mmlinkscolor',
        'magikmicra_mmlinkscolor_ed',
        'magikmicra_mmlinkshovercolor',
        'magikmicra_mmlinkshovercolor_ed',
        'magikmicra_mmslinkscolor',
        'magikmicra_mmslinkscolor_ed',
        'magikmicra_mmslinkshovercolor',
        'magikmicra_mmslinkshovercolor_ed',
        'magikmicra_buttoncolor',
        'magikmicra_buttoncolor_ed',
        'magikmicra_buttonhovercolor',
        'magikmicra_buttonhovercolor_ed',
        'magikmicra_pricecolor',
        'magikmicra_pricecolor_ed',
        'magikmicra_oldpricecolor',
        'magikmicra_oldpricecolor_ed',
        'magikmicra_newpricecolor',
        'magikmicra_newpricecolor_ed',
        'magikmicra_footerbg',
        'magikmicra_footerbg_ed',
        'magikmicra_footerlinkcolor',
        'magikmicra_footerlinkcolor_ed',
        'magikmicra_footerlinkhovercolor',
        'magikmicra_footerlinkhovercolor_ed',
        'magikmicra_powerbycolor',
        'magikmicra_powerbycolor_ed',
        'magikmicra_fonttransform',
        'magikmicra_productpage_cb',
        'magikmicra_productpage_cbcontent',
        'magikmicra_ffb_ed',
        'magikmicra_ffb_content',
        'magikmicra_maintenancedate',
        'magikmicra_animation_effects'
        );

foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $data[$conf] = $this->request->post[$conf];
                
            } else {
                $data[$conf] = $this->config->get($conf);

            }
        } 

 
   
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/magikmicra.tpl', $data));

    }

    /* Function that validates the data when Save Button is pressed */
    protected function validate() {
 
        // Block to check the user permission to manipulate the module
        if (!$this->user->hasPermission('modify', 'module/magikmicra')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
 
        /* End Block*/
 
        // Block returns true if no error is found, else false if any error detected
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
}