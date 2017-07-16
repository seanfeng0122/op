<?php
class ControllerModuleCategoryProductSlider extends Controller {
	
	public function index($setting) {
	

		static $module = 0;

		$this->load->language('module/category_product_slider');

		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');

		//category wise Products
		$data['categorywise_products1'] = array();
	
		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}

		$data = array('filter_category_id' => $setting['category_name'],'limit'=> $setting['limit'],'start'=>'0');
		$results = $this->model_catalog_product->getProducts($data);


		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
			} else {
				$image = false;
			}
						
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
					
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
			
			if ($this->config->get('config_review_status')) {
				$rating = $result['rating'];
			} else {
				$rating = false;
			}
			

			$data['categorywise_products'][] = array(
				'product_id' => $result['product_id'],
				'thumb'   	 => $image,
				'name'    	 => $result['name'],
				'price'   	 => $price,
				'special' 	 => $special,
				'rating'     => $rating,
				'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
				'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id']),
			);
		}

		//get name of category
		$this->load->model('catalog/category');
		$category_result = $this->model_catalog_category->getCategory($setting['category_name']);		
		$data['category_name'] = NULL;
		$data['category_name'] = $category_result['name'];
		$data['heading_title'] = $this->language->get('heading_title');
		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');
		$data['no_product_found'] = $this->language->get('no_product_found');

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/category_product_slider.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/category_product_slider.tpl', $data);
			} else {
				return $this->load->view('default/template/module/category_product_slider.tpl', $data);
			}

		/*$this->render();*/
	}
}
?>