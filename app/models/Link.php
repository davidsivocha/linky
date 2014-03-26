<?php
class Link extends Eloquent {
	protected $table = 'links';
	protected $fillable = array('url', 'hash');
	public $timestamps = false;
}