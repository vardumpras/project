<?php

namespace Alcyon\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ServiceController extends Controller
{
    /**
     * @Route("/{_locale}",
     * requirements={"_locale": "fr|it|en"},
     * name="set_local")
     */
    public function languageAction(Request $request, $_locale)
    {
        // On enregistre la langue en session
        $request->getSession()->set('_locale', $_locale);

        // on tente de rediriger vers la page d'origine
        $uri = $request->headers->get('referer');
        if (empty($uri)) {
            $uri = $this->generateUrl('homepage');
        }

        return $this->redirect($uri);
    }

    /**
     * @Route("/image/{type}/{width}/{height}/{uri}",
     * name="resizeimage",
     * requirements={"type": "fill|crop", "width": "\d+", "height": "\d+", "uri": ".+"})
     */
    public function getImageAction(Request $request, $type, $width, $height, $uri)
    {
        // Find file by uri
        $file = $this->get('alcyon_core.service.urt_to_file')->find($uri);

        // Create Response with standard http header for caching file
        $etag = md5($type . $width . $height . $uri);
        $response = (new Response())
            ->setETag($etag)
            ->setExpires((new \DateTime())->modify('+604800 seconds'))
            ->setLastModified($file->getMTime())
            ->setPublic();

        if ($response->isNotModified($request)) {
            // return the 304 Response immediately
            return $response;
        }

        // Set content disposition
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $uri
        );

        // Call resize image
        $data = $this->get('alcyon_core.service.resizeimage')->resize(
            $file->getPath() . '/' . $file->getFilename(),
            $width,
            $height,
            $this->getParameter('uploads_directory') . '/thumbs/' . $response->getEtag() . '.jpg',
            $type == 'crop'
        );

        // Add content
        $response->seContent($data);

        // Return response
        return $response;
    }

    /**
     * @Route("/media/{uri}",
     * name="media",
     * requirements={"uri"=".+"})
     */
    public function getMediaAction($uri)
    {
        // Find file by uri
        $file = $this->get('alcyon_core.service.urt_to_file')->find($uri);

        // Render file
        return $this->file($file, $uri, ResponseHeaderBag::DISPOSITION_ATTACHMENT);
    }
}