<?php

namespace Test\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Test\MainBundle\Entity\Factura;
use Test\MainBundle\Entity\Producto;
use Test\MainBundle\Form\FacturaType;
use Test\MainBundle\Form\FacturaProductosType;


/**
 * Factura controller.
 *
 * @Route("/forms")
 */
class FormController extends Controller
{
    /**
     * @Route("/", name="forms")
     * @Template()
     */
    public function formsAction(Request $request)
    {
        $facturas = $this->getDoctrine()->getManager()->getRepository("MainBundle:Factura")->findAll();

        return array('facturas' => $facturas);
    }
    
    /**
     * @Route("/new", name="forms_create")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $factura = new Factura();

        $form = $this->createForm(new FacturaProductosType(), $factura);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($factura);
                $em->flush();                

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('test_success', 'Se ha creado una Factura:');
                $flashBag->add('test_success', sprintf('Descripcion: %s', $factura->getDescripcion()));
                if (0 !== count($factura->getProductos())) {
                    $flashBag->add('test_success', 'Productos:');
                    foreach ($factura->getProductos() as $producto) {
                        $flashBag->add('test_success', sprintf('&nbsp;&nbsp;%s', $producto->getNombre()));
                    }
                }

                return $this->redirect($this->generateUrl('forms'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }
    
    /**
     * @Route("/{id}/edit", name="forms_edit")
     * @ParamConverter("factura", class="MainBundle:Factura")
     * @Template()
     */
    public function editAction(Factura $factura, Request $request)
    {
        $originalProductos = array();

        // Create an array of the current Producto objects in the database
        foreach ($factura->getProductos() as $producto) {
            $originalProductos[] = $producto;
        }

        $form = $this->createForm(new FacturaProductosType(), $factura);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                // filter $originalProductos to contain adressess no longer present
                foreach ($factura->getProductos() as $producto) {
                    foreach ($originalProductos as $key => $toDel) {
                        if ($toDel->getId() === $producto->getId()) {
                            unset($originalProductos[$key]);
                        }
                    }
                }

                // remove the relationship between the producto and the Task
                foreach ($originalProductos as $producto) {
                    // remove the Producto from the Factura
                    $factura->getProductos()->removeElement($producto);

                    // if you wanted to delete the Producto entirely, you can also do that
                    $em->remove($producto);
                }

                $em->persist($factura);
                 $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('test_success', 'Se ha editado una Factura:');
                $flashBag->add('test_success', sprintf('Descripcion: %s', $factura->getDescripcion()));
                if (0 !== count($factura->getProductos())) {
                    $flashBag->add('test_success', 'Productos:');
                    foreach ($factura->getProductos() as $producto) {
                        $flashBag->add('test_success', sprintf('&nbsp;&nbsp;%s', $producto->getNombre()));
                    }
                }

                return $this->redirect($this->generateUrl('forms'));
            }
        }

        return array(
            'form' => $form->createView(),
            'factura' => $factura,
        );
    }
    
}
