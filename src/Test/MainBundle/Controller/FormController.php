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
     * @Template("MainBundle:Example\Form:new_one_to_many.html.twig")
     */
    public function oneToManyNewAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(new UserAddressesType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha creado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{username}/edit", name="forms_edit")
     * @ParamConverter("user", class="MainBundle:User")
     * @Template("MainBundle:Example\Form:edit_one_to_many.html.twig")
     */
    public function oneToManyEditAction(User $user, Request $request)
    {
        $originalAddresses = array();

        // Create an array of the current Address objects in the database
        foreach ($user->getAddresses() as $address) {
            $originalAddresses[] = $address;
        }

        $form = $this->createForm(new UserAddressesType(), $user);

        if ($request->isMethod("POST")) {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                // filter $originalAddresses to contain adressess no longer present
                foreach ($user->getAddresses() as $address) {
                    foreach ($originalAddresses as $key => $toDel) {
                        if ($toDel->getId() === $address->getId()) {
                            unset($originalAddresses[$key]);
                        }
                    }
                }

                // remove the relationship between the address and the Task
                foreach ($originalAddresses as $address) {
                    // remove the Address from the User
                    $user->getAddresses()->removeElement($address);

                    // if you wanted to delete the Address entirely, you can also do that
                    $em->remove($address);
                }

                $em->persist($user);
                // $em->flush();

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->add('smtc_success', 'Se ha editado un usuario:');
                $flashBag->add('smtc_success', sprintf('Username: %s', $user->getUsername()));
                if (0 !== count($user->getAddresses())) {
                    $flashBag->add('smtc_success', 'Direcciones:');
                    foreach ($user->getAddresses() as $address) {
                        $flashBag->add('smtc_success', sprintf('&nbsp;&nbsp;%s (%s)', $address->getStreet(), $address->getCity()->getName()));
                    }
                }

                return $this->redirect($this->generateUrl('examples_forms'));
            }
        }

        return array(
            'form' => $form->createView(),
            'user' => $user,
        );
    }
}
