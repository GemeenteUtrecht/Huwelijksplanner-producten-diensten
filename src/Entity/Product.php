<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ActivityLogBundle\Entity\Interfaces\StringableInterface;


/**
 * Product
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
 *  @ApiResource( 
 *  collectionOperations={
 *  	"get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/producten",
 *  		"openapi_context" = {
 * 				"summary" = "Haalt een verzameling van producten op"
 *  		}
 *  	},
 *  	"post"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/producten",
 *  		"openapi_context" = {
 * 					"summary" = "Maak een product aan"
 *  		}
 *  	}
 *  },
 * 	itemOperations={
 *     "get"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/producten/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Haal een specifiek product op"
 *  		}
 *  	},
 *     "put"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/producten/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Vervang een specifiek product"
 *  		}
 *  	},
 *     "delete"={
 *  		"normalizationContext"={"groups"={"read"}},
 *  		"denormalizationContext"={"groups"={"write"}},
 *      	"path"="/producten/{id}",
 *  		"openapi_context" = {
 * 				"summary" = "Verwijder een specifiek product"
 *  		}
 *  	},
 *     "log"={
 *         	"method"="GET",
 *         	"path"="/producten/{id}/log",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Logboek inzien",
 *         		"description" = "Geeft een array van eerdere versies en wijzigingen van dit object",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	}
 *         }
 *     },
 *     "revert"={
 *         	"method"="POST",
 *         	"path"="/producten/{id}/revert/{version}",
 *          "controller"= HuwelijkController::class,
 *     		"normalization_context"={"groups"={"read"}},
 *     		"denormalization_context"={"groups"={"write"}},
 *         	"openapi_context" = {
 *         		"summary" = "Versie teruggedraaien",
 *         		"description" = "Herstel een eerdere versie van dit object. Dit is een destructieve actie die niet ongedaan kan worden gemaakt",
 *          	"consumes" = {
 *              	"application/json",
 *               	"text/html",
 *            	},
 *             	"produces" = {
 *         			"application/json"
 *            	}
 *         }
 *     }
 *  }
 * )
 * @ORM\Entity
 * @Gedmo\Loggable(logEntryClass="ActivityLogBundle\Entity\LogEntry")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *     fields={"identificatie", "bronOrganisatie"},
 *     message="De identificatie dient uniek te zijn voor de bronOrganisatie"
 * )
 */
class Product implements StringableInterface
{
	/**
	 * Het identificatienummer van dit product <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 * 
	 * @var int|null
	 *
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", options={"unsigned": true})
	 * @Groups({"read"})
	 * @ApiProperty(iri="https://schema.org/identifier")
	 */
	private $id;
	
	/**
	 * URL-referentie naar het afbeeldings document.
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
	 *             "description"="URL-referentie naar de BRP inschrijving van deze persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $afbeelding;
	
	/**
	 * URL-referentie naar het film document.
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
	 *             "description"="URL-referentie naar de BRP inschrijving van deze persoon"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $film;
	
	/**
	 * De unieke identificatie van dit object binnen de organisatie die dit object heeft gecreeerd. <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
	 *
	 * @var string
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 40,
	 *     nullable=true
	 * )
	 * @Assert\Length(
	 *      max = 40,
	 *      maxMessage = "Het RSIN kan niet langer dan {{ limit }} tekens zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "example"="6a36c2c4-213e-4348-a467-dfa3a30f64aa",
	 *             "description"="De unieke identificatie van dit object de organisatie die dit object heeft gecreeerd.",
	 *             "maxLength"=40,
	 * 			   "summary" = "Haal de identificatie van een product op"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $identificatie;
	
	/**
	 * Het RSIN van de organisatie waartoe dit product behoord. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef. <br> Het RSIN word bepaald aan de hand van de gauthenticeerde applicatie en kan niet worden overschreven
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
	 * De naam van dit product <br /><b>Schema:</b> <a href="https://schema.org/name">https://schema.org/name</a>
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
	 *      minMessage = "De naam moet tenminste {{ limit }} tekens lang zijn",
	 *      maxMessage = "De naam kan niet langer dan {{ limit }} tekens zijn"
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="Gratis trouwen"
	 *         }
	 *     }
	 * )
	 **/
	public $naam;
	
	/**
	 * Een samenvattende tekst over dit product  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
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
	 *      minMessage = "De samenvatting moet minimaal {{ limit }} tekens bevatten",
	 *      maxMessage = "De samenvatting mag maximaal {{ limit }} tekens bevatten")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="Dit product is zeker het aanbevelen waard"
	 *         }
	 *     }
	 * )
	 **/
	public $samenvatting;
	
	/**
	 * Een beschrijvende tekst over dit product  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
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
	 *      minMessage = "De beschrijving moet minimaal {{ limit }} tekens bevatten",
	 *      maxMessage = "De beschrijving mag maximaal {{ limit }} tekens bevatten")
	 *
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 * 	  iri="https://schema.org/description",
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="Dit prachtige product is zeker de moeite waard"
	 *         }
	 *     }
	 * )
	 **/
	public $beschrijving;
	
	/**
	 * URL-referentie naar de agenda van dit product
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri",
	 *             "description"="URL-referentie naar de agenda van dit product"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $agenda;
	
	
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
	 * Eerste volgende datum waarop dit product beschikbaar is.
	 * 
	 * @var string Een "Y-m-d H:i:s" waarde bijv. "2018-12-31 13:33:05" ofwel "Jaar-dag-maan uur:minut:seconde"
	 * @Gedmo\Timestampable(on="create")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime"
	 * )
	 * @Groups({"read"})
	 */
	public $beschikbaar;
	
	/**
	 * De product groepen waartoe dit product behoort.
	 *
	 * @var \Doctrine\Common\Collections\Collection|\App\Entity\Groep[]
	 *
	 * @Groups({"read"})
	 * @ORM\ManyToMany(targetEntity="\App\Entity\Groep", inversedBy="producten")
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="groepen",
	 *             "type"="array",
	 *             "example"="[]",
	 *             "description"="Producten die bij deze locatie horen"
	 *         }
	 *     }
	 * )
	 *
	 */
	public $groepen;
	
	/**
	 * De product extras die voor dit product beschikbaar zijn.
	 *
	 * @var \Doctrine\Common\Collections\Collection|\App\Entity\Extra[]
	 *
	 * @Groups({"read"})
	 * @ORM\ManyToMany(targetEntity="\App\Entity\Extra", inversedBy="producten")
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="extras",
	 *             "type"="array",
	 *             "example"="[]",
	 *             "description"="Producten die bij deze locatie horen"
	 *         }
	 *     }
	 * )
	 *
	 */
	public $extras;	
	
	/**
	 * Locaties die bij dit product horen.
	 *
	 * @var array
	 * @ORM\Column(
	 *  	type="array",
	 *  	nullable=true
	 *  )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="locaties",
	 *             "type"="array",
	 *             "example"="[]",
	 *             "description"="Producten die bij deze locatie horen"
	 *         }
	 *     }
	 * )
	 */
	public $locaties;
	
	/**
	 * Ambtenaren die bij dit product horen
	 *
	 * @var array
	 * @ORM\Column(
	 *  	type="array",
	 *  	nullable=true
	 *  )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="ambtenaren",
	 *             "type"="array",
	 *             "example"="[]",
	 *             "description"="Producten die bij deze locatie horen"
	 *         }
	 *     }
	 * )
	 */
	public $ambtenaren;	
	
	/**
	 * De taal waarin de informatie van deze locatie is opgesteld <br /><b>Schema:</b> <a href="https://www.ietf.org/rfc/rfc3066.txt">https://www.ietf.org/rfc/rfc3066.txt</a>
	 *
	 * @var string Een Unicode language identifier, ofwel RFC 3066 taalcode.
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     length   = 2
	 * )
	 * @Groups({"read", "write"})
	 * @Assert\Language
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *             "type"="string",
	 *             "example"="NL"
	 *         }
	 *     }
	 * )
	 **/
	public $taal = 'nl';
	
	/**
	 * Het tijdstip waarop dit Product object is aangemaakt
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="create")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime"
	 * )
	 * @Groups({"read"})
	 */
	public $registratiedatum;
	
	/**
	 * Het tijdstip waarop dit Product object voor het laatst is gewijzigd.
	 *
	 * @var string Een "Y-m-d H:i:s" waarde bijvoorbeeld "2018-12-31 13:33:05" ofwel "Jaar-dag-maand uur:minuut:seconde"
	 * @Gedmo\Timestampable(on="update")
	 * @Assert\DateTime
	 * @ORM\Column(
	 *     type     = "datetime",
	 *     nullable	= true
	 * )
	 * @Groups({"read"})
	 */
	public $wijzigingsdatum;
	
	/**
	 * Het contact persoon voor dit Product
	 *
	 * @ORM\Column(
	 *     type     = "string",
	 *     nullable = true
	 * )
	 * @Groups({"read", "write"})
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "title"="Contactpersoon",
	 *             "type"="url",
	 *             "example"="https://ref.tst.vng.cloud/zrc/api/v1/zaken/24524f1c-1c14-4801-9535-22007b8d1b65",
	 *             "required"="true",
	 *             "maxLength"=255,
	 *             "format"="uri"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $contactPersoon;
	
	/**
	 * Met eigenaar wordt bijgehouden welke  applicatie verantwoordelijk is voor het object, en daarvoor de rechten beheerd en uitgeeft. In die zin moet de eigenaar dan ook worden gezien in de trant van autorisatie en configuratie in plaats van als onderdeel van het datamodel
	 *
	 * @var App\Entity\Applicatie $eigenaar
	 *
	 * @Gedmo\Blameable(on="create")
	 * @ORM\ManyToOne(targetEntity="App\Entity\Applicatie")
	 * @Groups({"read"})
	 */
	public $eigenaar;
	
	/**
	 * @return string
	 */
	public function toString(){
		return $this->naam;
	}
	
	/**
	 * Vanuit rendering perspectief (voor bijvoorbeeld logging of berichten) is het belangrijk dat we een entiteit altijd naar string kunnen omzetten.
	 */
	public function __toString()
	{
		return $this->toString();
	}
	
	/**
	 * The pre persist function is called when the enity is first saved to the database and allows us to set some additional first values
	 *
	 * @ORM\PrePersist
	 */
	public function prePersist()
	{
		$this->registratieDatum = new \ Datetime();
		// We want to add some default stuff here like products, productgroups, paymentproviders, templates, clientGroups, mailinglists and ledgers
		return $this;
	}
	
	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUrl()
	{
		return 'http://producten_en_diensten.demo.zaakonline.nl/producten/'.$this->id;
	}
}
