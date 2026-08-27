<?php 
	require  "vendor/autoload.php";

	use GuzzleHttp\Client;
	use Sunra\PhpSimple\HtmlDomParser;

		$client = new Client([
		    'headers' => [ 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'
		    ]
		]);

		$URL = "http://www.transparencia.pmmc.com.br/funcionalismopublico/salarios";

		$html = $client->request("GET",$URL)->getBody();
		$dom = HtmlDomParser::str_get_html($html);

		foreach ($dom->find("meta[itemprop=url]") as $key => $link) {
			echo $link->content.PHP_EOL;
		}

?>