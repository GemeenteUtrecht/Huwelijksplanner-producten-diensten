<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
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
 *         		"summary" = "Versie herstellen",
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
	 * De unieke identificatie van dit object binnen de organisatie die dit object heeft gecreëerd. <br /><b>Schema:</b> <a href="https://schema.org/identifier">https://schema.org/identifier</a>
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
	 *             "description"="De unieke identificatie van dit object de organisatie die dit object heeft gecreëerd.",
	 *             "maxLength"=40,
	 * 			   "summary" = "Haal de identificatie van een product op"
	 *         }
	 *     }
	 * )
	 * @Gedmo\Versioned
	 */
	public $identificatie;
	
	/**
	 * Het RSIN van de organisatie waartoe dit product behoort. Dit moet een geldig RSIN zijn van 9 nummers en voldoen aan https://nl.wikipedia.org/wiki/Burgerservicenummer#11-proef. <br> Het RSIN wordt bepaald aan de hand van de geauthenticeerde applicatie en kan niet worden overschreven.
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
	 * De naam van dit product. <br /><b>Schema:</b> <a href="https://schema.org/name">https://schema.org/name</a>
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
	 * Een korte samenvattende tekst over dit Product bedoeld ter introductie.  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
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
	 * Een uitgebreide beschrijvende tekst over dit Product bedoeld ter verdere verduidelijking.  <br /><b>Schema:</b> <a href="https://schema.org/description">https://schema.org/description</a>
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
	 * @var string het type van de product. <br/> **simpel**: Een normaal product <br/> **samengesteld**: Een verzameling van andere producten die als set worden aangeboden <br/> **virtueel**: Een niet fysiek (bijvoorbeeld downloadbaar) product <br/> **extern**: Een product van een externe leverancier <br/> **kaartje**: Een toegangsbewijs <br/> **variabel**: Een product dat bestaat uit variaties die (fysiek) eigen producten zijn b.v. een t-shirt in verschillende kleuren <br/> **abonnement**: Een terugkerende betaling <br/> **dienst**: Een product dat moet worden uitgevoerd door een ambtenaar 
	 * @ORM\Column
	 * @ApiProperty(
	 *     attributes={
	 *         "openapi_context"={
	 *             "type"="string",
	 *             "enum"={"simpel", "samengesteld", "virtueel","extern","kaartje","variabel","abonnement","dienst"},
	 *             "example"="simpel",
	 *             "required"="true"
	 *         }
	 *     }
	 * )
	 * @Assert\NotBlank
	 * @Assert\Choice(
	 *     choices = { "simpel", "samengesteld", "virtual","external","ticket","variable","subscription"},
	 *     message = "Choose either simpel,samengesteld,virtual,external,ticket,variable or subscription"
	 * )
	 * @ApiFilter(SearchFilter::class, strategy="exact")
	 * @ApiFilter(OrderFilter::class)
	 * @Groups({"read", "write"})
	 */
	public $type;
	
	/**
	 * De producten die als extra op dit product bestelbaar zijn b.v. een opdruk op een glas of t-shirt.
	 *
	 * @var \Doctrine\Common\Collections\Collection|App\Entity\Product[]
	 *
	 * @Groups({"read"})
	 * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="leverbaarBij")
     * @ORM\JoinTable(name="product_extra")
	 * @ApiProperty(
	 * )
	 *
	 */
	public $extras;
	
	/**
	 * @var App\Entity\Product[] Producten waarbij dit product leverbaar is als extra.
	 *
	 * @MaxDepth(1)
	 * @ApiProperty()
	 * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="extras")
	 */
	public $leverbaarBij;
	
	/**
	 * @var App\Entity\Product[] (alleen toepasbaar bij product type samengesteld) Producten die onderdeel uitmaken van dit product. eg: Een set van 6 verschillende glazen.
	 *
	 * @MaxDepth(1)
	 * @ApiProperty()
	 * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="sets")
     * @ORM\JoinTable(name="product_product")
	 */
	public $producten;
	
	/**
	 * @var App\Entity\Product[] De sets (samengestelde producten) waar dit product in voorkomt.
	 *
	 * @MaxDepth(1)
	 * @ApiProperty()
	 * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="producten")
	 */
	public $sets;
	
	/**
	 * @var App\Entity\Product[]  (alleen toepasbaar bij product type variabel) De verschillende variaties van het product, elke variatie is een uniek product met eigen prijst en vooraad beheer. b.v. een t-shirt met verschillende maten en kleuren.
	 * 
	 * @MaxDepth(1)
	 * @ApiProperty()
	 * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="moeder")
	 */
	public $variaties;
	
	/**
	 * @var Organisation (alleen toepasbaar bij product type simpel) Het product waarvan dit product een variatie is b.v. een bepaalde kleur van een t-shirt
	 *
	 * @MaxDepth(1)
	 * @ApiProperty()
	 * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="variaties")
	 */
	public $moeder;
		
	/**
	 * Is dit product los leverbaar, kan bijvoorbeeld "false" zijn bij producten die alleen als extra op of variatie van een ander product voorkomen. In dat geval kan het product niet direct gekocht worden, maar alleen via het product waar het een extra of variatie van is. 
	 *
	 * @Groups({"read","write"})
	 * @ApiFilter(BooleanFilter::class)
	 * @ApiFilter(OrderFilter::class)
	 * @ORM\Column(type="boolean")
	 */
	public $losLeverbaar;
	
	/**
	 * @var integer De niet-decimale waarde voor de prijs van dit product (exclusief btw).
	 *
	 * @ORM\Column(type="integer", 
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read", "write"})
	 */
	public $prijsExcl = 0;
	
	/**
	 * @var integer Het percentage van de belasting op dit product, in percentage dus 1% = 1, en niet 0,01.
	 *
	 * @ORM\Column(type="integer", 
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read", "write"})
	 */
	public $belastingPercentage = 0;
	
	/**
	 * @var integer De niet-decimale waarde voor de belasting van dit product.
	 *
	 * @ORM\Column(type="integer", 
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read"})
	 */
	public $prijsBelasting = 0;
	
	/**
	 * @var integer De niet-decimale waarde voor de prijs van dit product (inclusief btw).
	 *
	 * @ORM\Column(type="integer", 
	 *     nullable=true)
	 * @Assert\Type(
	 *     type="integer",
	 *     message="The value {{ value }} is not a valid {{ type }}."
	 * )
	 * @Groups({"read"})
	 */
	public $prijsIncl = 0;
	
	/**
	 * @var string De basisvaluta van dit product.
	 *
	 * @ORM\Column(length=64, 
	 *     nullable=true)
	 * @Assert\Currency
	 * @Groups({"read", "write"})
	 */
	public $valuta = "EUR";
	
	/**
	 * Eerstvolgende datum waarop dit product beschikbaar is.
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
	 * )
	 *
	 */
	public $groepen;
		
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
	 * Ambtenaren die bij dit product horen.
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
	 *         }
	 *     }
	 * )
	 */
	public $ambtenaren;	
	
	/**
	 * De taal waarin de informatie van dit product is opgesteld. <br /><b>Schema:</b> <a href="https://www.ietf.org/rfc/rfc3066.txt">https://www.ietf.org/rfc/rfc3066.txt</a>
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
	 * Het tijdstip waarop dit Product object is aangemaakt.
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
	 * De contactpersoon voor dit Product.
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
	 * Met eigenaar wordt bijgehouden welke  applicatie verantwoordelijk is voor het object, en daarvoor de rechten beheert en uitgeeft. De eigenaar kan dan ook worden gezien in de trant van autorisatie en configuratie in plaats van als onderdeel van het datamodel.
	 *
	 * @var App\Entity\Applicatie $eigenaar
	 *
	 * @Gedmo\Blameable(on="create")
	 * @ORM\ManyToOne(targetEntity="App\Entity\Applicatie")
	 * @Groups({"read"})
	 */
	public $eigenaar;

    public function __construct()
    {
        $this->extras = new ArrayCollection();
        $this->leverbaarBij = new ArrayCollection();
        $this->producten = new ArrayCollection();
        $this->sets = new ArrayCollection();
        $this->variaties = new ArrayCollection();
        $this->groepen = new ArrayCollection();
    }
	
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

    public function getAfbeelding(): ?string
    {
        return $this->afbeelding;
    }

    public function setAfbeelding(?string $afbeelding): self
    {
        $this->afbeelding = $afbeelding;

        return $this;
    }

    public function getFilm(): ?string
    {
        return $this->film;
    }

    public function setFilm(?string $film): self
    {
        $this->film = $film;

        return $this;
    }

    public function getIdentificatie(): ?string
    {
        return $this->identificatie;
    }

    public function setIdentificatie(?string $identificatie): self
    {
        $this->identificatie = $identificatie;

        return $this;
    }

    public function getBronOrganisatie(): ?int
    {
        return $this->bronOrganisatie;
    }

    public function setBronOrganisatie(int $bronOrganisatie): self
    {
        $this->bronOrganisatie = $bronOrganisatie;

        return $this;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getSamenvatting(): ?string
    {
        return $this->samenvatting;
    }

    public function setSamenvatting(string $samenvatting): self
    {
        $this->samenvatting = $samenvatting;

        return $this;
    }

    public function getBeschrijving(): ?string
    {
        return $this->beschrijving;
    }

    public function setBeschrijving(string $beschrijving): self
    {
        $this->beschrijving = $beschrijving;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLosLeverbaar(): ?bool
    {
        return $this->losLeverbaar;
    }

    public function setLosLeverbaar(bool $losLeverbaar): self
    {
        $this->losLeverbaar = $losLeverbaar;

        return $this;
    }

    public function getPrijsExcl(): ?int
    {
        return $this->prijsExcl;
    }

    public function setPrijsExcl(?int $prijsExcl): self
    {
        $this->prijsExcl = $prijsExcl;

        return $this;
    }

    public function getBelastingPercentage(): ?int
    {
        return $this->belastingPercentage;
    }

    public function setBelastingPercentage(?int $belastingPercentage): self
    {
        $this->belastingPercentage = $belastingPercentage;

        return $this;
    }

    public function getPrijsBelasting(): ?int
    {
        return $this->prijsBelasting;
    }

    public function setPrijsBelasting(?int $prijsBelasting): self
    {
        $this->prijsBelasting = $prijsBelasting;

        return $this;
    }

    public function getPrijsIncl(): ?int
    {
        return $this->prijsIncl;
    }

    public function setPrijsIncl(?int $prijsIncl): self
    {
        $this->prijsIncl = $prijsIncl;

        return $this;
    }

    public function getValuta(): ?string
    {
        return $this->valuta;
    }

    public function setValuta(?string $valuta): self
    {
        $this->valuta = $valuta;

        return $this;
    }

    public function getBeschikbaar(): ?\DateTimeInterface
    {
        return $this->beschikbaar;
    }

    public function setBeschikbaar(\DateTimeInterface $beschikbaar): self
    {
        $this->beschikbaar = $beschikbaar;

        return $this;
    }

    public function getLocaties(): ?array
    {
        return $this->locaties;
    }

    public function setLocaties(?array $locaties): self
    {
        $this->locaties = $locaties;

        return $this;
    }

    public function getAmbtenaren(): ?array
    {
        return $this->ambtenaren;
    }

    public function setAmbtenaren(?array $ambtenaren): self
    {
        $this->ambtenaren = $ambtenaren;

        return $this;
    }

    public function getTaal(): ?string
    {
        return $this->taal;
    }

    public function setTaal(string $taal): self
    {
        $this->taal = $taal;

        return $this;
    }

    public function getRegistratiedatum(): ?\DateTimeInterface
    {
        return $this->registratiedatum;
    }

    public function setRegistratiedatum(\DateTimeInterface $registratiedatum): self
    {
        $this->registratiedatum = $registratiedatum;

        return $this;
    }

    public function getWijzigingsdatum(): ?\DateTimeInterface
    {
        return $this->wijzigingsdatum;
    }

    public function setWijzigingsdatum(?\DateTimeInterface $wijzigingsdatum): self
    {
        $this->wijzigingsdatum = $wijzigingsdatum;

        return $this;
    }

    public function getContactPersoon(): ?string
    {
        return $this->contactPersoon;
    }

    public function setContactPersoon(?string $contactPersoon): self
    {
        $this->contactPersoon = $contactPersoon;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getExtras(): Collection
    {
        return $this->extras;
    }

    public function addExtra(Product $extra): self
    {
        if (!$this->extras->contains($extra)) {
            $this->extras[] = $extra;
        }

        return $this;
    }

    public function removeExtra(Product $extra): self
    {
        if ($this->extras->contains($extra)) {
            $this->extras->removeElement($extra);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getLeverbaarBij(): Collection
    {
        return $this->leverbaarBij;
    }

    public function addLeverbaarBij(Product $leverbaarBij): self
    {
        if (!$this->leverbaarBij->contains($leverbaarBij)) {
            $this->leverbaarBij[] = $leverbaarBij;
            $leverbaarBij->addExtra($this);
        }

        return $this;
    }

    public function removeLeverbaarBij(Product $leverbaarBij): self
    {
        if ($this->leverbaarBij->contains($leverbaarBij)) {
            $this->leverbaarBij->removeElement($leverbaarBij);
            $leverbaarBij->removeExtra($this);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducten(): Collection
    {
        return $this->producten;
    }

    public function addProducten(Product $producten): self
    {
        if (!$this->producten->contains($producten)) {
            $this->producten[] = $producten;
        }

        return $this;
    }

    public function removeProducten(Product $producten): self
    {
        if ($this->producten->contains($producten)) {
            $this->producten->removeElement($producten);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getSets(): Collection
    {
        return $this->sets;
    }

    public function addSet(Product $set): self
    {
        if (!$this->sets->contains($set)) {
            $this->sets[] = $set;
            $set->addProducten($this);
        }

        return $this;
    }

    public function removeSet(Product $set): self
    {
        if ($this->sets->contains($set)) {
            $this->sets->removeElement($set);
            $set->removeProducten($this);
        }

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getVariaties(): Collection
    {
        return $this->variaties;
    }

    public function addVariaty(Product $variaty): self
    {
        if (!$this->variaties->contains($variaty)) {
            $this->variaties[] = $variaty;
            $variaty->setMoeder($this);
        }

        return $this;
    }

    public function removeVariaty(Product $variaty): self
    {
        if ($this->variaties->contains($variaty)) {
            $this->variaties->removeElement($variaty);
            // set the owning side to null (unless already changed)
            if ($variaty->getMoeder() === $this) {
                $variaty->setMoeder(null);
            }
        }

        return $this;
    }

    public function getMoeder(): ?self
    {
        return $this->moeder;
    }

    public function setMoeder(?self $moeder): self
    {
        $this->moeder = $moeder;

        return $this;
    }

    /**
     * @return Collection|Groep[]
     */
    public function getGroepen(): Collection
    {
        return $this->groepen;
    }

    public function addGroepen(Groep $groepen): self
    {
        if (!$this->groepen->contains($groepen)) {
            $this->groepen[] = $groepen;
        }

        return $this;
    }

    public function removeGroepen(Groep $groepen): self
    {
        if ($this->groepen->contains($groepen)) {
            $this->groepen->removeElement($groepen);
        }

        return $this;
    }

    public function getEigenaar(): ?Applicatie
    {
        return $this->eigenaar;
    }

    public function setEigenaar(?Applicatie $eigenaar): self
    {
        $this->eigenaar = $eigenaar;

        return $this;
    }
}
