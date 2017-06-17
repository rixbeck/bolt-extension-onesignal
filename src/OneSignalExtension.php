<?php

namespace Bolt\Extension\RixBeck\OneSignal;

use Bolt\Asset\Snippet\Snippet;
use Bolt\Asset\Target;
use Bolt\Extension\SimpleExtension;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExtensionName extension class.
 *
 * @author Rix Beck <rix@boltcms.hu>
 */
class OneSignalExtension extends SimpleExtension
{
    const JS_ONESIGNALSDKUPDATERWORKER = 'OneSignalSDKUpdaterWorker.js';
    const JS_ONESIGNALSDKWORKER = 'OneSignalSDKWorker.js';

    public function callbackSnippet()
    {
        $options = $this->getConfig()['init'];
        $initSnippet = $this->renderTemplate('widget/init.twig', ['options' => json_encode($options)]);

        return <<<SNIPPET
        <link rel="manifest" href="/{$this->getWebDirectory()->getPath()}/manifest.json">
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
        {$initSnippet}
SNIPPET;
    }

    public function serveScript($js)
    {
        $script = $this->getWebDirectory()->getFile($js);
        $content = $script->read();

        return new Response($content, Response::HTTP_OK, ['Content-Type' => 'application/javascript']);
    }

    public function serveManifest()
    {
        $defaults = [
            "gcm_sender_id" => "482941778795",
            "DO_NOT_CHANGE_GCM_SENDER_ID" => "Do not change the GCM Sender ID",
        ];

        $manifest = array_merge($this->getConfig()['manifest'], $defaults);

        return new Response($manifest, Response::HTTP_OK, ['Content-type' => 'application/json']);
    }

    protected function registerTwigPaths()
    {
        return ['templates'];
    }

    protected function registerAssets()
    {
        $osLoaderSnippet = new Snippet();
        $osLoaderSnippet->setCallback([$this, 'callbackSnippet'])
            ->setPriority(5)
            ->setLocation(Target::AFTER_META);

        return [
            $osLoaderSnippet,
        ];
    }

    protected function registerFrontendRoutes(ControllerCollection $collection)
    {
        $collection->match(
            '/'.self::JS_ONESIGNALSDKUPDATERWORKER,
            function () {
                return $this->serveScript(self::JS_ONESIGNALSDKUPDATERWORKER);
            }
        );

        $collection->match(
            '/'.self::JS_ONESIGNALSDKWORKER,
            function () {
                return $this->serveScript(self::JS_ONESIGNALSDKWORKER);
            }
        );

        $webPath = $this->getWebDirectory()->getPath();
        $collection->match("/{$webPath}/manifest.json", [$this, 'serveManifest']);
    }
}
