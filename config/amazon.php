<?php

return [

	/**
	 * Your access key.
	 */
	'access_key' => env('AMAZON_ACCESS_KEY', 'AKIAIS6GFHYX2U3N4PRA'),

	/**
	 * Your secret key.
	 */
	'secret_key' => env('AMAZON_SECRET_KEY', 'bVtANzsbDBBM+VYxrb9msa6ZPaErjOx7p4mPhpam'),

	/**
	 * Your affiliate associate tag.
	 */
	'associate_tag' => env('AMAZON_ASSOCIATE_TAG', ''),

	/**
	 * Preferred locale
	 */
	'locale' => env('AMAZON_LOCALE', 'co.uk'),

	/**
	 * Preferred response group
	 */
	'response_group' => env('AMAZON_RESPONSE_GROUP', 'Images')


];