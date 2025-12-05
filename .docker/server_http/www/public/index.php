<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use WebSocket\Client;

function render($name, $params = []){
    ob_start();
    extract($params);
    include('templates/'.$name.'.phtml');
    $out1=ob_get_contents();ob_end_clean();

    $out1 = str_replace('{{LANGUAGE}}', $params['lang']??'', $out1);
    return $out1;
}

function callBot($url) {
    $client = new \WebSocket\Client("ws://botserver:8282");
    try {
        $client->text(json_encode([
            "host" => 'http://web_apache',
            "actions" => [
                 [
                    "url" => "http://web_apache/cookies_admin_6acd1465bf472"
                ],
                [ "sleep" => 2000 ],
                [
                    "url" => $url
                ],
                [ "sleep" => 2000 ]
            ],
        ]));
    } 
    catch(Exception $e){}
    finally{$client->close();}
}


if(!defined('HO_LICENSE')) {
    include(__DIR__ . '/../vendor/autoload.php');
    define('ROOT_DIR', __DIR__);
}


$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $flag = '<b>Vous devez être administrateur</b>';
    $cookies = $request->getCookieParams();

    if (isset($cookies['account']) && isset($cookies['role'])  && isset($cookies['token'])) {
        if($cookies['account'] === 'admin_trader' && $cookies['role'] === 'admin' 
            && $cookies['token'] === '1813a15ad7b985d3d03912881ff5e12db') {
            $flag = SHA1('90b98a45393db3df37de0c701a25d575dd52cf71');
        }
    }

    $content = str_replace('{{FLAG}}', $flag, render('language_choice'));
    $response->getBody()->write($content);

    return $response;
});

$app->get('/view', function (Request $request, Response $response, $args) {

    $queryParams = $request->getQueryParams();
    if (!isset($queryParams['language'])) {
        return $response->withHeader('Location', '/')->withStatus(302);
    }
    else {
        // "Sanitize" language
        $lang = str_replace(["<", ">"], '', strip_tags($queryParams['language']));
        $response->getBody()->write(render('index', ['lang' => $lang]));
    }
    return $response;
});


$app->get('/contact', function (Request $request, Response $response, $args) {
    $response->getBody()->write(render('contact'));
    return $response;
});

$app->post('/contact', function (Request $request, Response $response, $args) {
    $postData = $request->getParsedBody();    
    if (!empty($postData['url'])) {
       callBot($postData['url']);
       return $response->withHeader('Location', '/')->withStatus(302);
    } else {
        $response->withHeader('Location', '/contact')->withStatus(302);
    }
    return $response;
});


// Pour le bot
$app->get('/cookies_admin_6acd1465bf472', function (Request $request, Response $response, $args) {
    $response = $response->withAddedHeader('Set-Cookie', 'account=admin_trader; path=/');
    $response = $response->withAddedHeader('Set-Cookie', 'role=admin; path=/');
    $response = $response->withAddedHeader('Set-Cookie', 'token=1813a15ad7b985d3d03912881ff5e12db; path=/');
    $response->getBody()->write('ok');
    return $response;
});


$app->run();