<?php

class SchemaCache {
	protected $cid = 'form_DrupalRCE';
	protected $bin = 'cache_form';
	protected $keysToPersist = ['#form_id'=>true, '#process'=>true, '#attached'=>true];
	protected $storage = ['#form_id'=>'DrupalRCE','#process'=>['drupal_process_attached'], '#attached'=>[]];

	public function __construct($function,$parameter) {
		$this->storage['#attached']+=[$function=>[[$parameter]]];
	}
}