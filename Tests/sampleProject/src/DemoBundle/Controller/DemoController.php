<?php

namespace EveryCheck\TestApiRestBundle\Tests\sampleProject\src\DemoBundle\Controller;

use EveryCheck\TestApiRestBundle\Tests\sampleProject\src\DemoBundle\Entity\Demo;
use EveryCheck\TestApiRestBundle\Tests\sampleProject\src\DemoBundle\Form\DemoType;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Demo controller.
 *
 * @Route("demo")
 */
class DemoController extends Controller
{
    /**
     * Lists all demo entities.
     *
     * @Route("", name="demo_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $demos = $em->getRepository(Demo::class)->findAll();

		$serializer = $this->get('jms_serializer');
		$response = $serializer->serialize($demos, 'json', SerializationContext::create()->setGroups(array('Default')));

        return new Response($response, 200, ['Content-Type'=>"application/json"]);
    }

    /**
     * Creates a new demo entity.
     *
     * @Route("/new", name="demo_new", methods={"POST"})
     */
    public function newAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $demo = new Demo();
        $form = $this->createForm(DemoType::class, $demo);
        $form->submit($data);

        if(!$form->isValid())
        {
            return $this->badRequest("Invalid form");
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($demo);
        $em->flush();

		$serializer = $this->get('jms_serializer');

        $response = $serializer->serialize($demo, 'json', SerializationContext::create()->setGroups(array('Default')));
        return new Response($response, 201, ['Content-Type'=>"application/json"]);
    }


    /**
     * Creates a new demo entity via multipart form.
     *
     * @Route("/multipart", name="demo_multipart", methods={"POST"})
     */
    public function multipartAction(Request $request)
    {
		$serializer = $this->get('jms_serializer');
        $response = $serializer->serialize($request->request->all(), 'json', SerializationContext::create()->setGroups(array('Default')));
        return new Response($response, 201, ['Content-Type'=>"application/json"]);
    }

    /**
     * Deletes a demo entity.
     *
     * @Route("/{id}", name="demo_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $demo = $em->getRepository(Demo::class)->find($id);


        if(empty($demo))
        {
            return $this->notFound();
        }

        $em->remove($demo);
        $em->flush();
        return new Response('', 204, ['Content-Type'=>"application/json"]);
    }

	/**
	 * Returns the cookies send in the request.
	 *
	 * @Route("/cookies", name="get_cookies", methods={"GET"})
	 */
	public function getCookiesAction(Request $request)
	{
		$cookies = $request->cookies->all();
		return new Response(json_encode($cookies), 200, ['Content-Type'=>"application/json"]);
	}

    private function notFound()
    {
        return new Response("The resource you asked doesn't exist", 404, ['Content-Type'=>"application/json"]);
    }

    private function badRequest($message)
    {
        return new Response($message, 400, ['Content-Type'=>"application/json"]);
    }
}
