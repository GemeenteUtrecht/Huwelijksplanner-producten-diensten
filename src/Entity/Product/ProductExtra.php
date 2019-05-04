<?php

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * product extra
 * 
 * Beschrijving
 * 
 * @category   	Entity
 *
 * @author     	Ruben van der Linde <ruben@conduction.nl>
 * @license    	EUPL 1.2 https://opensource.org/licenses/EUPL-1.2 *
 * @version    	1.0
 *
 * @link   		http//:www.conduction.nl
 * @package		Common Ground
 * @subpackage  Producten en Diensten
 * 
 * @ApiResource
 * @ORM\Entity
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"identificatie", "bronOrganisatie"},
 *     message="De identificatie dient uniek te zijn voor de bronOrganisatie"
 * )
 */

class ProductExtra
{
	
	/**
	 * Het identificatie nummer van deze product extra <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 *
	 * @var int|null
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", options={"unsigned": true})
	 * @Groups({"read", "write"})
	 * @ApiProperty(iri="https://schema.org/identifier")
	 **/
	public $id;
	
	/**
	 * URL-referentie naar het afbeeldings document
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van dit persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $afbeelding;
	
	/**
	 * URL-referentie naar het film document
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="BRP",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de BRP inschrijving van dit persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $film;
	
	
	/**
	 * De unieke identificatie van het huwelijk binnen de organisatie die verantwoordelijk is voorafhandeling vna de huwelijks aanvraag
	 *
	 * @var string
	 * @ORM\Column(
	 *     type     = "string"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="6a36c2c4-213e-4348-a467-dfa3a30f64aa",
	 *             "description"="De unieke identificatie van het huwelijk binnen de organisatie die verantwoordelijk is voorafhandeling vna de huwelijks aanvraag.",
	 *             "required"="true",
	 *             "maxLength"=40
	 *         }
	 *     }
	 * )
	 */
	public $identificatie;
	
	/**
	 * Het RSIN van de organisatie waartoe deze Ambtenaar behoord. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef. <br> Het RSIN word bepaald aan de hand van de gauthenticeerde applicatie en kan niet worden overschreven
	 *
	 * @var integer
	 * @ORM\Column(
	 *     type     = "integer",
	 *     length   = 9
	 * )
	 * @Assert\Length(
	 *      min = 8,
	 *      max = 9,
	 *      minMessage = "Het RSIN moet ten minste {{ limit }} karakters lang zijn",
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read"})
	 * @ApiFilter(SearchFilter::class, strategy="exact")
	 * @ApiFilter(OrderFilter::class)
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="bronOrganisatie",
	 *             "type"="string",
	 *             "example"="123456789",
	 *             "required"="true",
	 *             "maxLength"=9,
	 *             "minLength"=8
	 *         }
	 *     }
	 * )
	 */
	public $bronOrganisatie;
	
	/**
	 * De naam van deze locatie <br /><b>Schema:</b> <a href="https://schema.org/name">https://schema.org/name</a>
	 *
	 * @var string
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 255
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 5,
	 *      max = 255,
	 *      minMessage = "De naam moet ten minste {{ limit }} karakters lang zijn",
	 *      maxMessage = "De naam kan niet langer dan {{ limit }} karakters zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "example"="Een mooie locatie"
     *         }
     *     }
	 * )
	 **/
	public $naam;
	
	/**
	 * Een samenvattende tekst over deze locatie  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Your first name must be at least {{ limit }} characters long",
	 *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="Deze prachtige locatie is zeker het aanbevelen waard"
	 *         }
	 *     }
	 * )
	 **/
	public $samenvatting;
	
	/** 
	 * Een beschrijvende tekst over deze locatie  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
	 *
	 * @var string
	 *
	 * @ORM\Column(
	 *     type     = "text"
	 * )
	 * @Assert\NotNull
	 * @Assert\Length(
	 *      min = 25,
	 *      max = 2000,
	 *      minMessage = "Your first name must be at least {{ limit }} characters long",
	 *      maxMessage = "Your first name cannot be longer than {{ limit }} characters")
	 *
	  * @ApiProperty(
	 * 	  iri="https://schema.org/description",	 
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "example"="Deze prachtige locatie is zeker het aanbevelen waard"
     *         }
     *     }
	 * )
	 **/
	public $beschrijving;
	
	
	/**
	 * @var integer The non decimal value for the price of this product (excluding tax)
	 *
	 * @ORM\Column(type="integer",
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read", "write"})
	 */
	public $exclAmount = 0;
	
	/**
	 * @var integer The the percentage of the on this product, in percentage so 1% = 1, and not 0,01
	 *
	 * @ORM\Column(type="integer",
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read", "write"})
	 */
	public $taxPercentage = 0;
	
	/**
	 * @var integer The non decimal value for the tax o this product
	 *
	 * @ORM\Column(type="integer",
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read"})
	 */
	public $taxAmount = 0;
	
	/**
	 * @var integer The non decimal value for the price of this product (including tax)
	 *
	 * @ORM\Column(type="integer",
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read"})
	 */
	public $inclAmount = 0;
	
	/**
	 * @var string The base currency of this product
	 *
	 * @ORM\Column(length=64,
	 *     nullable=true)
	 * @Assert\Currency
	 * @Groups({"read", "write"})
	 */
	public $currency = "EUR";
		
	/**
	 * De taal waarin de informatie van deze locatie is opgesteld <br /><b>Schema:</b> <a href="https://www.ietf.org/rfc/rfc3066.txt">https://www.ietf.org/rfc/rfc3066.txt</a>
	 *
	 * @var string Een Unicode language identifier, ofwel RFC 3066 taalcode.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 2
	 * )
	 * @Assert\Language
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="NL"
	 *         }
	 *     }
	 * )
	 **/
	public $taal = "nl";
	
	/**
	 * De producten de bij deze product groep horen
	 *
	 * @var \Doctrine\Common\Collections\Collection|\App\Entity\Product[]
	 *
	 * @ORM\ManyToMany(targetEntity="\App\Entity\Product", mappedBy="extras")
	 * @Groups({"read"})
	 *
	 */
	public $producten;
	
	/**
	 * Add Product
	 *
	 * @param  \App\Entity\Product $product
	 * @return Order
	 */
	public function addProduct(\App\Entity\Product $product)
	{
		$this->products[] = $product;
		
		return $this;
	}
	
	/**
	 * Remove Product
	 *
	 * @param \App\Entity\Product $product
	 */
	public function removeProduct(\App\Entity\Product $product)
	{
		$this->products->removeElement($product);
	}
	
	/**
	 * Get Product
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getProducts()
	{
		return $this->products;
	}
}
