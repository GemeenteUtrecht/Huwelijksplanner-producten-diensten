<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


use App\Entity\Product;

class ProductFixtureLoader extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$product = new Product();
		$product->setBronOrganisatie('123456789');
		$product->setType('simpel');
		$product->setLosLeverbaar(true);
		$product->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
		$product->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$product->setNaam('Gratis Trouwen');
		$product->setPrijsExcl(0);
		$product->setSamenvatting('Inclusief locatie & trouwambtenaar');
		$product->setBeschrijving('<ul class="tbl-prc-list">
	     	<li>Locatie: Stadskantoor Utrecht, 6e verdieping</li>
	     	<li>Maandagochtend 10 uur of 10.30 uur</li>
	     	<li>Zonder ceremonie, zonder toespraak</li>
	     	<li>Duur: tot 10 minuten</li>
	     	<li>Aantal gasten: tot 8 personen (incl. getuigen en fotograaf)</li>
	     </ul>');
		
		$manager->persist($product);
		
		$product = new Product();
		$product->setBronOrganisatie('123456789');
		$product->setType('simpel');
		$product->setLosLeverbaar(true);
		$product->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
		$product->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$product->setNaam('Eenvoudig Trouwen');
		$product->setPrijsExcl(16300);
		$product->setSamenvatting('Inclusief locatie & trouwambtenaar');
		$product->setBeschrijving('   <ul class="tbl-prc-list">
	     	<li>Locatie: Stadskantoor Utrecht, 6e verdieping</li>
	     	<li>Maandag, dinsdag, woensdag, vrijdag om 10 uur, 10.30 uur, 11 uur of 11.30 uur</li>
	     	<li>Zonder ceremonie, zonder toespraak</li>
	     	<li>Duur: tot 10 minuten</li>
	     	<li>Aantal gasten: tot 8 personen (incl. getuigen en fotograaf)  </li>
	     </ul>');
		
		$manager->persist($product);
		
		$product = new Product();
		$product->setBronOrganisatie('123456789');
		$product->setType('simpel');
		$product->setLosLeverbaar(true);
		$product->setAfbeelding('https://utrecht.trouwplanner.online/images/content/ambtenaar/erik.jpg');
		$product->setFilm('https://www.youtube.com/embed/DAaoMvj1Qbs');
		$product->setNaam('Uitgebreid Trouwen v.a.');
		$product->setPrijsExcl(49000);
		$product->setSamenvatting('vanaf prijs, exclusief locatie');
		$product->setBeschrijving('<ul class="tbl-prc-list">
	     	<li>Locatie: uw eigen keuze</li>
	     	<li>7 dagen per week, 24 uur per dag</li>
	     	<li>Ceremonie naar eigen wens in te vullen</li>
	     	<li>Overleg met trouwambtenaar</li>
	     	<li>Duur: tot 45 minuten</li>
	     	<li>Aantal gasten: afhankelijk van de gekozen locatie</li>
	     </ul>');
		
		$manager->persist($product);
		
		$manager->flush();
	}
}
