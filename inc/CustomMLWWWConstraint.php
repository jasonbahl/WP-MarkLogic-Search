<?php


namespace MarkLogic\WpSearch;

/**
 * Represents a custom custom constraint for search.
 *
 * @package MLPHP
 * @author Seong Bae <seong.bae@marklogic.com>
 */
class CustomMLWWWConstraint extends \MarkLogic\MLPHP\AbstractConstraint
{
    private $elem; // @var string
    private $ns; // @var string
    private $attr; // @var string
    private $attrNs; // @var string
    private $datatype; // @var string
    private $facet; // @var bool
    private $buckets; // @var array
    private $parse;
    private $start;
    private $finish;
    private $libLocation; // @var string
    protected $fragmentScope; // @var string
    protected $facetOptions; // @var array

    /**
     * Create a RangeConstraint object.
     *
     * @see http://docs.marklogic.com/search:search#opt-constraint
     *
     * @param string $name Constraint name.
     * @param string $datatype Constraint datatype.
     * @param string $facet Whether constraint should be faceted ('true' or 'false').
     * @param string $elem Name of the element.
     * @param string $ns Element namespace.
     * @param string $attr Attribute name.
     * @param string $attrNs An attribute namespace.
     */
    public function __construct(
        $name, $datatype, $facet = 'true', $elem, $ns = '', $attr = '', $attrNs = '', $parse, $start, $finish, $libLocation = ''
    )
    {
        $this->elem = (string)$elem;
        $this->ns = (string)$ns;
        $this->attr = (string)$attr;
        $this->attrNs = (string)$attrNs;
        $this->datatype = (string)$datatype;
        $this->facet = (string)$facet;
        $this->buckets = array();
        $this->parse = (string)$parse;
        $this->start = (string)$start;
        $this->finish = (string)$finish;
        $this->libLocation = (string)$libLocation;

        parent::__construct($name);
    }

    /**
     * Get the constraint as a DOMElement object.
     *
     * @param DOMDocument $dom The DOMDocument object with which to create the element.
     */
    public function getAsElem($dom)
    {
        $constElem = $dom->createElement('constraint');
        $constElem->setAttribute('name', $this->name);
        $customElem = $dom->createElement('custom');
        $customElem->setAttribute('facet', $this->facet);
        
        $elemElem = $dom->createElement('parse');
        $elemElem->setAttribute('apply', $this->parse);
        $elemElem->setAttribute('ns', $this->ns);
        $elemElem->setAttribute('at', $this->libLocation);
        $customElem->appendChild($elemElem);

        $elemElem = $dom->createElement('start-facet');
        $elemElem->setAttribute('apply', $this->start);
        $elemElem->setAttribute('ns', $this->ns);
        $elemElem->setAttribute('at', $this->libLocation);
        $customElem->appendChild($elemElem);

        $elemElem = $dom->createElement('finish-facet');
        $elemElem->setAttribute('apply', $this->finish);
        $elemElem->setAttribute('ns', $this->ns);
        $elemElem->setAttribute('at', $this->libLocation);
        $customElem->appendChild($elemElem);

        $constElem->appendChild($customElem);
    /* <constraint name='rating'>
               <range type='xs:decimal'>
                   <element ns='http://example.com' name='rating'/>
               </range>
           </constraint> */
        return $constElem;
    }
}
