<?php

namespace Test\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Producto
 *
 * @ORM\Table(name="producto")
 * @ORM\Entity
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="precio", type="string", length=255)
     */
    private $precio;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp_inicio", type="datetime")
     */
    private $timestampInicio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Test\MainBundle\Entity\Factura", inversedBy="productos")
     * @ORM\JoinColumn(name="factura_id", referencedColumnName="id")
     */
    private $factura;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Producto
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set precio
     *
     * @param string $precio
     * @return Producto
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    
        return $this;
    }

    /**
     * Get precio
     *
     * @return string 
     */
    public function getPrecio()
    {
        return $this->precio;
    }
    
    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Producto
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    
        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }
    
     /**
     * Set timestampInicio
     *
     * @param \DateTime $timestampInicio
     * @return Producto
     */
    public function setTimestampInicio($timestampInicio)
    {
        $this->timestampInicio = $timestampInicio;
    
        return $this;
    }

    /**
     * Get timestampInicio
     *
     * @return \DateTime 
     */
    public function getTimestampInicio()
    {
        return $this->timestampInicio;
    }
    
    /**
     * Set factura
     *
     * @param  \Test\MainBundle\Entity\Factura $factura
     * @return Producto
     */
    public function setFactura(\Test\MainBundle\Entity\Factura $factura = null)
    {
        $this->factura = $factura;

        return $this;
    }

    /**
     * Get factura
     *
     * @return \Test\MainBundle\Entity\Factura
     */
    public function getFactura()
    {
        return $this->factura;
    }
}
