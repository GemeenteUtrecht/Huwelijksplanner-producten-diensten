<?php
// api/src/Controller/CreateBookPublication.php

namespace App\Controller;

use App\Entity\Product;

class ProductController
{
	public function __invoke(Product $data): Product
	{
		//$this->bookPublishingHandler->handle($data);
		
		return $data;
	}
}