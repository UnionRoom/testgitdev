<?php

class UR_SiteNavigationElement {

	public $items = array();
	public $context = "https:\/\/schema.org\/";
	public $type = "SiteNavigationElement";
	public $url = "";

	public function __construct() {
		$this->url = site_url();
	}

	public function strip_url($url){
		$output = str_replace($this->url, '', $url);
		return $output;
	}

	public function add_item($name, $url){
		if($name != '') {
			$this->items[] = array(
				'name' => $name,
				'url'  => $this->strip_url( $url )
			);
		}
	}

	public function render_preview(){
		$output = '';
		if(count($this->items) > 0){
			$output .= '[';
			$count = 0;
			foreach ($this->items as $item){
				$output .= '
   {
       "@context": "<code>'.$this->context.'</code>", '.($count == 0 ? '<code class="comments">//Type of schema</code>' : '').'
       "@type": "<code>'.$this->type.'</code>", '.($count == 0 ? '<code class="comments">//Schema type3</code>' : '').'
       "name":"<code>'.$item['name'].'</code>", '.($count == 0 ? '<code class="comments">//Menu item inner html</code>' : '').'
       "url" : "<code>'.$this->url.$item['url'].'</code>" '.($count == 0 ? '<code class="comments">//Menu item href</code>' : '').'
   }'.($count != (count($this->items)-1) ? ',' : '
');
				$count++;
			}
			$output .=']';
			echo $output;
		}else{
			return false;
		}
	}

	public function render(){
		$output = '';
		if(count($this->items) > 0){
			$output .= '<script type="application/ld+json">[';
			$count = 0;
			foreach ($this->items as $item){
				$output .= '{
				"@context": "'.$this->context.'",
				"@type": "'.$this->type.'",
				"name":"'.$item['name'].'",
				"url" : "'.$this->url.$item['url'].'"
				}'.($count != (count($this->items)-1) ? ',' : '');
				$count++;
			}
			$output .= ']</script>';
			echo $output;
		}else{
			return false;
		}
	}

}
