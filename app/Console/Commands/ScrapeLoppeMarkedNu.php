<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class ScrapeLoppeMarkedNu extends Command
{

	protected $signature = 'scrape:loppemarked.nu';
	protected $description = 'Command description';
	protected $links = [];
	protected $BASE_URL = 'http://www.loppemarked.nu/';
	private $pageOffset = 0;
	private $maxPageOffset = 0;
	private $collections = [];
	private $client;
	private $crawler;
	private $itemTitle;

	public function __construct()
	{
		parent::__construct();

		$this->client = new Client();
		$this->crawler = $this->client->request('GET', $this->BASE_URL);
	}

	public function handle()
	{
		$this->collectIds();
		$this->collectDataFromSinglePages();


		dd($this->collections);

	}


	private function collectIds()
	{
		$this->crawler->filter('a.ai1ec-read-more.ai1ec-load-event')->each(function ($node) {
			array_push($this->links, $node->attr('href'));
		});

		$this->goToNextPage();
	}

	private function goToNextPage()
	{

		if ($this->pageOffset === $this->maxPageOffset) {
			return;
		}
		$this->pageOffset++;

		dump('Navigating to page ' . $this->pageOffset);

		$url = $this->BASE_URL . 'calendar/action~agenda/page_offset~' . $this->pageOffset . '/';
		$this->crawler = $this->client->request('GET', $url);
		$this->collectIds();
	}


	private function collectDataFromSinglePages()
	{
		foreach ($this->links as $link) {
			$crawler = $this->client->request('GET', $link);

			$title = explode('–', $this->getNodeBySelector($crawler, 'h1.post-title')[0]);
			$this->itemTitle = trim($title[0]);
			$phone = preg_replace("/[^0-9]/", "", $this->getNodeBySelector($crawler, '.ai1ec-contact-phone'));
			$data = [
				'title' => $this->getNodeBySelector($crawler, 'h1.post-title'),
				'address' => $this->getAddress($crawler),
				'phone' => strlen($phone) > 0 ? $phone : null,
				'description' => $this->getNodeBySelector($crawler, '.post-content .body'),
				// 'when' => $this->getWhen($crawler),
			];

			array_push($this->collections, $data);
		}

	}

	private function getAddress($crawler)
	{
		return $crawler->filter('.ai1ec-location .p-location')->each(function ($node) {
			$ADDRESS = [];
			$address = str_replace(["\r", "\n", "\t"], '|', trim($node->text()));
			$addressArray = explode('|', $address);

			// If the first line of the address matches the title of the place remove it
			if ($addressArray[0] === $this->itemTitle) {
				unset($addressArray[0]);
			}

			// The address has been cleaned when $addressArray has 3 entries
			if (count($addressArray) === 3) {
				foreach ($addressArray as $value) {
					array_push($ADDRESS, $value);
				}

				$addressAsString = $ADDRESS[0] . ', ' . $ADDRESS[1];
				$url = 'https://debitoor-address.herokuapp.com/api/parse?countryCode=DK&address=' . $addressAsString;

				$guzzleClient = new GuzzleClient();
				$request = $guzzleClient->get($url);

				$body = json_decode($request->getBody());
				if ($request->getStatusCode() === 200) {
					return collect([
						'street' => $body->street,
						'number' => $body->streetNumber,
						'city' => $body->city,
						'zipCode' => $body->postalCode,
						'country' => $body->country,
						'longitude' => $body->location->lon,
						'latitude' => $body->location->lat,
					]);
				}
				return null;
			}
			return null;
		});
	}

	private function getNodeBySelector($crawler, $selector)
	{
		$content = $crawler->filter($selector)->each(function ($node) {
			return trim($node->text());
		});

		if ($content) {
			return $content[0];
		}
		return;
	}

	private function getWhen($crawler)
	{
		return $crawler->filter('.ai1ec-time .ai1ec-field-value.dt-duration')->each(function ($node) {
			$dateAndTime = str_replace(["\r", "\n", "\t", "Repeats"], '', $node->text());
			$dateAndTimeArray = explode(" @ ", $dateAndTime);
			$time = explode(' – ', $dateAndTimeArray[1]);

			return [
				'date' => \Carbon\Carbon::parse($dateAndTimeArray[0]),
				'time' => [
					'start' => $time[0],
					'end' => $time[1],
				],
			];
		});
	}

}
